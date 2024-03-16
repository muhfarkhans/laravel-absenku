<?php

namespace App\Http\Controllers\Admin;

use Hash;
use Validator;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.user.index');
    }

    public function datatables(Request $request)
    {
        if ($request->ajax()) {
            $data = User::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('admin.user.edit', ['id' => $row->id]) . '" class="edit btn btn-success btn-sm">Edit</a> 
                                  <a href="' . route('admin.user.delete', ['id' => $row->id]) . '" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        $dataCreate = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password'))
        ];

        Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
        ])->validate();

        try {
            User::create($dataCreate);
        } catch (\Throwable $th) {
            return redirect()->route('admin.user.create');
        }

        return redirect()->route('admin.user.index');
    }

    public function edit($id)
    {
        $data = User::find($id);

        return view('admin.user.edit', ['user' => $data]);
    }

    public function update(Request $request, $id)
    {
        $dataUpdate = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ];

        $validationRule = [
            'name' => 'required',
            'email' => 'unique:users,email,' . $id,
        ];

        if (strlen($request->input('password')) < 8 && strlen($request->input('password')) != 0) {
            $validationRule = array_merge($validationRule, ['password' => 'min:8']);

        }
        Validator::make($request->all(), $validationRule)->validate();

        try {
            if ($request->input('password') != null) {
                $dataUpdate['password'] = Hash::make($request->input('password'));
            }

            User::where('id', $id)->update($dataUpdate);
        } catch (\Throwable $th) {
            return redirect()->route('admin.user.edit', $id);
        }

        return redirect()->route('admin.user.index');
    }

    public function delete($id)
    {
        try {
            User::where('id', $id)->delete();
        } catch (\Throwable $th) {
            return redirect()->route('admin.user.index');
        }
        return redirect()->route('admin.user.index');
    }
}
