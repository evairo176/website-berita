  @extends('frontend.layouts.master')

  @section('content')
      <!-- Tranding news  carousel-->
      @include('frontend.home-components.breaking-news')
      <!-- End Tranding news carousel -->

      <!-- Hero Slider -->
      @include('frontend.home-components.hero-slider')
      <!-- End Hero Slider -->

      @if ($ads->home_top_bar_ads_status == 1)
          <div class="large_add_banner">
              <div class="container">
                  <div class="row">
                      <div class="col-12">
                          <div class="large_add_banner_img">
                              <img src="{{ asset($ads->home_top_bar_ads) }}" alt="adds">
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      @endif

      <!-- Main news  -->
      @include('frontend.home-components.main-news')
      <!-- End Main news  -->
  @endsection
