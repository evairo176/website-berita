<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminSocialCountStoreRequest;
use App\Models\Language;
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


            // $socialCount = "";
            $lang = $request->input('language');
            $draw = $request->get('draw');

            $search = $request->input('search.value');
            $columns = $request->get('columns');


            $pageSize = $request->length ? $request->length : 10;

            $itemQuery = DB::table('social_counts');

            // $itemQuery->orderBy('items_id', 'asc');
            $itemCounter = $itemQuery->get();
            $count_total = $itemCounter->count();

            $count_filter = 0;
            if ($search != '') {
                $itemQuery->where('social_counts.icon', 'LIKE', '%' . $search . '%');
                // ->orWhere( 'items.description' , 'LIKE' , '%'.$search.'%')
                // ->orWhere( 'items.code' , 'LIKE' , '%'.$search.'%');
                $count_filter = $itemQuery->count();
            }

            $itemQuery->select(
                'social_counts.*',
                // 'items.code as items_code',
                // 'items.description as items_description',
                // 'brands.description as brands_description'
            );



            if ($lang) {
                $itemQuery->where('language', $lang)->orderBy('id', 'desc');
            } else {
                $itemQuery->where('language', "en")->orderBy('id', 'desc');
            }

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
                ->rawColumns(['action', 'status'])
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
        //
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
