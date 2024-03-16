<?php

namespace App\Http\Controllers\Admin;

use App\Services\BiznetFaceRecog;
use Hash;
use Validator;
use Storage;
use App\Models\Employee;
use App\Models\Division;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class EmployeeController extends Controller
{
    public function __construct(protected BiznetFaceRecog $biznetFaceRecog)
    {
    }

    public function index()
    {
        return view('admin.employee.index');
    }

    public function datatables(Request $request)
    {
        if ($request->ajax()) {
            $data = Employee::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('admin.employee.edit', ['id' => $row->id]) . '" class="edit btn btn-success btn-sm">Edit</a> 
                                  <a href="' . route('admin.employee.delete', ['id' => $row->id]) . '" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function create()
    {
        $division = Division::latest()->get();

        return view('admin.employee.create', ['division' => $division]);
    }

    public function store(Request $request)
    {
        $dataCreate = [
            'division_id' => $request->input('division_id'),
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password'))
        ];

        Validator::make($request->all(), [
            'division_id' => 'required',
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ])->validate();

        try {
            $imgBase64 = base64_encode(file_get_contents($request->file('photo')));
            $ext = $request->file('photo')->extension();
            $imgName = date('dmyHis') . '.' . $ext;
            $path = Storage::putFileAs('public/images', $request->file('photo'), $imgName);
            $dataCreate['photo'] = 'images/' . $imgName;

            $employee = Employee::create($dataCreate);
            $division = Division::where('id', $request->division_id)->first();

            $this->biznetFaceRecog->enrollFace($division->facegallery_id, $employee->email, $employee->name, $imgBase64);
        } catch (\Throwable $th) {
            return redirect()->route('admin.employee.create');
        }

        return redirect()->route('admin.employee.index');
    }

    public function edit($id)
    {
        $data = Employee::find($id);
        $division = Division::latest()->get();

        return view('admin.employee.edit', ['user' => $data, 'division' => $division]);
    }

    public function update(Request $request, $id)
    {
        $dataUpdate = [
            'division_id' => $request->input('division_id'),
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ];

        $validationRule = [
            'division_id' => 'required',
            'name' => 'required',
            'email' => 'unique:users,email,' . $id,
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ];

        if (strlen($request->input('password')) < 8 && strlen($request->input('password')) != 0) {
            $validationRule = array_merge($validationRule, ['password' => 'min:8']);

        }
        Validator::make($request->all(), $validationRule)->validate();

        try {
            $employee = Employee::where('id', $id)->first();

            if ($request->input('password') != null) {
                $dataUpdate['password'] = Hash::make($request->input('password'));
            }

            if ($request->hasFile('photo') && $employee->photo != null) {
                Storage::disk('public')->delete('images/' . $employee->photo);

                $ext = $request->file('photo')->extension();
                $imgName = date('dmyHis') . '.' . $ext;
                $path = Storage::putFileAs('public/images', $request->file('photo'), $imgName);
                $dataUpdate['photo'] = 'images/' . $imgName;
            }

            Employee::where('id', $id)->update($dataUpdate);

            // enroll face to biznetgio

        } catch (\Throwable $th) {
            return redirect()->route('admin.employee.edit', $id);
        }

        return redirect()->route('admin.employee.index');
    }

    public function delete($id)
    {
        try {
            Employee::where('id', $id)->delete();
        } catch (\Throwable $th) {
            return redirect()->route('admin.employee.index');
        }
        return redirect()->route('admin.employee.index');
    }
}
