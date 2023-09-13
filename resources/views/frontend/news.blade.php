@extends('frontend.layouts.master')

@section('content')
    <section class="blog_pages">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!-- Breadcrumb -->
                    <ul class="breadcrumbs bg-light mb-4">
                        <li class="breadcrumbs__item">
                            <a href="index.html" class="breadcrumbs__url">
                                <i class="fa fa-home"></i> Home</a>
                        </li>
                        <li class="breadcrumbs__item">
                            <a href="index.html" class="breadcrumbs__url">News</a>
                        </li>
                        <li class="breadcrumbs__item breadcrumbs__item--current">
                            World
                        </li>
                    </ul>
                </div>

            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-8">

                    <div class="blog_page_search">
                        <form action="{{ route('news') }}" method="GET">
                            <div class="row">
                                <div class="col-lg-5">
                                    <input type="text" name="search" value="{{ request()->search }}"
                                        placeholder="Type here">
                                </div>
                                <div class="col-lg-4">
                                    <select name="category">
                                        <option value="">{{ __('All') }}</option>
                                        @foreach ($categories as $category)
                                            <option {{ $category->slug === request()->category ? 'selected' : '' }}
                                                value="{{ $category->slug }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <button type="submit">{{ __('search') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <aside class="wrapper__list__article ">
                        @if (request()->has('category'))
                            <h4 class="border_section">{{ __('Category') }}:
                                {{ request()->category ? request()->category : __('All') }}</h4>
                        @endif

                        <div class="row">
                            @forelse ($news as $post)
                                <div class="col-lg-6">
                                    <!-- Post Article -->
                                    <div class="article__entry">
                                        <div class="article__image">
                                            <a href="{{ route('news-details', $post->slug) }}">
                                                <img src="{{ asset($post->image) }}" alt="" class="img-fluid">
                                            </a>
                                        </div>
                                        <div class="article__content">
                                            <div class="article__category">
                                                {{ $post->category->name }}
                                            </div>
                                            <ul class="list-inline">
                                                <li class="list-inline-item">
                                                    <span class="text-primary">
                                                        {{ __('by') }} {{ $post->author->name }}
                                                    </span>
                                                </li>
                                                <li class="list-inline-item">
                                                    <span class="text-dark text-capitalize">
                                                        {{ date('M d, Y', strtotime($post->created_at)) }}
                                                    </span>
                                                </li>

                                            </ul>
                                            <h5>
                                                <a href="{{ route('news-details', $post->slug) }}">
                                                    {!! truncate($post->title, 40) !!}
                                                </a>
                                            </h5>
                                            <p>
                                                {!! truncateHtml($post->content, 100) !!}
                                            </p>
                                            <a href="{{ route('news-details', $post->slug) }}"
                                                class="btn btn-outline-primary mb-4 text-capitalize">
                                                {{ __('read more') }}</a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center w-100">
                                    <h2>No news found :(</h2>
                                </div>
                            @endforelse
                        </div>

                    </aside>
                    <!-- Pagination -->
                    <div data-wow-duration="2s" data-wow-delay="0.5s" class="wow fadeIn animated "
                        style="display: flex; justify-content:center;visibility: visible; animation-duration: 2s; animation-delay: 0.5s; animation-name: fadeIn;">
                        {{ $news->appends(request()->query())->links() }}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="sidebar-sticky">
                        <aside class="wrapper__list__article ">

                            <h4 class="border_section">{{ __('Sidebar') }}:
                            </h4>

                            <div class="wrapper__list__article-small">
                                @foreach ($recentNews as $recent)
                                    @if ($loop->index <= 2)
                                        <div class="mb-3">
                                            <!-- Post Article -->
                                            <div class="card__post card__post-list">
                                                <div class="image-sm">
                                                    <a href="{{ route('news-details', $recent->slug) }}">
                                                        <img src="{{ asset($recent->image) }}" class="img-fluid"
                                                            alt="">
                                                    </a>
                                                </div>


                                                <div class="card__post__body ">
                                                    <div class="card__post__content">

                                                        <div class="card__post__author-info mb-2">
                                                            <ul class="list-inline">
                                                                <li class="list-inline-item">
                                                                    <span class="text-primary">
                                                                        {{ __('by') }} {{ $recent->author->name }}
                                                                    </span>
                                                                </li>
                                                                <li class="list-inline-item">
                                                                    <span class="text-dark text-capitalize">
                                                                        {{ date('M d, Y', strtotime($recent->created_at)) }}
                                                                    </span>
                                                                </li>

                                                            </ul>
                                                        </div>
                                                        <div class="card__post__title">
                                                            <h6>
                                                                <a href="{{ route('news-details', $recent->slug) }}">
                                                                    {!! truncate($recent->title, 40) !!}
                                                                </a>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                                @foreach ($recentNews as $recent)
                                    @if ($loop->index > 2 && $loop->index <= 3)
                                        <!-- Post Article -->
                                        <div class="article__entry">
                                            <div class="article__image">
                                                <a href="{{ route('news-details', $recent->slug) }}">
                                                    <img src="{{ asset($recent->image) }}" alt=""
                                                        class="img-fluid">
                                                </a>
                                            </div>
                                            <div class="article__content">
                                                <div class="article__category">
                                                    {{ $recent->category->name }}
                                                </div>
                                                <ul class="list-inline">
                                                    <li class="list-inline-item">
                                                        <span class="text-primary">
                                                            {{ __('by') }} {{ $recent->author->name }}
                                                        </span>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <span class="text-dark text-capitalize">
                                                            {{ date('M d, Y', strtotime($recent->created_at)) }}
                                                        </span>
                                                    </li>

                                                </ul>
                                                <h5>
                                                    <a href="{{ route('news-details', $recent->slug) }}">
                                                        {!! truncate($recent->title, 40) !!}
                                                    </a>
                                                </h5>
                                                <p>
                                                    {!! truncateHtml($recent->content, 100) !!}
                                                </p>
                                                <a href="{{ route('news-details', $recent->slug) }}"
                                                    class="btn btn-outline-primary mb-4 text-capitalize">
                                                    {{ __('read more') }}</a>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </aside>

                        <aside class="wrapper__list__article">
                            <h4 class="border_section">{{ __('tags') }}</h4>
                            <div class="blog-tags p-0">
                                <ul class="list-inline">
                                    @foreach ($mostCommonTags as $mostTag)
                                        <li class="list-inline-item">
                                            <a href="{{ route('news', ['tag' => $mostTag->name]) }}">
                                                #{{ $mostTag->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </aside>

                        <aside class="wrapper__list__article">
                            <h4 class="border_section">newsletter</h4>
                            <!-- Form Subscribe -->
                            <div class="widget__form-subscribe bg__card-shadow">
                                <h6>
                                    The most important world news and events of the day.
                                </h6>
                                <p><small>Get magzrenvi daily newsletter on your inbox.</small></p>
                                <div class="input-group ">
                                    <input type="text" class="form-control" placeholder="Your email address">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button">sign up</button>
                                    </div>
                                </div>
                            </div>
                        </aside>

                        <aside class="wrapper__list__article">
                            <h4 class="border_section">Advertise</h4>
                            <a href="#">
                                <figure>
                                    <img src="images/newsimage1.png" alt="" class="img-fluid">
                                </figure>
                            </a>
                        </aside>
                    </div>
                </div>

                <div class="clearfix"></div>
            </div>

        </div>
        <div class="large_add_banner mb-4">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="large_add_banner_img">
                            <img src="images/placeholder_large.jpg" alt="adds">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
