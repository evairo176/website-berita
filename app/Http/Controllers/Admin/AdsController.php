<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\adminAdsUpdateRequest;
use App\Models\Ads;
use App\Models\Language;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class AdsController extends Controller
{
    use FileUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ads = Ads::first();
        return view('admin.ads.index', compact('ads'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function update(adminAdsUpdateRequest $request, string $id)
    {
        $home_top_bar_ads = $this->handleFileUpload($request, 'home_top_bar_ads');
        $home_middle_ads = $this->handleFileUpload($request, 'home_middle_ads');
        $news_page_ads = $this->handleFileUpload($request, 'news_page_ads');
        $view_page_ads = $this->handleFileUpload($request, 'view_page_ads');
        $sidebar_ads = $this->handleFileUpload($request, 'sidebar_ads');

        $ads = Ads::first();
        Ads::updateOrCreate(
            [
                'id' => $id
            ],
            [
                'home_top_bar_ads' => !empty($home_top_bar_ads) ? $home_top_bar_ads :  $ads->home_top_bar_ads,
                'home_top_bar_ads_status' => $request->home_top_bar_ads_status == 1 ? 1 : 0,
                'home_middle_ads' => !empty($home_middle_ads) ? $home_middle_ads :  $ads->home_middle_ads,
                'home_middle_ads_status' => $request->home_middle_ads_status == 1 ? 1 : 0,
                'news_page_ads' => !empty($news_page_ads) ? $news_page_ads :  $ads->news_page_ads,
                'news_page_ads_status' => $request->news_page_ads_status == 1 ? 1 : 0,
                'view_page_ads' => !empty($view_page_ads) ? $view_page_ads :  $ads->view_page_ads,
                'view_page_ads_status' => $request->view_page_ads_status == 1 ? 1 : 0,
                'sidebar_ads' => !empty($sidebar_ads) ? $sidebar_ads :  $ads->sidebar_ads,
                'sidebar_ads_status' => $request->sidebar_ads_status == 1 ? 1 : 0,
            ]
        );

        toast(__('Updated successfully'), 'success')->width("350");
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
