@php
    $languages = \App\Facades\UtilityFacades::languages();
    $lastBlogUser = App\Models\User::find($lastBlog->created_by);
@endphp
@extends('layouts.pages.pages-master')
@section('title', __('View All Blogs'))
@section('auth-topbar')
    <li class="language-btn">
        <select class="btn btn-primary me-2 nice-select"
            onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);"
            id="language">
            @foreach ($languages as $language)
                <option class="" @if ($lang == $language) selected @endif
                    value="{{ route('change.lang', $language) }}">{{ Str::upper($language) }}
                </option>
            @endforeach
        </select>
    </li>
@endsection
@section('content')
    <main class="blog-wrapper">
        <section class="blog-page-banner" data-bg-image="{{ (Utility::getsettings('background_image') ? Storage::url(Utility::getsettings('background_image')) : asset('vendor/landing-page2/image/blog-banner-image.png')) }}" width="100%" height="100%">
            <div class="container">
                <div class="common-banner-content">
                    <div class="section-title">
                        <h2>{{ __('View All Blogs') }}</h2>
                    </div>
                    <ul class="back-cat-btn d-flex align-items-center justify-content-center">
                        <li><a href="{{ route('landingpage') }}">{{ __('Home') }}</a>
                            <span>/</span>
                        </li>
                        <li><a href="javascript:void(0)">{{ __('View All Blogs') }}</a></li>
                    </ul>
                </div>
            </div>
        </section>
        <section class="blog-sidebar-sec pt">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-5 col-12">
                        <div class="sidebar-widget-area">
                            <div style="margin-bottom: 20px;">
                                <h3 class="title">{{ __('Search Category') }}</h3>
                                <select name="category" class="nice-select" id="search-category">
                                    <option value="" selected disabled>{{ __('Search Category') }}</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="widget widget-recent-blog">
                                <h3 class="title">{{ __('Recent articles') }}</h3>
                                @foreach ($recentBlogs as $recentBlog)
                                    <div class="article-card">
                                        <div class="article-card-inner  d-flex align-items-center">
                                            <div class="card-image">
                                                <a href="{{ route('view.blog', $recentBlog->slug) }}" tabindex="0">
                                                    <img src="{{ isset($recentBlog->images) ? Storage::url($recentBlog->images) : asset('vendor/landing-page2/image/blog-card-img.png') }}"
                                                        alt="recent-post-image">
                                                </a>
                                            </div>
                                            <div class="card-content">
                                                <h6>
                                                    <a
                                                        href="{{ route('view.blog', $recentBlog->slug) }}">{{ isset($recentBlog->title) ? $recentBlog->title : __('Prime-laravel') }}</a>
                                                </h6>
                                                <div class="date d-flex align-items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                        viewBox="0 0 14 14" fill="none">
                                                        <path
                                                            d="M11.1089 1.28044H10.2417V0.760094C10.2417 0.472862 10.0086 0.239746 9.72135 0.239746C9.43411 0.239746 9.201 0.472862 9.201 0.760094V1.28044H4.69132V0.760094C4.69132 0.472862 4.4582 0.239746 4.17097 0.239746C3.88374 0.239746 3.65062 0.472862 3.65062 0.760094V1.28044H2.78338C1.10578 1.28044 0.181641 2.20458 0.181641 3.88218V11.167C0.181641 12.8446 1.10578 13.7688 2.78338 13.7688H11.1089C12.7865 13.7688 13.7107 12.8446 13.7107 11.167V3.88218C13.7107 2.20458 12.7865 1.28044 11.1089 1.28044ZM2.78338 2.32114H3.65062V2.84148C3.65062 3.12872 3.88374 3.36183 4.17097 3.36183C4.4582 3.36183 4.69132 3.12872 4.69132 2.84148V2.32114H9.201V2.84148C9.201 3.12872 9.43411 3.36183 9.72135 3.36183C10.0086 3.36183 10.2417 3.12872 10.2417 2.84148V2.32114H11.1089C12.2031 2.32114 12.67 2.78806 12.67 3.88218V4.40253H1.22234V3.88218C1.22234 2.78806 1.68926 2.32114 2.78338 2.32114ZM11.1089 12.7281H2.78338C1.68926 12.7281 1.22234 12.2612 1.22234 11.167V5.44322H12.67V11.167C12.67 12.2612 12.2031 12.7281 11.1089 12.7281Z"
                                                            fill="#636363" />
                                                    </svg>
                                                    {{ App\Facades\UtilityFacades::date_time_format($recentBlog->created_at) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="widget-blog-card">
                                <div class="article-card">
                                    <div class="article-card-inner">
                                        <div class="article-card-image">
                                            <a href="{{ route('view.blog', $lastBlog->slug) }}">
                                                <img src="{{ isset($lastBlog->images) ? Storage::url($lastBlog->images) : asset('vendor/landing-page2/image/blog-card-img.png') }}"
                                                    alt="blog-card-image">
                                            </a>
                                        </div>
                                        <div class="article-card-content">
                                            <div class="author-info d-flex align-items-center justify-content-between">
                                                <div class="author-name d-flex align-items-center">
                                                    <div class="author-img">
                                                        <img src="{{ Storage::url($lastBlogUser->avatar) }}"
                                                            alt="client-image">
                                                    </div>
                                                    <span>{{ $lastBlogUser->name }}</span>
                                                </div>
                                                <div class="date d-flex align-items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23"
                                                        viewBox="0 0 23 23" fill="none">
                                                        <path
                                                            d="M18.0527 1.86077H16.6306V1.00753C16.6306 0.536546 16.2484 0.154297 15.7774 0.154297C15.3064 0.154297 14.9242 0.536546 14.9242 1.00753V1.86077H7.52946V1.00753C7.52946 0.536546 7.14721 0.154297 6.67623 0.154297C6.20524 0.154297 5.82299 0.536546 5.82299 1.00753V1.86077H4.40094C1.65011 1.86077 0.134766 3.37611 0.134766 6.12694V18.0722C0.134766 20.823 1.65011 22.3384 4.40094 22.3384H18.0527C20.8035 22.3384 22.3189 20.823 22.3189 18.0722V6.12694C22.3189 3.37611 20.8035 1.86077 18.0527 1.86077ZM4.40094 3.56723H5.82299V4.42047C5.82299 4.89145 6.20524 5.2737 6.67623 5.2737C7.14721 5.2737 7.52946 4.89145 7.52946 4.42047V3.56723H14.9242V4.42047C14.9242 4.89145 15.3064 5.2737 15.7774 5.2737C16.2484 5.2737 16.6306 4.89145 16.6306 4.42047V3.56723H18.0527C19.8468 3.56723 20.6124 4.33287 20.6124 6.12694V6.98017H1.84123V6.12694C1.84123 4.33287 2.60687 3.56723 4.40094 3.56723ZM18.0527 20.6319H4.40094C2.60687 20.6319 1.84123 19.8663 1.84123 18.0722V8.68664H20.6124V18.0722C20.6124 19.8663 19.8468 20.6319 18.0527 20.6319Z"
                                                            fill="black" />
                                                    </svg>
                                                    <span>{{ App\Facades\UtilityFacades::date_time_format($lastBlog->created_at) }}</span>
                                                </div>
                                            </div>
                                            <h3>
                                                <a
                                                    href="{{ route('view.blog', $lastBlog->slug) }}">{{ isset($lastBlog->title) ? $lastBlog->title : __('Benefits of Multi-Tenancy in Laravel Dashboard') }}</a>
                                            </h3>
                                            <p>{!! isset($lastBlog->short_description)
                                                ? $lastBlog->short_description
                                                : __(
                                                    'Exploring the advantages of implementing multi-tenancy, such as cost savings, scalability, easier maintenance, and improved security.',
                                                ) !!}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-7 col-12">
                        <div class="blog-right-side append-blog-data">
                            @foreach ($allBlogs as $blog)
                                <div class="article-card ">
                                    <div class="article-card-inner">
                                        <div class="article-card-image">
                                            <a href="{{ route('view.blog', $blog->slug) }}">
                                                <img src="{{ isset($blog->images) ? Storage::url($blog->images) : asset('vendor/landing-page2/image/blog-card-img-2.png') }}"
                                                    alt="blog-card-image">
                                            </a>
                                        </div>
                                        <div class="article-card-content">
                                            <div class="author-info d-flex align-items-center justify-content-between">
                                                <div class="date d-flex align-items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23"
                                                        viewBox="0 0 23 23" fill="none">
                                                        <path
                                                            d="M18.0527 1.86077H16.6306V1.00753C16.6306 0.536546 16.2484 0.154297 15.7774 0.154297C15.3064 0.154297 14.9242 0.536546 14.9242 1.00753V1.86077H7.52946V1.00753C7.52946 0.536546 7.14721 0.154297 6.67623 0.154297C6.20524 0.154297 5.82299 0.536546 5.82299 1.00753V1.86077H4.40094C1.65011 1.86077 0.134766 3.37611 0.134766 6.12694V18.0722C0.134766 20.823 1.65011 22.3384 4.40094 22.3384H18.0527C20.8035 22.3384 22.3189 20.823 22.3189 18.0722V6.12694C22.3189 3.37611 20.8035 1.86077 18.0527 1.86077ZM4.40094 3.56723H5.82299V4.42047C5.82299 4.89145 6.20524 5.2737 6.67623 5.2737C7.14721 5.2737 7.52946 4.89145 7.52946 4.42047V3.56723H14.9242V4.42047C14.9242 4.89145 15.3064 5.2737 15.7774 5.2737C16.2484 5.2737 16.6306 4.89145 16.6306 4.42047V3.56723H18.0527C19.8468 3.56723 20.6124 4.33287 20.6124 6.12694V6.98017H1.84123V6.12694C1.84123 4.33287 2.60687 3.56723 4.40094 3.56723ZM18.0527 20.6319H4.40094C2.60687 20.6319 1.84123 19.8663 1.84123 18.0722V8.68664H20.6124V18.0722C20.6124 19.8663 19.8468 20.6319 18.0527 20.6319Z"
                                                            fill="black" />
                                                    </svg>
                                                    <span>{{ App\Facades\UtilityFacades::date_time_format($blog->created_at) }}</span>
                                                </div>
                                            </div>
                                            <h3>
                                                <a href="{{ route('view.blog', $blog->slug) }}">
                                                    {{ isset($blog->title) ? $blog->title : __('Setting up Form builder in Laravel') }}</a>
                                            </h3>
                                            <p> {!! isset($blog->short_description)
                                                ? $blog->short_description
                                                : __(
                                                    'A step-by-step guide on how to configure and implement multi-tenancy in a Laravel application, including tenant isolation and database separation.',
                                                ) !!}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            {{ $allBlogs->links('blog.custom.pagination') }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var bannerSection = document.querySelector(".blog-page-banner");
            var backgroundURL = bannerSection.getAttribute("data-bg-image");
            bannerSection.style.backgroundImage = "url(" + backgroundURL + ")";
        });

        $(document).ready(function() {
            $('body').on('change', '#search-category', function() {
                var categoryId = $('#search-category :selected').val();
                $.ajax({
                    type: 'GET',
                    url: '{{ route('see.all.blogs') }}',
                    data: {
                        category_id: categoryId
                    },
                    success: function(response) {
                        $('.append-blog-data').empty().html(response.appendedContent);
                    }
                });
            });
        });
    </script>
@endpush
