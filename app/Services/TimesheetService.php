<?php

namespace App\Services;

use App\Models\Timesheet;
use DateTime;

class TimesheetService
{
    private const DATE_FORMAT = 'Y-m-d H:i:s';

    //inclusive exclusive - [min_start_date, max_end_date[
    public function timesheetsDurations($employee_id, $min_start_date, $max_end_date)
    {
        $query = Timesheet::selectRaw("*, TIMESTAMPDIFF(SECOND, start_time, end_time) / 3600 as hours");

        if ($employee_id)
            $query->where('user_id', $employee_id);

        if ($min_start_date) {
            $min_start_date = new DateTime($min_start_date);
            $query->whereDate('start_time', '>=', $min_start_date->format(self::DATE_FORMAT));
        }

        if ($max_end_date) {
            $max_end_date = new DateTime($max_end_date);
            $query->whereDate('end_time', '<', $max_end_date->format(self::DATE_FORMAT));
        }

        return $query->orderBy('start_time')->get();
    }

    //inclusive exclusive - [min_start_date, max_end_date[
    public function totalHours($employee_id, $min_start_date, $max_end_date)
    {
        $totalHours = $this->timesheetsDurations($employee_id, $min_start_date, $max_end_date)->sum('hours');

        //Adds partial timesheets that cross the max_end_date
        if ($max_end_date) {
            $query = Timesheet::selectRaw("TIMESTAMPDIFF(SECOND, start_time, '$max_end_date') / 3600 as border_hours")
                ->whereDate('start_time', '<', $max_end_date)
                ->whereDate('end_time', '>=', $max_end_date);
            if ($employee_id)
                $query->where('user_id', $employee_id);

            $totalHours += $query->get()->sum('border_hours');
        }

        //Adds partial timesheets that cross the min_start_date
        if ($min_start_date) {
            $query = Timesheet::selectRaw("TIMESTAMPDIFF(SECOND, '$min_start_date', end_time) / 3600 as border_hours")
                ->whereDate('start_time', '<', $min_start_date)
                ->whereDate('end_time', '>=', $min_start_date);
            if ($employee_id)
                $query->where('user_id', $employee_id);

            $totalHours += $query->get()->sum('border_hours');
        }

        //Special case where start_time < min_start_date and end_time > max_end_date
        if ($max_end_date && $min_start_date) {
            $query = Timesheet::selectRaw("TIMESTAMPDIFF(SECOND, start_time, end_time) / 3600 as exception_hours")
                ->whereDate('start_time', '<', $min_start_date)
                ->whereDate('end_time', '>=', $max_end_date);
            if ($employee_id)
                $query->where('user_id', $employee_id);

            $totalHours -= $query->get()->sum('exception_hours');
        }

        return $totalHours;
    }
}
