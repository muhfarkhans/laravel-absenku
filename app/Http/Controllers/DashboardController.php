<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use App\Models\Absence;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->guard('employee')->user()->id;
        $find = Absence::where('employee_id', $userId)->whereDate('created_at', today())->first();

        $arrAbsence = [];

        $totalDuration = CarbonInterval::hours(0);
        $timeNow = Carbon::now();
        $timeNow->startOfMonth();
        $daysInMonth = Carbon::now()->daysInMonth;

        for ($i = 0; $i < $daysInMonth; $i++) {
            $currentDay = Carbon::parse($timeNow->format('Y-m-d H:i:s'))->addDays($i);
            $findDate = Absence::where('employee_id', $userId)->whereDate('created_at', $currentDay)->first();

            if ($findDate) {
                $start = Carbon::parse($findDate->check_in_time);
                $end = Carbon::parse($findDate->check_out_time);
                $duration = $start->diff($end);
                $findDate['duration'] = $duration->format('%H:%I:%S');

                $totalDuration = $totalDuration->add($duration);
            }

            $findDate['day'] = $currentDay;
            $arrAbsence[] = $findDate;
        }

        $totalDurationFormatted = $totalDuration->format('%H:%I:%S');

        return view('dashboard', ['data' => $find, 'absence' => $arrAbsence, 'total_duration' => $totalDurationFormatted]);
    }
}
