<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Validator;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('admin.profile', ['user' => $user]);
    }

    public function update(Request $request)
    {
        $validationRule = [
            'name' => 'required',
            'email' => 'required',
        ];

        if ($request->password != "") {
            $validationRule = [
                'password' => 'min:8',
            ];
        }

        Validator::make($request->all(), $validationRule)->validate();

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->password != "") {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ];
        }

        User::where('id', Auth::user()->id)->update($data);

        return redirect()->route('admin.profile')->withMessage('Data pengguna berhasil diubah');
    }
}
