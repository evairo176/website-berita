<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\HomeSectionSetting;
use App\Models\News;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $breakingNews = News::with(['author', 'category'])
            ->where([
                'is_breaking_news' => 1,
            ])
            ->activeEntries()
            ->withLocalize()
            ->orderBy('id', 'desc')
            ->take(10)
            ->get();

        $heroSlider = News::with(['author', 'category'])
            ->where([
                'show_at_slider' => 1,
            ])
            ->activeEntries()
            ->withLocalize()
            ->orderBy('id', 'desc')
            ->take(7)
            ->get();
        $recentNews = News::with(['author', 'category'])
            // ->where([
            //     'show_at_slider' => 1,
            // ])
            ->activeEntries()
            ->withLocalize()
            ->orderBy('updated_at', 'desc')
            ->take(6)
            ->get();
        $popularNews = News::with(['author', 'category'])
            ->where([
                'show_at_popular' => 1,
            ])
            ->activeEntries()
            ->withLocalize()
            ->orderBy('id', 'desc')
            ->take(4)
            ->get();

        $homeSectionSetting = HomeSectionSetting::where(['language' => getLanguage()])->first();
        $categorySectionOne = News::with(['author', 'category'])
            ->where("category_id", $homeSectionSetting->category_section_one)
            ->activeEntries()
            ->withLocalize()
            ->orderBy("id", "DESC")
            ->take(8)
            ->get();

        $categorySectionTwo = News::with(['author', 'category'])
            ->where("category_id", $homeSectionSetting->category_section_two)
            ->activeEntries()
            ->withLocalize()
            ->orderBy("id", "DESC")
            ->take(8)
            ->get();

        $categorySectionThree = News::with(['author', 'category'])
            ->where("category_id", $homeSectionSetting->category_section_three)
            ->activeEntries()
            ->withLocalize()
            ->orderBy("id", "DESC")
            ->take(6)
            ->get();
        $categorySectionFour = News::with(['author', 'category'])
            ->where("category_id", $homeSectionSetting->category_section_four)
            ->activeEntries()
            ->withLocalize()
            ->orderBy("id", "DESC")
            ->take(8)
            ->get();


        return view('frontend.home', compact(
            'breakingNews',
            'heroSlider',
            'recentNews',
            'popularNews',
            'categorySectionOne',
            'categorySectionTwo',
            'categorySectionThree',
            'categorySectionFour'
        ));
    }

    public function showNews(string $slug)
    {
        $news = News::with(['author', 'tags', 'comments'])->where([
            'slug' => $slug,
        ])->activeEntries()->withLocalize()->first();
        // dd($news);

        $this->countView($news);

        $recentNews = News::with(['category', 'author'])
            ->where('slug', '!=', $news->slug)
            ->activeEntries()->withLocalize()
            ->orderBy('id', 'desc')
            ->take(4)
            ->get();

        $nextNews = News::where('id', '>', $news->id)
            ->activeEntries()
            ->withLocalize()
            ->orderBy('id', 'asc')
            ->first();

        $previousNews = News::where('id', '<', $news->id)
            ->activeEntries()
            ->withLocalize()
            ->orderBy('id', 'desc')
            ->first();

        $mostCommonTags = $this->mostCommonTags();

        $relatedNews = News::with(['category', 'author'])
            ->where('slug', '!=', $news->slug)
            ->where('category_id', $news->category_id)
            ->activeEntries()
            ->withLocalize()
            ->orderBy('id', 'desc')
            ->take(5)
            ->get();

        // dd($relatedNews);



        return view('frontend.news-details', compact('news', 'recentNews', 'mostCommonTags', 'nextNews', 'previousNews', 'relatedNews'));
    }

    public function countView($news)
    {
        if (session()->has('viewed_posts')) {
            $newsId = session('viewed_posts');

            if (!in_array($news->id,  $newsId)) {
                $newsId[] = $news->id;
                $news->increment('views');
            }
            session(['viewed_posts' => $newsId]);
        } else {
            session(['viewed_posts' => [$news->id]]);
            $news->increment('views');
        }
    }

    public function mostCommonTags()
    {
        return Tag::select('name', DB::raw('COUNT(*) as count'))
            ->where('language', getLanguage())
            ->groupBy('name')
            ->orderBy('count', 'desc')
            ->take(15)
            ->get();
    }

    public function handleComment(Request $request)
    {

        $request->validate([
            'comment' => ['required', 'max:1000', 'string']
        ]);

        $comment = new Comment();
        $comment->news_id = $request->news_id;
        $comment->user_id = Auth::user()->id;
        $comment->parent_id = $request->parent_id;
        $comment->comment = $request->comment;
        $comment->save();

        toast(__('Comment added successfully'), 'success')->width("350");
        return redirect()->back();
    }

    public function handleReplay(Request $request)
    {

        $request->validate([
            'comment' => ['required', 'max:1000', 'string']
        ]);

        $comment = new Comment();
        $comment->news_id = $request->news_id;
        $comment->user_id = Auth::user()->id;
        $comment->parent_id = $request->parent_id;
        $comment->comment = $request->comment;
        $comment->save();

        toast(__('Reply added successfully'), 'success')->width("350");
        return redirect()->back();
    }

    public function commentDestroy(Request $request)
    {
        // dd($request->id);
        $comment = Comment::findOrFail($request->id);

        if (Auth::user()->id === $comment->user_id) {
            $comment->delete();
            return response(['status' => 'success', 'message' => _('Deleted Successfully')]);
        }

        toast(__('Comment deleted successfully'), 'success')->width("350");
        return response(['status' => 'error', 'message' => _('Something went wrong!')]);
    }
}
