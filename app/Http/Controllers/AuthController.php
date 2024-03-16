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

class AuthController extends Controller
{
    public function index()
    {
        if (auth()->guard('employee')->check()) {
            return redirect()->route('dashboard');
        }

        return view('login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (
            auth()->guard('employee')->attempt([
                'email' => $request->email,
                'password' => $request->password
            ])
        ) {
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'error' => 'Email dan Password tidak sesuai',
        ]);
    }

    public function logout(Request $request)
    {
        auth()->guard('employee')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
