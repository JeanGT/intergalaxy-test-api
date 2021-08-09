<?php

namespace App\Http\Controllers;

use App\Models\Receipt;
use App\Models\User;
use App\Services\TimesheetService;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReceiptController extends Controller
{
    protected $user;
    protected $timesheet_service;
    private const MONTH_FORMAT = 'm/Y';
    private const FIRST_DAY_FORMAT = 'Y-m-01 00:00:00';
    private const LAST_DAY_FORMAT = 'Y-m-t 23:59:59';

    public function __construct(TimesheetService $timesheet_service)
    {
        $this->user = $this->guard()->user();
        $this->timesheet_service = $timesheet_service;
    }

    //Receipts that you generated for another user
    public function generatedReceipts(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'referring_month' => 'date',
            'employee_id' => 'integer',
        ]);

        if ($validator->fails())
            return response()->json($validator->errors(), 400);

        $receipts = $this->user->generatedReceipts();

        if ($request->referring_month) {
            $referring_month = new DateTime($request->referring_month);
            $receipts->whereDate('referring_month', $referring_month->format(self::FIRST_DAY_FORMAT));
        }

        if ($request->employee_id)
            $receipts->where('employee_id', $request->employee_id);

        return response()->json($receipts->get());
    }

    //Receipts that you received from an admin
    public function myReceipts()
    {
        $receipts = $this->user->myReceipts()->get();
        return response()->json($receipts);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_id' => 'required|integer',
            'referring_month' => 'required|date'
        ]);

        if ($validator->fails())
            return response()->json($validator->errors(), 400);

        $referring_month = new DateTime($request->referring_month);

        $first_day_of_month = $referring_month->format(self::FIRST_DAY_FORMAT);
        $last_day_of_month = $referring_month->format(self::LAST_DAY_FORMAT);

        $employee = User::findOrFail($request->employee_id);

        $worked_hours = $this->timesheet_service->totalHours($request->employee_id, $first_day_of_month, $last_day_of_month);

        if ($worked_hours <= 0)
            return response()->json(['message' => 'No timesheets found for this employee in this month'], 400);

        $money_amount = $worked_hours * $employee->hourly_price;

        $data = $request->all();

        $data['employer_id'] = $this->user->id;
        $data['money_amount'] = $money_amount;
        $data['referring_month'] = $first_day_of_month;

        $receipt = Receipt::create($data);

        if (!$receipt)
            return response()->json(['message' => 'Error while creating receipt.'], 500);

        $pdf_data = [
            'id' => $receipt->id,
            'employer_name' => $this->user->name,
            'employer_cpf' => $this->user->cpf,
            'employee_name' => $employee->name,
            'employee_cpf' => $employee->cpf,
            'money_amount' => number_format($money_amount, 2),
            'month' => $referring_month->format(self::MONTH_FORMAT),
            'is_duplicate' => false,
        ];

        return $this->pdfReceipt($pdf_data);
    }

    public function duplicate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_id' => 'integer' . ($this->user->hasRole('admin') ? '|required' : ''),
            'referring_month' => 'required|date',
        ]);

        if ($validator->fails())
            return response()->json($validator->errors(), 400);

        $employee_id = $this->user->hasRole('admin') ? $request->employee_id : $this->user->id;

        $referring_month = new DateTime($request->referring_month);

        $duplicate = Receipt::whereDate('referring_month', $referring_month->format(self::FIRST_DAY_FORMAT))
            ->where('employee_id', $employee_id)
            ->orderBy('created_at', 'desc')
            ->firstOrFail();

        $employee = User::findOrFail($employee_id);
        $employer = User::findOrFail($duplicate->employer_id);

        $pdf_data = [
            'id' => $duplicate->id,
            'employer_name' => $employer->name,
            'employer_cpf' => $employer->cpf,
            'employee_name' => $employee->name,
            'employee_cpf' => $employee->cpf,
            'money_amount' => number_format($duplicate->money_amount, 2),
            'month' => (new DateTime($duplicate->referring_month))->format(self::MONTH_FORMAT),
            'is_duplicate' => true,
        ];

        return $this->pdfReceipt($pdf_data);
    }

    protected function guard()
    {
        return Auth::guard();
    }

    private function pdfReceipt($pdf_data)
    {
        $pdf = App::make('dompdf.wrapper');

        $pdf->loadHTML(view('receipt', $pdf_data)->render());

        return $pdf->stream();
    }
}
