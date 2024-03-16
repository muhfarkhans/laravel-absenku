<?php

namespace App\Http\Controllers\Admin;

use App\Services\BiznetFaceRecog;
use Hash;
use Validator;
use App\Models\Division;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DivisionController extends Controller
{
    public function __construct(protected BiznetFaceRecog $biznetFaceRecog)
    {
    }

    public function index()
    {
        return view('admin.division.index');
    }

    public function datatables(Request $request)
    {
        if ($request->ajax()) {
            $data = Division::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('admin.division.edit', ['id' => $row->id]) . '" class="edit btn btn-success btn-sm">Edit</a> 
                                  <a href="' . route('admin.division.delete', ['id' => $row->id]) . '" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function create()
    {
        return view('admin.division.create');
    }

    public function store(Request $request)
    {
        $dataCreate = [
            'name' => $request->input('name')
        ];

        Validator::make($request->all(), [
            'name' => 'required|unique:divisions,name'
        ])->validate();

        try {
            $faceGalleryId = str_replace(' ', '_', strtolower($request->name));
            $dataCreate['facegallery_id'] = $faceGalleryId;

            Division::create($dataCreate);

            // create facegallery to biznetgio
            $this->biznetFaceRecog->createGalleries($faceGalleryId);
        } catch (\Throwable $th) {
            return redirect()->route('admin.division.create')->withErrors($th->getMessage());
        }

        return redirect()->route('admin.division.index');
    }

    public function edit($id)
    {
        $data = Division::find($id);

        return view('admin.division.edit', ['division' => $data]);
    }

    public function update(Request $request, $id)
    {
        $dataUpdate = [
            'name' => $request->input('name'),
        ];

        $validationRule = [
            'name' => 'required|unique:divisions,name,' . $id,
        ];

        Validator::make($request->all(), $validationRule)->validate();

        try {
            Division::where('id', $id)->update($dataUpdate);
        } catch (\Throwable $th) {
            return redirect()->route('admin.division.edit', $id);
        }

        return redirect()->route('admin.division.index');
    }

    public function delete($id)
    {
        try {
            Division::where('id', $id)->delete();
        } catch (\Throwable $th) {
            return redirect()->route('admin.division.index');
        }
        return redirect()->route('admin.division.index');
    }
}
