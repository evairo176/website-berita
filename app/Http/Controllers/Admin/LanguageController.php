<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLanguageStoreRequest;
use App\Http\Requests\AdminLanguageUpdateRequest;
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
            $search = $request->input('search.value');
            $columns = $request->get('columns');


            $pageSize = $request->length ? $request->length : 10;

            $itemQuery = Language::query();

            $count_filter = 0;
            if ($search != '') {
                $itemQuery->where(function ($query) use ($search) {
                    $query->where('languages.name', 'LIKE', '%' . $search . '%')
                        ->orWhere('languages.lang', 'LIKE', '%' . $search . '%')
                        ->orWhere('languages.slug', 'LIKE', '%' . $search . '%');
                });
                // ->orWhere( 'items.code' , 'LIKE' , '%'.$search.'%');
                $count_filter = $itemQuery->count();
            }


            $itemCounter = $itemQuery->get();
            $count_total = $itemCounter->count();



            // $itemQuery->select(
            //     'news.*',
            //     // 'items.code as items_code',
            //     // 'items.description as items_description',
            //     // 'brands.description as brands_description'
            // );



            $start = $request->start ? $request->start : 0;
            $itemQuery->skip($start)->take($pageSize);
            $items = $itemQuery->get();

            if ($count_filter == 0) {
                $count_filter = $count_total;
            }
            return Datatables::of($items)
                ->with([
                    "recordsTotal" => $count_total,
                    "recordsFiltered" => $count_filter,
                ])
                ->setOffset($start)
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

                    $btn = '<a href="' . route('admin.language.edit', $row->id) . '" class="btn btn-primary btn-sm"> <i class="fas fa-edit"></i></a>
                    <a href="' . route('admin.language.destroy', $row->id) . '" class="btn btn-danger btn-sm delete-item"> <i class="fas fa-trash"></i></a>';
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
        $language = Language::findOrFail($id);
        return view('admin.language.edit', compact('language'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminLanguageUpdateRequest $request, string $id)
    {
        $language = Language::findOrFail($id);
        $language->name = $request->name;
        $language->lang = $request->lang;
        $language->slug = $request->slug;
        $language->default = $request->default;
        $language->status = $request->status;
        $language->save();
        toast(__('Updated successfully'), 'success')->width("350");

        return redirect()->route('admin.language.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $language = Language::findOrFail($id);

            if ($language->lang == 'en') {
                return response([
                    "status" => "error",
                    'message' => __('Can\'t delete this one!')
                ]);
            }

            $language->delete();
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
