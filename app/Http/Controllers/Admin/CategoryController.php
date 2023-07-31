<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminCategoryCreateRequest;
use App\Http\Requests\AdminCategoryUpdateRequest;
use App\Models\Category;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $languages = Language::all();



        if ($request->ajax()) {
            // dd($request->all());
            $lang = $request->input('language');
            $category = "";
            if ($lang) {
                $category = Category::where('language', $lang)->orderBy('name', 'desc')->get();
            } else {
                $category = Category::where('language', "en")->orderBy('name', 'desc')->get();
            }

            return Datatables::of($category)
                ->addIndexColumn()
                ->addColumn('show_at_nav', function ($row) {
                    $show_at_nav = '';
                    if ($row->show_at_nav == '1') {
                        $show_at_nav = '<span class="badge badge-success">' . __('Yes') . '</span>';
                    } else {
                        $show_at_nav = '<span class="badge badge-danger">' . __('No') . '</span>';
                    }

                    return $show_at_nav;
                })
                ->addColumn('status', function ($row) {
                    $default = '';
                    if ($row->status == '1') {
                        $default = '<span class="badge badge-success">' . __('Yes') . '</span>';
                    } else {
                        $default = '<span class="badge badge-danger">' . __('No') . '</span>';
                    }

                    return $default;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('admin.category.edit', $row->id) . '" class="btn btn-primary btn-sm"> <i class="fas fa-edit"></i></a>
                    <a href="' . route('admin.category.destroy', $row->id) . '" class="btn btn-danger btn-sm delete-item"> <i class="fas fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action', 'show_at_nav', 'status'])
                ->make(true);
        }
        return view('admin.category.index', compact('languages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = Language::all();
        return view('admin.category.create', compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminCategoryCreateRequest $request)
    {

        $category = new Category();
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->language = $request->language;
        $category->show_at_nav = $request->show_at_nav;
        $category->status = $request->status;
        $category->save();


        toast(__('Created successfully'), 'success')->width("350");

        return redirect()->route('admin.category.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $languages = Language::all();
        $category = Category::findOrFail($id);

        return view('admin.category.edit', compact('languages', 'category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminCategoryUpdateRequest $request, string $id)
    {
        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->language = $request->language;
        $category->show_at_nav = $request->show_at_nav;
        $category->status = $request->status;
        $category->save();


        toast(__('Updated successfully'), 'success')->width("350");

        return redirect()->route('admin.category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $category = Category::findOrFail($id);

            $category->delete();
            return response([
                "status" => "success",
                'message' => __('Deleted Successfully!')
            ]);
        } catch (\Throwable $th) {
            return response([
                "status" => "error",
                'message' => __('Something went wrong!')
            ]);
        }
    }
}
