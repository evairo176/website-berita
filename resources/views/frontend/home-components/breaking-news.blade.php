<section class="bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="wrapp__list__article-responsive wrapp__list__article-responsive-carousel">
                    @foreach ($breakingNews as $breaking)
                        <div class="item">
                            <!-- Post Article -->
                            <div class="card__post card__post-list">
                                <div class="image-sm">
                                    <a href="./blog_details.html">
                                        <img src="{{ asset($breaking->image) }}" class="img-fluid"
                                            alt="{{ $breaking->title }}">
                                    </a>
                                </div>

                                <div class="card__post__body ">
                                    <div class="card__post__content">
                                        <div class="card__post__author-info mb-2">
                                            <ul class="list-inline">
                                                <li class="list-inline-item">
                                                    <span class="text-primary">
                                                        {{ __('by') }} {{ $breaking->author_id }}
                                                    </span>
                                                </li>
                                                <li class="list-inline-item">
                                                    <span class="text-dark text-capitalize">
                                                        {{ date('M d, Y', strtotime($breaking->created_at)) }}
                                                    </span>
                                                </li>

                                            </ul>
                                        </div>
                                        <div class="card__post__title">
                                            <h6>
                                                <a href="blog_details.html">
                                                    {{ $breaking->title }}
                                                </a>
                                            </h6>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</section>