<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Employee;
use App\Models\Absence;
use App\Models\AbsenceSetting;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\BiznetFaceRecog;

class AbsenceController extends Controller
{
    public function __construct(protected BiznetFaceRecog $biznetFaceRecog)
    {
    }

    public function index()
    {
        return view('absence');
    }

    public function create(Request $request)
    {
        Validator::make($request->all(), [
            'email' => 'required|email',
            'image' => 'required',
        ])->validate();

        $find = Employee::with('division')->where('email', $request->email)->first();

        if ($find != null) {
            $userId = $find->id;
            $findAbsence = Absence::where('employee_id', $userId)->whereDate('created_at', today())->first();

            if ($findAbsence != null) {
                if ($findAbsence->check_out_time != null) {
                    $timeNow = $findAbsence->check_out_time;
                    $message = " sudah melakukan absen pulang pukul ";

                    return back()->with([
                        'name' => $find->name,
                        'success' => $message,
                        'time' => $timeNow
                    ]);
                }
            }

            $checkFaceRecog = $this->biznetFaceRecog->verifyFace($find->division->facegallery_id, $find->email, $find->name, $request->image);

            if (!isset ($checkFaceRecog['risetai']['verified'])) {
                return back()->withErrors([
                    'error' => 'Terjadi kesalahan harap ulangi kembali',
                ]);
            }

            if (!$checkFaceRecog['risetai']['verified']) {
                return back()->withErrors([
                    'error' => 'Terjadi kesalahan harap ulangi kembali',
                ]);
            }

            $timeNow = Carbon::now()->format('Y-m-d H:i:s');

            $dataRow = [
                'employee_id' => $userId,
            ];

            $dataIn = [
                'check_in_time' => $timeNow,
            ];

            $dataOut = [
                'check_out_time' => $timeNow,
            ];

            if ($findAbsence) {
                if ($findAbsence->check_out_time == null) {
                    $dataRow = array_merge($dataRow, $dataOut);
                    Absence::where('id', $findAbsence->id)->update($dataRow);
                    $message = " sukses melakukan absen pulang pukul ";
                }
            } else {
                $dataRow = array_merge($dataRow, $dataIn);
                Absence::create($dataRow);
                $message = " sukses melakukan absen masuk pukul ";
            }

            return back()->with([
                'name' => $find->name,
                'success' => $message,
                'time' => $timeNow
            ]);
        }

        return back()->withErrors([
            'error' => 'Terjadi kesalahan harap ulangi kembali',
        ]);
    }
}
