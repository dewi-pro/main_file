@php
    $languages = \App\Facades\UtilityFacades::languages();
@endphp
@extends('layouts.pages.pages-master')
@section('title', $pageFooter->menu)
@section('auth-topbar')
    <li class="language-btn">
        <select class="btn btn-primary me-2 nice-select"
            onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);"
            id="language">
            @foreach ($languages as $language)
                <option class="" @if ($lang == $language) selected @endif
                    value="{{ route('change.lang', ['slug' => $slug, 'lang' => $language]) }}">
                    {{ Str::upper($language) }}
                </option>
            @endforeach
        </select>
    </li>
@endsection
@section('content')
    <main class="blog-wrapper">
        <section class="blog-page-banner"
            style="background-image: url({{ Utility::getsettings('background_image') ? Storage::url(Utility::getsettings('background_image')) : asset('vendor/landing-page2/image/blog-banner-image.png') }});"
            width="100% " height="100%">
            <div class="container">
                <div class="common-banner-content">
                    <div class="section-title">
                        <h2>{{ isset($pageFooter->menu) ? $pageFooter->menu : null }}</h2>
                    </div>
                    <ul class="back-cat-btn d-flex align-items-center justify-content-center">
                        <li><a href="{{ route('landingpage') }}">{{ __('Home') }}</a>
                            <span>/</span>
                        </li>
                        <li><a href="#">{{ isset($pageFooter->menu) ? $pageFooter->menu : null }}</a></li>
                    </ul>
                </div>
            </div>
        </section>
        <section class="blog-sidebar-sec pt">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-12 mx-auto">
                        <div class="sidebar-widget-area">
                            <h3 class="title">{{ isset($pageFooter->menu) ? $pageFooter->menu : null }}</h3>
                            @php
                                $pageDescription = App\Models\PageSetting::find($pageFooter->page_id);
                            @endphp
                            <div style="margin-top: 20px">
                                <p>{!! isset($pageDescription->description) ? $pageDescription->description : null !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
