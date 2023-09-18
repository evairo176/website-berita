@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('Ads') }}</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>{{ __('Update Ads') }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.ads.update', 1) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <h5 class="text-primary">{{ __('Home Page Ads') }}</h5>
                    <div class="form-group">
                        <img src="{{ asset($ads->home_top_bar_ads) }}" width="200px" alt="home_top_bar_ads">
                        <br>
                        <label for="home_top_bar_ads">{{ __('Top Bar Ads') }}</label>
                        <input name="home_top_bar_ads" type="file" class="form-control">
                        @error('home_top_bar_ads')
                            <p style="font-size: 80%;
                        color: #dc3545;">
                                {{ $message }}</p>
                        @enderror

                        <label class="custom-switch mt-2">
                            <input {{ $ads->home_top_bar_ads_status == 1 ? 'checked' : '' }} name="home_top_bar_ads_status"
                                value="1" type="checkbox" class="custom-switch-input toggle-status">
                            <span class="custom-switch-indicator"></span>
                        </label>
                    </div>
                    <div class="form-group">
                        <img src="{{ asset($ads->home_middle_ads) }}" width="200px" alt="home_middle_ads">
                        <br>
                        <label for="home_middle_ads">{{ __('Middle Ads') }}</label>
                        <input name="home_middle_ads" type="file" class="form-control">
                        @error('home_middle_ads')
                            <p style="font-size: 80%;
                        color: #dc3545;">
                                {{ $message }}</p>
                        @enderror
                        <label class="custom-switch mt-2">
                            <input {{ $ads->home_middle_ads_status == 1 ? 'checked' : '' }} name="home_middle_ads_status"
                                value="1" type="checkbox" class="custom-switch-input toggle-status">
                            <span class="custom-switch-indicator"></span>
                        </label>
                    </div>

                    <h5 class="text-primary">{{ __('News View Page Ads') }}</h5>
                    <div class="form-group">
                        <img src="{{ asset($ads->news_page_ads) }}" width="200px" alt="home_middle_ads">
                        <br>
                        <label for="news_page_ads">{{ __('Bottom Ads') }}</label>
                        <input name="news_page_ads" type="file" class="form-control">
                        @error('news_page_ads')
                            <p style="font-size: 80%;
                        color: #dc3545;">
                                {{ $message }}</p>
                        @enderror
                        <label class="custom-switch mt-2">
                            <input {{ $ads->news_page_ads_status == 1 ? 'checked' : '' }} name="news_page_ads_status"
                                value="1" type="checkbox" class="custom-switch-input toggle-status">
                            <span class="custom-switch-indicator"></span>
                        </label>
                    </div>

                    <h5 class="text-primary">{{ __('View Page Ads') }}</h5>
                    <div class="form-group">
                        <img src="{{ asset($ads->view_page_ads) }}" width="200px" alt="home_middle_ads">
                        <br>
                        <label for="view_page_ads">{{ __('Bottom Ads') }}</label>
                        <input name="view_page_ads" type="file" class="form-control">
                        @error('view_page_ads')
                            <p style="font-size: 80%;
                        color: #dc3545;">
                                {{ $message }}</p>
                        @enderror
                        <label class="custom-switch mt-2">
                            <input {{ $ads->view_page_ads_status == 1 ? 'checked' : '' }} name="view_page_ads_status"
                                value="1" type="checkbox" class="custom-switch-input toggle-status">
                            <span class="custom-switch-indicator"></span>
                        </label>
                    </div>

                    <h5 class="text-primary">{{ __('Sidebar Ads') }}</h5>
                    <div class="form-group">
                        <img src="{{ asset($ads->sidebar_ads) }}" width="200px" alt="home_middle_ads">
                        <br>
                        <label for="sidebar_ads">{{ __('Sidebar Ads') }}</label>
                        <input name="sidebar_ads" type="file" class="form-control">
                        @error('sidebar_ads')
                            <p style="font-size: 80%;
                        color: #dc3545;">
                                {{ $message }}</p>
                        @enderror
                        <label class="custom-switch mt-2">
                            <input {{ $ads->sidebar_ads_status == 1 ? 'checked' : '' }} name="sidebar_ads_status"
                                value="1" type="checkbox" class="custom-switch-input toggle-status">
                            <span class="custom-switch-indicator"></span>
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                </form>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
@endpush
