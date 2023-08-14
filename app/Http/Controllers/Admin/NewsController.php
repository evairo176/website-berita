<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminNewsCreateRequest;
use App\Http\Requests\AdminNewsUpdateRequest;
use App\Models\Category;
use App\Models\Language;
use App\Models\News;
use App\Models\Tag;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class NewsController extends Controller
{
    use FileUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // dd($request->input('language'));
        // dd($news = News::where('language', "id")->orderBy('id', 'desc')->get());
        $languages = Language::all();
        if ($request->ajax()) {
            // dd($request->all());
            $lang = $request->input('language');
            $news = "";
            if ($lang) {
                $news = News::with('category')->where('language', $lang)->orderBy('id', 'desc')->get();
            } else {
                $news = News::with('category')->where('language', "en")->orderBy('id', 'desc')->get();
            }
            // dd($news);
            return Datatables::of($news)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    $url = asset($row->image);
                    $image = '<img width="100" height="100" src="' . $url . '" alt="">';
                    return $image;
                })
                ->addColumn('is_breaking_news', function ($row) {
                    $default = '<label class="custom-switch mt-2">
                    <input onclick="toggleStatus(this)"  data-id="' . $row->id . '" data-name="is_breaking_news" ' . ($row->is_breaking_news === 1 ? 'checked' : '') . ' value="1" type="checkbox"  class="custom-switch-input toggle-status">
                    <span class="custom-switch-indicator"></span>
                    </label>';

                    return $default;
                })
                ->addColumn('show_at_slider', function ($row) {
                    $default = '<label class="custom-switch mt-2">
                    <input onclick="toggleStatus(this)"  data-id="' . $row->id . '" data-name="show_at_slider" ' . ($row->show_at_slider === 1 ? 'checked' : '') . ' value="1" type="checkbox"  class="custom-switch-input toggle-status">
                    <span class="custom-switch-indicator"></span>
                    </label>';

                    return $default;
                })
                ->addColumn('show_at_popular', function ($row) {
                    $default = '<label class="custom-switch mt-2">
                    <input onclick="toggleStatus(this)"  data-id="' . $row->id . '" data-name="show_at_popular" ' . ($row->show_at_popular === 1 ? 'checked' : '') . ' value="1" type="checkbox"  class="custom-switch-input toggle-status">
                    <span class="custom-switch-indicator"></span>
                    </label>';

                    return $default;
                })
                ->addColumn('status', function ($row) {

                    $default = '<label class="custom-switch mt-2">
                        <input onclick="toggleStatus(this)"  data-id="' . $row->id . '" data-name="status" ' . ($row->status === 1 ? 'checked' : '') . ' value="1" type="checkbox"  class="custom-switch-input toggle-status">
                        <span class="custom-switch-indicator"></span>
                        </label>';

                    return $default;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('admin.news.edit', $row->id) . '"class="btn btn-primary btn-sm"> <i class="fas fa-edit"></i></a>
                    <a href="' . route('admin.news.destroy', $row->id) . '" class="btn btn-danger btn-sm delete-item"> <i class="fas fa-trash"></i></a>
                    <a href="' . route('admin.news-copy', $row->id) . '"class="btn btn-secondary btn-sm"> <i class="fas fa-copy"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action', 'default', 'status', 'is_breaking_news', 'show_at_slider', 'show_at_popular', 'image'])
                ->make(true);
        }
        return view('admin.news.index', compact('languages'));
    }
    /**
     * Show the category By language.
     */
    public function fetchCategory(Request $request)
    {
        $category = Category::where('language', $request->lang)->get();
        return $category;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = Language::all();
        return view("admin.news.create", compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminNewsCreateRequest $request)
    {
        // handle image
        $imagePath =  $this->handleFileUpload($request, 'image');

        $news = new News();
        $news->language = $request->language;
        $news->category_id = $request->category;
        $news->author_id = Auth::guard('admin')->user()->id;
        $news->image = $imagePath;
        $news->title = $request->title;
        $news->slug = Str::slug($request->slug);
        $news->content = $request->content;
        $news->meta_title = $request->meta_title;
        $news->meta_description = $request->meta_description;
        $news->is_breaking_news = $request->is_breaking_news == 1 ? 1 : 0;
        $news->show_at_slider = $request->show_at_slider == 1 ? 1 : 0;
        $news->show_at_popular = $request->show_at_popular == 1 ? 1 : 0;
        $news->status = $request->status == 1 ? 1 : 0;
        $news->save();

        $tags = explode(',', $request->tags);
        $tagIds = [];

        foreach ($tags as $tag) {
            $item = new Tag();

            $item->name = $tag;
            $item->save();
            $tagIds[] = $item->id;
        }

        $news->tags()->attach($tagIds);



        toast(__('Created successfully'), 'success')->width("350");

        return redirect()->route('admin.news.index')->withInput();
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
        $news = News::findOrFail($id);
        $categories = Category::where('language', $news->language)->get();
        return view('admin.news.edit', compact('languages', 'news', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminNewsUpdateRequest $request, string $id)
    {

        $news = News::findOrFail($id);
        // handle image
        $imagePath =  $this->handleFileUpload($request, 'image', $news->image);


        $news->language = $request->language;
        $news->category_id = $request->category;
        $news->image = !empty($imagePath) ?  $imagePath : $news->image;
        $news->title = $request->title;
        $news->slug = Str::slug($request->slug);
        $news->content = $request->content;
        $news->meta_title = $request->meta_title;
        $news->meta_description = $request->meta_description;
        $news->is_breaking_news = $request->is_breaking_news == 1 ? 1 : 0;
        $news->show_at_slider = $request->show_at_slider == 1 ? 1 : 0;
        $news->show_at_popular = $request->show_at_popular == 1 ? 1 : 0;
        $news->status = $request->status == 1 ? 1 : 0;
        $news->save();

        $tags = explode(',', $request->tags);
        $tagIds = [];

        /** delete previos tags */
        $news->tags()->delete();

        /** detach tags from pivot tags */
        $news->tags()->detach($news->tags);
        foreach ($tags as $tag) {
            $item = new Tag();

            $item->name = $tag;
            $item->save();
            $tagIds[] = $item->id;
        }

        $news->tags()->attach($tagIds);

        toast(__('Updated successfully'), 'success')->width("350");

        return redirect()->route('admin.news.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $news = News::findOrFail($id);
            $this->deleteFile($news->image);
            $news->tags()->delete();
            $news->delete();

            return response(['status' => 'success', 'message' => __('Deleted Successfully')]);
        } catch (\Throwable $th) {
            return response([
                "status" => "error",
                'message' => __('Something went wrong!')
            ]);
        }
    }

    /**
     * update the specified status from table News.
     */
    public function toggleNewsStatus(Request $request)
    {
        try {
            $news = News::findOrFail($request->id);
            $news->{$request->name} = $request->status;
            $news->save();

            return response(['status' => 'success', 'message' => __('Updated Successfully')]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Copy News.
     */
    public function copyNews(string $id)
    {
        $news = News::findOrFail($id);
        $sourceFilePath  = $news->image; // Provide the current file path
        $imageInfo = pathinfo($sourceFilePath);
        $newFileName = $imageInfo['filename'] . '-copy-' . $news->id . '.' . $imageInfo['extension']; // Provide the new file name
        $newFilePath = $this->duplicateAndRenameImage($sourceFilePath, $newFileName);

        if ($newFilePath) {
            // File name changed successfully, $newFilePath contains the path to the renamed file
            $copyNews = $news->replicate();
            $copyNews->image = $newFilePath;
            $copyNews->save();

            toast(__('Copied Successfully'), 'success')->width("350");

            return redirect()->back();
        } else {
            // Current file doesn't exist
            return response()->json(['message' => 'Current file not found'], 404);
        }
    }
}
