<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLanguageStoreRequest;
use App\Models\Language;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Language::all();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('default', function ($row) {
                    $default = '';
                    if ($row->default == '1') {
                        $default = '<span class="badge badge-primary">' . __('Default') . '</span>';
                    } else {
                        $default = '<span class="badge badge-warning">' . __('No') . '</span>';
                    }

                    return $default;
                })
                ->addColumn('status', function ($row) {
                    $default = '';
                    if ($row->status == '1') {
                        $default = '<span class="badge badge-success">' . __('Active') . '</span>';
                    } else {
                        $default = '<span class="badge badge-danger">' . __('Inactive') . '</span>';
                    }

                    return $default;
                })
                ->addColumn('action', function ($row) {

                    $btn = '<a href="' . route('admin.language.edit', $row->id) . '" class="edit btn btn-primary btn-sm"> <i class="fas fa-edit"></i></a>
                    <a href="' . route('admin.language.destroy', $row->id) . '" class="edit btn btn-danger btn-sm"> <i class="fas fa-trash"></i></a>';

                    return $btn;
                })
                ->rawColumns(['action', 'default', 'status'])
                ->make(true);
        }
        return view('admin.language.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.language.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminLanguageStoreRequest $request)
    {
        $language = new Language();
        $language->name = $request->name;
        $language->lang = $request->lang;
        $language->slug = $request->slug;
        $language->default = $request->default;
        $language->status = $request->status;
        $language->save();
        toast(__('Created successfully'), 'success')->width("350");

        return redirect()->route('admin.language.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('admin.language.edit');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('admin.language.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
