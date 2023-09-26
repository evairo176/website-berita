<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\Newsletter;
use App\Models\Language;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\DataTables;

class SubscriberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $search = $request->input('search.value');

            $pageSize = $request->length ? $request->length : 10;

            $itemQuery = Subscriber::query();

            $count_filter = 0;
            if ($search != '') {
                $itemQuery->where(function ($query) use ($search) {
                    $query->where('subscribers.email', 'LIKE', '%' . $search . '%');
                    // ->orWhere('categories.slug', 'LIKE', '%' . $search . '%');
                });
                // ->orWhere( 'items.code' , 'LIKE' , '%'.$search.'%');
                $count_filter = $itemQuery->count();
            }

            // Only apply the "en" language filter when a search term is not specified.
            if ($search == '') {
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
                ->addColumn('action', function ($row) {
                    $btn = '
                    <a href="' . route('admin.subscribers.destroy', $row->id) . '" class="btn btn-danger btn-sm delete-item"> <i class="fas fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.subscriber.index');
    }

    /**
     * store the form for creating a new resource.
     */
    public function store(Request $request)
    {
        $request->validate([
            "subject" => ["required", "max:255"],
            "message" => ["required"]
        ]);

        $subscriber = Subscriber::pluck("email")->toArray();
        Mail::to($subscriber)->send(new Newsletter($request->subject, $request->message));

        toast(__('Mail send successfully'), 'success')->width("350");
        return redirect()->back();
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $subscriber = Subscriber::findOrFail($id);

            $subscriber->delete();
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
