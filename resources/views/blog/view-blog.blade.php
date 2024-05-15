@php
    $user = App\Models\User::find($blog->created_by);
    $languages = \App\Facades\UtilityFacades::languages();
@endphp
@extends('layouts.pages.pages-master')
@section('title', __('Blogs'))
@section('auth-topbar')
    <li class="language-btn">
        <select class="btn btn-primary me-2 nice-select"
            onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);"
            id="language">
            @foreach ($languages as $language)
                <option class="" @if ($lang == $language) selected @endif
                    value="{{ route('change.lang', ['slug' => $slug, 'lang' => $language]) }}">{{ Str::upper($language) }}
                </option>
            @endforeach
        </select>
    </li>
@endsection
@section('content')
    <main class="blog-wrapper">
        <section class="blog-page-banner"
            data-bg-image="{{ Utility::getsettings('background_image') ? Storage::url(Utility::getsettings('background_image')) : asset('vendor/landing-page2/image/blog-banner-image.png') }}"
            width="100%" height="100%">
            <div class="container">
                <div class="common-banner-content">
                    <div class="section-title">
                        <h2>{{ isset($blog->title) ? $blog->title : __('Article Page') }}</h2>
                    </div>
                    <ul class="back-cat-btn d-flex align-items-center justify-content-center">
                        <li><a href="{{ route('landingpage') }}">{{ __('Home') }}</a>
                            <span>/</span>
                        </li>
                        <li><a>{{ __('Blogs') }}</a></li>
                    </ul>
                </div>
            </div>
        </section>
        <section class="article-sec pt">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="about-user d-flex align-items-center">
                            <div class="abt-user-info d-flex align-items-center">
                                <div class="abt-image">
                                    <img src="{{ Storage::exists($user->avatar) ? Storage::url($user->avatar) : asset('assets/img/avatar/avatar-1.png') }}" alt="client-image">
                                </div>
                                <h6>
                                    <span>{{ $user->name }}</span> {{ $user->email }}
                                </h6>
                            </div>
                            <div class="post-lbl">
                                <b>Date:</b>{{ App\Facades\UtilityFacades::date_time_format($blog->created_at) }}
                            </div>
                        </div>
                        <div class="section-title">
                            <h2>{{ isset($blog->title) ? $blog->title : __('Benefits of Foem builder in Laravel Dashboard') }}
                            </h2>
                        </div>
                    </div>
                </div>
                <p>{{ Utility::getsettings('blog_details')
                    ? Utility::getsettings('blog_details')
                    : __('Exploring the advantages of implementing Prime-Laravel, such as cost savings, scalability, easier
                                                                                    maintenance, and improved security. A comprehensive guide explaining what Prime-Laravel is, its
                                                                                    importance, and how it can transform the dashboard development process using Laravel.') }}
                </p>
                <section class="article-image">
                    <img src="{{ isset($blog->images) ? Storage::url($blog->images) : asset('vendor/landing-page2/image/article-bg.png') }}"
                        alt="article-image" width="100%" height="100%">
                </section>
            </div>
        </section>

        <section class="article-content-sec">
            <div class="container">
                <h5>{!! $blog->short_description !!} </h5>
                <p>{!! $blog->description !!}</p>
            </div>
        </section>
        <section class="article-page-slider ">
            <div class="container">
                <div class="section-title d-flex align-items-center justify-content-between">
                    <div class="section-title-left">
                        <div class="sub-title">{{ __('ALL BLOGS') }}</div>
                        <h2>{{ __('From our blog') }}</h2>
                    </div>
                    <div class="section-title-right">
                        <a href="{{ route('see.all.blogs') }}" class="btn">{{ __('See More') }}</a>
                    </div>
                </div>
                <div class="article-slider">
                    @foreach ($allBlogs as $oneBlog)
                        <div class="article-card">
                            <div class="article-card-inner">
                                <div class="article-card-image">
                                    <a href="{{ route('view.blog', $oneBlog->slug) }}">
                                        <img src="{{ isset($oneBlog->images) ? Storage::url($oneBlog->images) : asset('vendor/landing-page2/image/blog-card-img-2.png') }}"
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
                                            <span>{{ App\Facades\UtilityFacades::date_time_format($oneBlog->created_at) }}</span>
                                        </div>
                                    </div>
                                    <h3>
                                        <a href="{{ route('view.blog', $oneBlog->slug) }}">
                                            {{ isset($oneBlog->title) ? $oneBlog->title : __('Setting up Form builder in Laravel') }}</a>
                                    </h3>
                                    <p> {!! isset($oneBlog->short_description)
                                        ? $oneBlog->short_description
                                        : __(
                                            'A step-by-step guide on how to configure and implement multi-tenancy in a Laravel application, including tenant isolation and database separation.',
                                        ) !!}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
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
    </script>
@endpush
