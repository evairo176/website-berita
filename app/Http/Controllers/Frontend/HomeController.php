<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Ads;
use App\Models\Category;
use App\Models\Comment;
use App\Models\HomeSectionSetting;
use App\Models\News;
use App\Models\SocialCount;
use App\Models\Subscriber;
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
            ->take(4)
            ->get();

        $mostViewdNews = News::with(['author', 'category'])
            ->activeEntries()
            ->withLocalize()
            ->orderBy("views", "DESC")
            ->take(3)
            ->get();

        $socialCount = SocialCount::where(['status' => 1, 'language' => getLanguage()])
            ->get();

        $mostCommonTags = $this->mostCommonTags();

        $ads = Ads::first();


        return view('frontend.home', compact(
            'breakingNews',
            'heroSlider',
            'recentNews',
            'popularNews',
            'categorySectionOne',
            'categorySectionTwo',
            'categorySectionThree',
            'categorySectionFour',
            'mostViewdNews',
            'socialCount',
            'mostCommonTags',
            'ads'
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

        $socialCount = SocialCount::where(['status' => 1, 'language' => getLanguage()])
            ->get();
        // dd($relatedNews);

        $ads = Ads::first();


        return view('frontend.news-details', compact('news', 'recentNews', 'mostCommonTags', 'nextNews', 'previousNews', 'relatedNews', 'socialCount', 'ads'));
    }

    public function news(Request $request)
    {


        $news = News::query();

        $news->when($request->has('category') && !empty($request->category), function ($query) use ($request) {
            $query->with(['category', 'author'])
                ->orWhereHas('category', function ($query) use ($request) {
                    $query->where('slug',  $request->category);
                });
        });

        $news->when($request->has('search'), function ($query) use ($request) {
            $query->with(['category', 'author'])
                ->where(function ($query) use ($request) {
                    $query->where('title', 'like', '%' . $request->search . '%')
                        ->orWhere('content', 'like', '%' . $request->search . '%');
                })
                ->orWhereHas('category', function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->search . '%');
                });
        });

        $news->when($request->has('tag'), function ($query) use ($request) {
            $query->with(['category', 'author', 'tags'])
                ->orWhereHas('tags', function ($query) use ($request) {
                    $query->where('name',  $request->tag);
                });
        });


        $news = $news->activeEntries()
            ->withLocalize()
            ->paginate(10);


        $recentNews = News::with(['category', 'author'])
            ->activeEntries()->withLocalize()
            ->orderBy('id', 'desc')
            ->take(4)
            ->get();

        $mostCommonTags = $this->mostCommonTags();

        $categories = Category::where([
            'status' => 1,
            'language' => getLanguage()
        ])->get();

        $ads = Ads::first();

        return view('frontend.news', compact('news', 'recentNews', 'mostCommonTags', 'categories', 'ads'));
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

    public function subscribeNewsletter(Request $request)
    {
        $request->validate([
            "email" => ["required", "email", "max:255", "unique:subscribers,email"]
        ], [
            "email.unique" => __("Email is already subscribed!")
        ]);

        $subscriber = new Subscriber();
        $subscriber->email = $request->email;
        $subscriber->save();

        return response(['status' => 'success', 'message' => _('Subscribed successfully!')]);
    }
}
