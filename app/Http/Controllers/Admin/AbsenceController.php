<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use App\Http\Controllers\Controller;
use App\Models\Absence;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AbsenceController extends Controller
{
    public function index()
    {
        return view('admin.absence.index');
    }

    public function datatables(Request $request)
    {
        if ($request->ajax()) {
            $data = Absence::with('employee')->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('day', function ($row) {
                    $day = Carbon::parse($row->created_at)->format('d F Y');
                    return $day;
                })
                ->addColumn('duration', function ($row) {
                    $start = Carbon::parse($row->check_in_time);
                    if ($row->check_out_time != null) {
                        $end = Carbon::parse($row->check_out_time);
                    } else {
                        $end = Carbon::now();
                    }

                    $duration = $start->diff($end);

                    return $duration->format('%H:%I:%S');
                })
                ->rawColumns(['check_in', 'check_out', 'day'])
                ->make(true);
        }
    }

    public function datatablesToday(Request $request)
    {
        if ($request->ajax()) {
            $data = Absence::with('employee')->whereDate('created_at', today())->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('day', function ($row) {
                    $day = Carbon::parse($row->created_at)->format('d F Y');
                    return $day;
                })
                ->addColumn('duration', function ($row) {
                    $start = Carbon::parse($row->check_in_time);
                    if ($row->check_out_time != null) {
                        $end = Carbon::parse($row->check_out_time);
                    } else {
                        $end = Carbon::now();
                    }

                    $duration = $start->diff($end);

                    return $duration->format('%H:%I:%S');
                })
                ->rawColumns(['check_in', 'check_out', 'day'])
                ->make(true);
        }
    }
}
