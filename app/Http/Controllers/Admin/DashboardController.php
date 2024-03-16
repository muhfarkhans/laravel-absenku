<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absence;
use App\Models\Employee;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $employeeTotal = Employee::count();
        $absenceTotal = Absence::whereNotNull('check_out_time')->whereDate('created_at', today())->count();
        $notAbsenceTotal = Absence::whereNull('check_out_time')->whereDate('created_at', today())->count();

        return view('admin.dashboard', [
            'employeeTotal' => $employeeTotal,
            'absenceTotal' => $absenceTotal,
            'notAbsenceTotal' => $notAbsenceTotal
        ]);
    }
}
