<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminSocialCountStoreRequest;
use App\Models\Language;
use App\Models\News;
use App\Models\SocialCount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class SocialCountController extends Controller
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
            $draw = $request->get('draw');

            $search = $request->input('search.value');
            $columns = $request->get('columns');


            $pageSize = $request->length ? $request->length : 10;

            $itemQuery = SocialCount::query();

            $count_filter = 0;
            if ($search != '') {
                $itemQuery->where(function ($query) use ($search) {
                    $query->where('social_counts.icon', 'LIKE', '%' . $search . '%');
                });
                // ->orWhere( 'items.code' , 'LIKE' , '%'.$search.'%');
                $count_filter = $itemQuery->count();
            }
            if ($lang) {
                $itemQuery->where('language', $lang);
                $count_filter = $itemQuery->count();
            } else {
                // Only apply the "en" language filter when a search term is not specified.
                if ($search == '') {
                    $itemQuery->where('language', "en");
                    $count_filter = $itemQuery->count();
                }
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
                ->addColumn('icon', function ($row) {
                    $default = '<i style="font-size:20px" class="' . $row->icon . '"></i>';
                    return $default;
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
                    $btn = '<a href="' . route('admin.social-count.edit', $row->id) . '" class="btn btn-primary btn-sm"> <i class="fas fa-edit"></i></a>
                        <a href="' . route('admin.social-count.destroy', $row->id) . '" class="btn btn-danger btn-sm delete-item"> <i class="fas fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action', 'status', 'icon'])
                ->make(true);
        }
        return view('admin.social-count.index', compact('languages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = Language::all();
        return view('admin.social-count.create', compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminSocialCountStoreRequest $request)
    {
        $socialCount = new SocialCount();
        $socialCount->language = $request->language;
        $socialCount->icon = $request->icon;
        $socialCount->url = $request->url;
        $socialCount->fan_count = $request->fan_count;
        $socialCount->fan_type = $request->fan_type;
        $socialCount->button_text = $request->button_text;
        $socialCount->color = $request->color;
        $socialCount->status = $request->status;
        $socialCount->save();
        toast(__('Created successfully'), 'success')->width("350");

        return redirect()->route('admin.social-count.index');
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
        $socialCount = SocialCount::findOrFail($id);
        return view('admin.social-count.edit', compact('languages', 'socialCount'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $socialCount = SocialCount::findOrFail($id);
        $socialCount->language = $request->language;
        $socialCount->icon = $request->icon;
        $socialCount->url = $request->url;
        $socialCount->fan_count = $request->fan_count;
        $socialCount->fan_type = $request->fan_type;
        $socialCount->button_text = $request->button_text;
        $socialCount->color = $request->color;
        $socialCount->status = $request->status;
        $socialCount->save();
        toast(__('Updated successfully'), 'success')->width("350");

        return redirect()->route('admin.social-count.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $category = SocialCount::findOrFail($id);

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
