<?php

namespace App\Http\Controllers;

use App\Models\Timesheet;
use App\Models\User;
use App\Services\TimesheetService;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TimesheetController extends Controller
{
    protected $user;
    protected $timesheet_service;
    private const DATE_FORMAT = 'Y-m-d H:i:s';

    public function __construct(TimesheetService $timesheet_service)
    {
        $this->user = $this->guard()->user();
        $this->timesheet_service = $timesheet_service;
    }

    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_id' => 'integer'
        ]);

        if ($validator->fails())
            return response()->json($validator->errors(), 400);

        $user = $this->user;
        if ($user->hasRole('admin') && $request->employee_id)
            $user = User::findOrFail($request->employee_id);

        $timesheets = $user->timesheets()->get();
        return response()->json($timesheets);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'start_time' => 'required|date',
            'end_time' => 'required|date',
            'employee_id' => 'integer'
        ]);

        if ($validator->fails())
            return response()->json($validator->errors(), 400);

        $start_time = new DateTime($request->start_time);
        $end_time = new DateTime($request->end_time);
        if (!$end_time->diff($start_time)->invert)
            return response()->json(['message' => 'End time must be greater than start time'], 400);

        $timesheet = new Timesheet();
        $timesheet->start_time = $start_time->format(self::DATE_FORMAT);
        $timesheet->end_time = $end_time->format(self::DATE_FORMAT);

        $user = $this->user;
        if ($user->hasRole('admin') && $request->employee_id)
            $user = User::findOrFail($request->employee_id);

        if (!$user->timesheets()->save($timesheet))
            return response()->json(['message' => 'Error while creating timesheet.'], 400);

        return response()->json($timesheet);
    }

    public function update(Request $request, Timesheet $timesheet)
    {
        $validator = Validator::make($request->all(), [
            'start_time' => 'required|date',
            'end_time' => 'required|date',
            'employee_id' => 'integer'
        ]);

        if ($validator->fails())
            return response()->json($validator->errors(), 400);

        //Stops non-admin user from updating timesheet from another user
        if ($this->user->hasRole('user') && $timesheet->user_id != $this->user->id)
            return response()->json(['message' => 'Unauthorized'], 401);

        $start_time = new DateTime($request->start_time);
        $end_time = new DateTime($request->end_time);
        if (!$end_time->diff($start_time)->invert)
            return response()->json(['message' => 'End time must be greater than start time'], 400);

        $timesheet->start_time = $start_time->format(self::DATE_FORMAT);
        $timesheet->end_time = $end_time->format(self::DATE_FORMAT);

        $user = $this->user;
        if ($user->hasRole('admin') && $request->employee_id)
            $user = User::findOrFail($request->employee_id);

        if (!$user->timesheets()->save($timesheet))
            return response()->json(['message' => 'Error while updating timesheet.'], 500);

        return response()->json($timesheet);
    }

    public function destroy(Timesheet $timesheet)
    {
        //stops user from deleting timesheet from another user
        if ($this->user->hasRole('user') && $timesheet->user_id != $this->user->id)
            return response()->json(['message' => 'Unauthorized'], 401);

        if (!$timesheet->delete())
            return response()->json(['message' => 'Error while deleting timesheet.'], 500);

        return response()->json($timesheet);
    }

    protected function guard()
    {
        return Auth::guard();
    }

    public function totalHours(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_id' => 'integer',
            'min_start_date' => 'date',
            'max_end_date' => 'date',
        ]);

        if ($validator->fails())
            return response()->json($validator->errors(), 400);

        $employee_id = $this->user->hasRole('admin') ? $request->employee_id : $this->user->id;

        $total_hours = $this->timesheet_service->totalHours($employee_id, $request->min_start_date, $request->max_end_date);

        return response()->json(["total_hours" => $total_hours]);
    }

    public function timesheetsDurations(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_id' => 'integer',
            'min_start_date' => 'date',
            'max_end_date' => 'date',
        ]);

        if ($validator->fails())
            return response()->json($validator->errors(), 400);

        $timesheets_durations = $this->timesheet_service->timesheetsDurations($request->employee_id, $request->min_start_date, $request->max_end_date);

        return response()->json($timesheets_durations);
    }
}
