@section('title', __('Document'))
<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ $document->title }} | {{ Utility::getsettings('app_name') }}</title>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Editor">
    <meta name="keywords" content="Editor">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="manifest" href="{{ asset('/public/manifest.json') }}">
    <link rel="icon"
        href="{{ setting('favicon_logo') ? Storage::url('app-logo/app-favicon-logo.png') : asset('assets/images/app-favicon-logo.png') }}"
        type="image/png">
    <link rel="stylesheet" href="{{ asset('vendor/document-stisla/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/document-stisla/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/document-stisla/style.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/document-stisla/style.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/document-stisla/components.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/document-stisla/document-custom.css') }}">
</head>

<body>
    <main class="wrapper">
        <div id="app" class="main-body">
            <div class="main-wrapper main-wrapper-1">

                @include('document.front.theme1.sidebar')

                <div class="main-content">
                    <section class="section">
                        <div class="section-header">
                            <a href="javascript:void(0);" data-toggle="sidebar"
                                class="laptop-nav nav-link nav-link-lg nav-color">
                                <i class="fas fa-bars"></i>
                            </a>
                            @if (empty($changelog))
                                @if (isset($documentMenu->title))
                                    <h1>{{ $documentMenu->title }}</h1>
                                    <div class="section-header-breadcrumb">
                                        @if ($menus->id == $documentMenu->parent_id)
                                            <div class="breadcrumb-item">
                                                <a
                                                    href="{{ route('documentmenu.menu', $menus->slug) }}">{{ $menus->title }}</a>
                                            </div>
                                        @endif
                                        <div class="breadcrumb-item">{{ $documentMenu->title }}</div>
                                    </div>
                                @else
                                    @php
                                        $docMenu = App\Models\DocumentMenu::where('document_id', $document->id)
                                            ->orderBy('position')
                                            ->first();
                                    @endphp
                                    <h1>{{ $docMenu->title }}</h1>
                                    <div class="section-header-breadcrumb">
                                        <div class="breadcrumb-item">{{ $docMenu->title }}</div>
                                    </div>
                                @endif
                            @else
                                <h1>{{ __('Change Log') }}</h1>
                                <div class="section-header-breadcrumb">
                                    <div class="breadcrumb-item">{{ __('Change Log') }}</div>
                                </div>
                            @endif
                        </div>
                        <div class="section-body">
                            <div class="row">
                                <div class="col-md-9" id="first-col">
                                    <div class="card txt-crd">
                                        <div class="card-body">
                                            @if (empty($changelog))
                                                @if (isset($documentMenu->title))
                                                    @php
                                                        $array = json_decode($documentMenu->json);
                                                    @endphp
                                                    @if (isset($array))
                                                        @foreach ($array as $key => $row)
                                                            @if ($row->type == 'heading')
                                                                @if ($row->data->level == 1)
                                                                    <h1 class="page-title"
                                                                        id="{{ Str::slug(html_entity_decode($row->data->text)) }}">
                                                                        {!! $row->data->text !!}
                                                                    </h1>
                                                                @elseif($row->data->level == 2)
                                                                    <h2 class="page-title2"
                                                                        id="{{ Str::slug(html_entity_decode($row->data->text)) }}">
                                                                        {!! $row->data->text !!}
                                                                    </h2>
                                                                @elseif($row->data->level == 3)
                                                                    <h3 class="page-title3"
                                                                        id="{{ Str::slug(html_entity_decode($row->data->text)) }}">
                                                                        {!! $row->data->text !!}
                                                                    </h3>
                                                                @elseif($row->data->level == 4)
                                                                    <h4 class="page-title4"
                                                                        id="{{ Str::slug(html_entity_decode($row->data->text)) }}">
                                                                        {!! $row->data->text !!}
                                                                    </h4>
                                                                @elseif($row->data->level == 5)
                                                                    <h5 class="page-title5"
                                                                        id="{{ Str::slug(html_entity_decode($row->data->text)) }}">
                                                                        {!! $row->data->text !!}
                                                                    </h5>
                                                                @elseif($row->data->level == 6)
                                                                    <h6 class="page-title6"
                                                                        id="{{ Str::slug(html_entity_decode($row->data->text)) }}">
                                                                        {!! $row->data->text !!}
                                                                    </h6>
                                                                @else
                                                                @endif
                                                            @elseif($row->type == 'paragraph')
                                                                <section class="page-content">
                                                                    <div class="page-block-content">
                                                                        <p>
                                                                            {!! isset($row->data->text) ? $row->data->text : '' !!}
                                                                        </p>
                                                                    </div>
                                                                </section>
                                                            @elseif($row->type == 'list')
                                                                <section class="page-content">
                                                                    <div class="page-block-content">
                                                                        <ul
                                                                            class="data-list @if ($row->data->style == 'ordered') list-orderd @endif">
                                                                            @foreach ($row->data->items as $key => $options)
                                                                                <li> {!! isset($options) ? $options : '' !!} </li>
                                                                            @endforeach
                                                                        </ul>
                                                                    </div>
                                                                </section>
                                                            @elseif($row->type == 'checklist')
                                                                <section class="page-content">
                                                                    <div class="page-block-content">
                                                                        <ul class="data-list">
                                                                            @foreach ($row->data->items as $key => $options)
                                                                                @if (isset($options->checked) == true)
                                                                                    <li> {!! isset($options->text) ? $options->text : '' !!} </li>
                                                                                @endif
                                                                            @endforeach
                                                                        </ul>
                                                                    </div>
                                                                </section>
                                                            @elseif($row->type == 'quote')
                                                                <section class="page-content">
                                                                    <div class="page-block-content">
                                                                        <p class="quote-paragraph">
                                                                            {!! isset($row->data->text) ? $row->data->text : '' !!}
                                                                        </p>
                                                                        <p class="quote-caption">
                                                                            {!! isset($row->data->caption) ? $row->data->caption : '' !!}
                                                                        </p>
                                                                    </div>
                                                                </section>
                                                            @elseif($row->type == 'warning')
                                                                <section class="page-content">
                                                                    <div class="page-block-content">
                                                                        <div class="cdx-warning">
                                                                            <div class="cdx-input cdx-warning-title">
                                                                                {!! isset($row->data->title) ? $row->data->title : '' !!}
                                                                            </div>
                                                                            <div class="cdx-input cdx-warning-message">
                                                                                {!! isset($row->data->message) ? $row->data->message : '' !!}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </section>
                                                            @elseif($row->type == 'table')
                                                                <section class="page-content">
                                                                    <div class="page-block-content">
                                                                        <table class="block-table">
                                                                            <tbody>
                                                                                @foreach ($row->data->content as $key => $options)
                                                                                    <tr>
                                                                                        @foreach ($options as $key => $value)
                                                                                            @if ($row->data->withHeadings == true)
                                                                                                <td>
                                                                                                    {!! isset($value) ? $value : '' !!}
                                                                                                </td>
                                                                                            @else
                                                                                                <td>
                                                                                                    {!! isset($value) ? $value : '' !!}
                                                                                                </td>
                                                                                            @endif
                                                                                        @endforeach
                                                                                    </tr>
                                                                                @endforeach
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </section>
                                                            @elseif($row->type == 'raw')
                                                                <section class="page-content">
                                                                    <div class="page-block-content">
                                                                        <div class="block-code">
                                                                            <div class="block-code-wrapper">
                                                                                <div class="qbix-code-content js-content"
                                                                                    value="{{ $row->data->html }}">
                                                                                    {{ $row->data->html }} </div>
                                                                            </div>
                                                                            <div class="copy-button js-copy">
                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                    viewBox="0 0 512 512">
                                                                                    <path
                                                                                        d="M288 448H64V224h64V160H64c-35.3 0-64 28.7-64 64V448c0 35.3 28.7 64 64 64H288c35.3 0 64-28.7 64-64V384H288v64zm-64-96H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H224c-35.3 0-64 28.7-64 64V288c0 35.3 28.7 64 64 64z">
                                                                                    </path>
                                                                                </svg>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </section>
                                                            @elseif($row->type == 'code')
                                                                <section class="page-content">
                                                                    <div class="page-block-content">
                                                                        <div class="block-code">
                                                                            <div class="block-code-wrapper">
                                                                                <div class="qbix-code-content-code js-contents"
                                                                                    value="{{ $row->data->code }}">
                                                                                    {{ $row->data->code }}</div>
                                                                            </div>
                                                                            <div class="copy-button js-copys code-public"
                                                                                title="Copy to Clipboard">
                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                    viewBox="0 0 512 512"
                                                                                    fill="white">
                                                                                    <path
                                                                                        d="M288 448H64V224h64V160H64c-35.3 0-64 28.7-64 64V448c0 35.3 28.7 64 64 64H288c35.3 0 64-28.7 64-64V384H288v64zm-64-96H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H224c-35.3 0-64 28.7-64 64V288c0 35.3 28.7 64 64 64z">
                                                                                    </path>
                                                                                </svg>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </section>
                                                            @elseif($row->type == 'image')
                                                                <div class="ce-block">
                                                                    <div class="simple-image">
                                                                        <img
                                                                            src="{{ isset($row->data->url) ? $row->data->url : '' }}">
                                                                        <input placeholder="Caption..."
                                                                            value="{!! isset($row->data->caption) ? $row->data->caption : '' !!}">
                                                                    </div>
                                                                </div>
                                                            @elseif($row->type == 'delimiter')
                                                                <section class="page-content">
                                                                    <div class="page-block-content">
                                                                        <div class="page-delimiter"></div>
                                                                    </div>
                                                                </section>
                                                            @else
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                @else
                                                    @php
                                                        $docMenu = App\Models\DocumentMenu::where('document_id', $document->id)
                                                            ->orderBy('position')
                                                            ->first();
                                                        $val = isset($docMenu->json) ? $docMenu->json : '';
                                                        $array = json_decode($val);
                                                    @endphp
                                                    @if (isset($array))
                                                        @foreach ($array as $key => $row)
                                                            @if ($row->type == 'heading')
                                                                @if ($row->data->level == 1)
                                                                    <h1 class="page-title"
                                                                        id="{{ Str::slug(html_entity_decode($row->data->text)) }}">
                                                                        {!! $row->data->text !!}
                                                                    </h1>
                                                                @elseif($row->data->level == 2)
                                                                    <h2 class="page-title2"
                                                                        id="{{ Str::slug(html_entity_decode($row->data->text)) }}">
                                                                        {!! $row->data->text !!}
                                                                    </h2>
                                                                @elseif($row->data->level == 3)
                                                                    <h3 class="page-title3"
                                                                        id="{{ Str::slug(html_entity_decode($row->data->text)) }}">
                                                                        {!! $row->data->text !!}
                                                                    </h3>
                                                                @elseif($row->data->level == 4)
                                                                    <h4 class="page-title4"
                                                                        id="{{ Str::slug(html_entity_decode($row->data->text)) }}">
                                                                        {!! $row->data->text !!}
                                                                    </h4>
                                                                @elseif($row->data->level == 5)
                                                                    <h5 class="page-title5"
                                                                        id="{{ Str::slug(html_entity_decode($row->data->text)) }}">
                                                                        {!! $row->data->text !!}
                                                                    </h5>
                                                                @elseif($row->data->level == 6)
                                                                    <h6 class="page-title6"
                                                                        id="{{ Str::slug(html_entity_decode($row->data->text)) }}">
                                                                        {!! $row->data->text !!}
                                                                    </h6>
                                                                @else
                                                                @endif
                                                            @elseif($row->type == 'paragraph')
                                                                <section class="page-content">
                                                                    <div class="page-block-content">
                                                                        <p>
                                                                            {!! isset($row->data->text) ? $row->data->text : '' !!}
                                                                        </p>
                                                                    </div>
                                                                </section>
                                                            @elseif($row->type == 'list')
                                                                <section class="page-content">
                                                                    <div class="page-block-content">
                                                                        <ul
                                                                            class="data-list @if ($row->data->style == 'ordered') list-orderd @endif">
                                                                            @foreach ($row->data->items as $key => $options)
                                                                                <li> {!! isset($options) ? $options : '' !!} </li>
                                                                            @endforeach
                                                                        </ul>
                                                                    </div>
                                                                </section>
                                                            @elseif($row->type == 'checklist')
                                                                <section class="page-content">
                                                                    <div class="page-block-content">
                                                                        <ul class="data-list">
                                                                            @foreach ($row->data->items as $key => $options)
                                                                                @if (isset($options->checked) == true)
                                                                                    <li> {!! isset($options->text) ? $options->text : '' !!} </li>
                                                                                @endif
                                                                            @endforeach
                                                                        </ul>
                                                                    </div>
                                                                </section>
                                                            @elseif($row->type == 'quote')
                                                                <section class="page-content">
                                                                    <div class="page-block-content">
                                                                        <p class="quote-paragraph">
                                                                            {!! isset($row->data->text) ? $row->data->text : '' !!}
                                                                        </p>
                                                                        <p class="quote-caption">
                                                                            {!! isset($row->data->caption) ? $row->data->caption : '' !!}
                                                                        </p>
                                                                    </div>
                                                                </section>
                                                            @elseif($row->type == 'warning')
                                                                <section class="page-content">
                                                                    <div class="page-block-content">
                                                                        <div class="cdx-warning">
                                                                            <div class="cdx-input cdx-warning-title"
                                                                                contenteditable="true"
                                                                                data-placeholder="Title">
                                                                                {!! isset($row->data->title) ? $row->data->title : '' !!}
                                                                            </div>
                                                                            <div class="cdx-input cdx-warning-message"
                                                                                contenteditable="true"
                                                                                data-placeholder="Message">
                                                                                {!! isset($row->data->message) ? $row->data->message : '' !!}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </section>
                                                            @elseif($row->type == 'linkTool')
                                                                <section class="page-content">
                                                                    <div class="page-block-content">
                                                                        <div class="block-warning">
                                                                            <div class="block-warning-icon">
                                                                                ☝️
                                                                            </div>
                                                                            <div class="block-warning-message">
                                                                                <a href="{!! isset($row->data->link) ? $row->data->link : '' !!}"
                                                                                    target="_blank">
                                                                                    {!! isset($row->data->link) ? $row->data->link : '' !!}
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </section>
                                                            @elseif($row->type == 'table')
                                                                <section class="page-content">
                                                                    <div class="page-block-content">
                                                                        <table class="block-table">
                                                                            <tbody>
                                                                                @foreach ($row->data->content as $key => $options)
                                                                                    <tr>
                                                                                        @foreach ($options as $key => $value)
                                                                                            @if ($row->data->withHeadings == true)
                                                                                                <td>
                                                                                                    {!! isset($value) ? $value : '' !!}
                                                                                                </td>
                                                                                            @else
                                                                                                <td>
                                                                                                    {!! isset($value) ? $value : '' !!}
                                                                                                </td>
                                                                                            @endif
                                                                                        @endforeach
                                                                                    </tr>
                                                                                @endforeach
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </section>
                                                            @elseif($row->type == 'raw')
                                                                <section class="page-content">
                                                                    <div class="page-block-content">
                                                                        <div class="block-code">
                                                                            <div class="block-code-wrapper">
                                                                                <div class="qbix-code-content js-content"
                                                                                    value="{{ $row->data->html }}">
                                                                                    {{ $row->data->html }}
                                                                                </div>
                                                                            </div>
                                                                            <div class="copy-button js-copy"
                                                                                title="Copy to Clipboard">
                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                    viewBox="0 0 512 512">
                                                                                    <path
                                                                                        d="M288 448H64V224h64V160H64c-35.3 0-64 28.7-64 64V448c0 35.3 28.7 64 64 64H288c35.3 0 64-28.7 64-64V384H288v64zm-64-96H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H224c-35.3 0-64 28.7-64 64V288c0 35.3 28.7 64 64 64z">
                                                                                    </path>
                                                                                </svg>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </section>
                                                            @elseif($row->type == 'code')
                                                                <section class="page-content">
                                                                    <div class="page-block-content">
                                                                        <div class="block-code">
                                                                            <div class="block-code-wrapper">
                                                                                <div class="qbix-code-content-code js-contents"
                                                                                    value="{{ $row->data->code }}">
                                                                                    {{ $row->data->code }}
                                                                                </div>
                                                                            </div>
                                                                            <div class="copy-button js-copys code-public"
                                                                                title="Copy to Clipboard">
                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                    viewBox="0 0 512 512"
                                                                                    fill="white">
                                                                                    <path
                                                                                        d="M288 448H64V224h64V160H64c-35.3 0-64 28.7-64 64V448c0 35.3 28.7 64 64 64H288c35.3 0 64-28.7 64-64V384H288v64zm-64-96H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H224c-35.3 0-64 28.7-64 64V288c0 35.3 28.7 64 64 64z">
                                                                                    </path>
                                                                                </svg>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </section>
                                                            @elseif($row->type == 'image')
                                                                <div class="ce-block">
                                                                    <div class="simple-image">
                                                                        <img
                                                                            src="{{ isset($row->data->url) ? $row->data->url : '' }}">
                                                                        <input placeholder="Caption..."
                                                                            value="{!! html_entity_decode(isset($row->data->caption) ? $row->data->caption : '') !!}">
                                                                    </div>
                                                                </div>
                                                            @elseif($row->type == 'delimiter')
                                                                <section class="page-content">
                                                                    <div class="page-block-content">
                                                                        <div class="page-delimiter"></div>
                                                                    </div>
                                                                </section>
                                                            @else
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                @endif
                                            @else
                                                <section class="page-content">
                                                    <h2>{{ __('Changelog') }}</h2>
                                                    <p>{{ __('See what`s new added, changed, fixed, improved or updated in the latest versions. ') }}
                                                    </p>
                                                    <div class="page-block-content">
                                                        @php
                                                            if ($changeLogJsons) {
                                                                usort($changeLogJsons, function ($a, $b) {
                                                                    return version_compare($b['version'], $a['version']);
                                                                });
                                                            }
                                                        @endphp
                                                        <hr class="divider">
                                                        @foreach ($changeLogJsons as $changeLog)
                                                            @php
                                                                $changelogId = str_replace('.', '_', $changeLog['version']);
                                                            @endphp
                                                            <h3 id="{{ $changelogId }}">{{ __('Version') }}
                                                                {{ $changeLog['version'] }} <small
                                                                    class="text-muted">({{ Utility::date_format($changeLog['date']) }})</small>
                                                            </h3>
                                                            <table class="changelog data-list">
                                                                @if ($changeLog['inner-list'])
                                                                    @foreach ($changeLog['inner-list'] as $innerList)
                                                                        <tr>
                                                                            <td>
                                                                                <span
                                                                                    class="badge badge-{{ $innerList['color'] }}">{{ $innerList['badge'] }}</span>
                                                                            </td>
                                                                            <td>
                                                                                <p class="pl-2 my-0">
                                                                                    {{ $innerList['text'] }}</p>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                @endif
                                                            </table>
                                                            <hr class="divider">
                                                        @endforeach
                                                    </div>
                                                </section>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 card-right" id="second-col">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="right-inner-header">
                                                {{ __('On this page') }}
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="content-right">
                                                <div class="right-inner-content">
                                                    <ul class="right-inner-list" id="right-inner-nav">
                                                        @if (empty($changelog))
                                                            @if (isset($documentMenu->title))
                                                                @php
                                                                    $array = json_decode($documentMenu->json);
                                                                @endphp
                                                                @if (isset($array))
                                                                    @foreach ($array as $key => $rows)
                                                                        @if ($rows->type == 'heading')
                                                                            @if ($rows->data->level == 1)
                                                                                <li class="list-item">
                                                                                    <a class="link-head"
                                                                                        href="{{ Request::url('') . '#' . Str::slug(html_entity_decode($rows->data->text)) }}"
                                                                                        data-scroll="tab-1">
                                                                                        {!! $rows->data->text !!}
                                                                                    </a>
                                                                                </li>
                                                                            @elseif($rows->data->level == 2)
                                                                                <li class="list-item title-heading2">
                                                                                    <a class="link-head"
                                                                                        href="{{ Request::url('') . '#' . Str::slug(html_entity_decode($rows->data->text)) }}"
                                                                                        data-scroll="tab-1">
                                                                                        {!! $rows->data->text !!}
                                                                                    </a>
                                                                                </li>
                                                                            @elseif($rows->data->level == 3)
                                                                                <li class="list-item title-heading3">
                                                                                    <a class="link-head"
                                                                                        href="{{ Request::url('') . '#' . Str::slug(html_entity_decode($rows->data->text)) }}"
                                                                                        data-scroll="tab-1">
                                                                                        {!! $rows->data->text !!}
                                                                                    </a>
                                                                                </li>
                                                                            @elseif($rows->data->level == 4)
                                                                                <li class="list-item title-heading4">
                                                                                    <a class="link-head"
                                                                                        href="{{ Request::url('') . '#' . Str::slug(html_entity_decode($rows->data->text)) }}"
                                                                                        data-scroll="tab-1">
                                                                                        {!! $rows->data->text !!}
                                                                                    </a>
                                                                                </li>
                                                                            @elseif($rows->data->level == 5)
                                                                                <li class="list-item title-heading5">
                                                                                    <a class="link-head"
                                                                                        href="{{ Request::url('') . '#' . Str::slug(html_entity_decode($rows->data->text)) }}"
                                                                                        data-scroll="tab-1">
                                                                                        {!! $rows->data->text !!}
                                                                                    </a>
                                                                                </li>
                                                                            @elseif($rows->data->level == 6)
                                                                                <li class="list-item title-heading6">
                                                                                    <a class="link-head"
                                                                                        href="{{ Request::url('') . '#' . Str::slug(html_entity_decode($rows->data->text)) }}"
                                                                                        data-scroll="tab-1">
                                                                                        {!! $rows->data->text !!}
                                                                                    </a>
                                                                                </li>
                                                                            @else
                                                                            @endif
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            @else
                                                                @php
                                                                    $docMenu = App\Models\DocumentMenu::where('document_id', $document->id)
                                                                        ->orderBy('position')
                                                                        ->first();
                                                                    $val = isset($docMenu->json) ? $docMenu->json : '';
                                                                    $array = json_decode($val);
                                                                @endphp
                                                                @if (isset($array))
                                                                    @foreach ($array as $key => $rows)
                                                                        @if ($rows->type == 'heading')
                                                                            @if ($rows->data->level == 1)
                                                                                <li class="list-item">
                                                                                    <a class="link-head"
                                                                                        class="link-head"
                                                                                        href="{{ Request::url('') . '#' . Str::slug(html_entity_decode($rows->data->text)) }}"
                                                                                        data-scroll="tab-1">
                                                                                        {!! $rows->data->text !!}
                                                                                    </a>
                                                                                </li>
                                                                            @elseif($rows->data->level == 2)
                                                                                <li class="list-item title-heading2">
                                                                                    <a class="link-head"
                                                                                        href="{{ Request::url('') . '#' . Str::slug(html_entity_decode($rows->data->text)) }}"
                                                                                        data-scroll="tab-1">
                                                                                        {!! $rows->data->text !!}
                                                                                    </a>
                                                                                </li>
                                                                            @elseif($rows->data->level == 3)
                                                                                <li class="list-item title-heading3">
                                                                                    <a class="link-head"
                                                                                        href="{{ Request::url('') . '#' . Str::slug(html_entity_decode($rows->data->text)) }}"
                                                                                        data-scroll="tab-1">
                                                                                        {!! $rows->data->text !!}
                                                                                    </a>
                                                                                </li>
                                                                            @elseif($rows->data->level == 4)
                                                                                <li class="list-item title-heading4">
                                                                                    <a class="link-head"
                                                                                        href="{{ Request::url('') . '#' . Str::slug(html_entity_decode($rows->data->text)) }}"
                                                                                        data-scroll="tab-1">
                                                                                        {!! $rows->data->text !!}
                                                                                    </a>
                                                                                </li>
                                                                            @elseif($rows->data->level == 5)
                                                                                <li class="list-item title-heading5">
                                                                                    <a class="link-head"
                                                                                        href="{{ Request::url('') . '#' . Str::slug(html_entity_decode($rows->data->text)) }}"
                                                                                        data-scroll="tab-1">
                                                                                        {!! $rows->data->text !!}
                                                                                    </a>
                                                                                </li>
                                                                            @elseif($rows->data->level == 6)
                                                                                <li class="list-item title-heading6">
                                                                                    <a class="link-head"
                                                                                        href="{{ Request::url('') . '#' . Str::slug(html_entity_decode($rows->data->text)) }}"
                                                                                        data-scroll="tab-1">
                                                                                        {!! $rows->data->text !!}
                                                                                    </a>
                                                                                </li>
                                                                            @else
                                                                            @endif
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            @endif
                                                        @else
                                                            @php
                                                                if ($changeLogJsons) {
                                                                    usort($changeLogJsons, function ($a, $b) {
                                                                        return version_compare($b['version'], $a['version']);
                                                                    });
                                                                }
                                                            @endphp
                                                            @foreach ($changeLogJsons as $changeLog)
                                                                @php
                                                                    $changelogId = str_replace('.', '_', $changeLog['version']);
                                                                @endphp
                                                                <li class="list-item c_log">
                                                                    <a class="link-head" href="#{{ $changelogId }}"
                                                                        data-scroll="tab-1">
                                                                        <b>{{ __('Version') }}</b>
                                                                        {{ 'v' . $changeLog['version'] }}
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <footer class="main-footer">
                    <div class="footer-left">
                        <span class="text-muted">
                            © {{ date('Y') }}
                        </span>
                        <b>
                            <a href="javascript:void(0);" tabindex="0">
                                {{ config('app.name') }}
                            </a>
                        </b>
                    </div>
                </footer>
            </div>
        </div>
    </main>
    <script>
        // Fetch the manifest.json file
        url = '{{ config('app.url') }}';
        var appUrl = url.replace(/\/$/, '');
        file = appUrl + '/public/manifest.json';

        fetch(file)
            .then(response => response.json())
            .then(data => {
                if (data.icons[0].sizes === '128x128') {
                    data.icons[0].src = '{{ Utility::getpath("pwa_icon_128") ? Storage::url(Utility::getsettings("pwa_icon_128")) : "" }}';
                }
                if (data.icons[1].sizes === '144x144') {
                    data.icons[1].src = '{{ Utility::getpath("pwa_icon_144") ? Storage::url(Utility::getsettings("pwa_icon_144")) : "" }}';
                }
                if (data.icons[2].sizes === '152x152') {
                    data.icons[2].src = '{{ Utility::getpath("pwa_icon_152") ? Storage::url(Utility::getsettings("pwa_icon_152")) : "" }}';
                }
                if (data.icons[3].sizes === '192x192') {
                    data.icons[3].src = '{{ Utility::getpath("pwa_icon_192") ? Storage::url(Utility::getsettings("pwa_icon_192")) : "" }}';
                }
                if (data.icons[4].sizes === '256x256') {
                    data.icons[4].src = '{{ Utility::getpath("pwa_icon_256") ? Storage::url(Utility::getsettings("pwa_icon_256")) : "" }}';
                }
                if (data.icons[5].sizes === '512x512') {
                    data.icons[5].src = '{{ Utility::getpath("pwa_icon_512") ? Storage::url(Utility::getsettings("pwa_icon_512")) : "" }}';
                }
                data.name = "{{ Utility::getsettings('app_name') }}";
                data.short_name = "{{ Utility::getsettings('app_name') }}";
                data.start_url = appUrl;
                
                const updatedManifest = JSON.stringify(data);
                const blob = new Blob([updatedManifest], {
                    type: 'application/json'
                });
                const url = URL.createObjectURL(blob);
                document.querySelector('link[rel="manifest"]').href = url;
            })
            .catch(error => console.error('Error fetching manifest.json:', error));
    </script>
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/document-stisla/popper.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendor/modules/tooltip.js') }}"></script>
    <script src="{{ asset('vendor/document-stisla/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('vendor/document-stisla/moment.min.js') }}"></script>
    <script src="{{ asset('vendor/document-stisla/stisla.js') }}"></script>
    <script src="{{ asset('vendor/document-stisla/scripts.js') }}"></script>
    <script src="{{ asset('vendor/document-stisla/document-custom.js') }}"></script>
    <script>
        $(document).ready(function() {
            // public document raw html copy paste code
            var currentUrl = window.location.href;
            // Extract the last segment
            var segments = currentUrl.split('/');
            var lastSegment = segments[segments.length - 1];
            var lastSeg = lastSegment.split('#');
            if (lastSeg[0] == 'changelog') {
                $('li').removeClass('active');
                $('li.changelog').addClass('active');
                $('li.c_log').parents('.has-children').addClass('active');
            }
            if (lastSeg[1]) {
                $('a[href="#' + lastSeg[1] + '"]').parents('li').addClass('active');
            }
            $(document).on('click', 'li.has-children', function() {
                $('li.has-children').removeClass('active');
                $(this).addClass('active');
            });
            $(document).on('click', 'li.c_log', function() {
                $('li.c_log').removeClass('active');
                var href = $(this).find('a').attr('href');
                $('a[href="' + href + '"]').parents('li').addClass('active');
            });
        });
        (function() {
            let area = document.createElement('textarea');
            document.body.appendChild(area);
            area.style.display = "none";
            let content = document.querySelectorAll('.js-content');
            let copy = document.querySelectorAll('.js-copy');
            for (let i = 0; i < copy.length; i++) {
                copy[i].addEventListener('click', function() {
                    area.style.display = "block";
                    area.value = content[i].innerText;
                    area.select();
                    document.execCommand('copy');
                    area.style.display = "none";
                    var html =
                        '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z" /></svg>';
                    var val =
                        '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M288 448H64V224h64V160H64c-35.3 0-64 28.7-64 64V448c0 35.3 28.7 64 64 64H288c35.3 0 64-28.7 64-64V384H288v64zm-64-96H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H224c-35.3 0-64 28.7-64 64V288c0 35.3 28.7 64 64 64z"></path></svg>';
                    this.innerHTML = html;
                    setTimeout(() => this.innerHTML = val, 2000);
                });
            }
        })();

        // public document code copy paste code
        (function() {
            let area = document.createElement('textarea');
            document.body.appendChild(area);
            area.style.display = "none";
            let content = document.querySelectorAll('.js-contents');
            let copy = document.querySelectorAll('.js-copys');
            for (let i = 0; i < copy.length; i++) {
                copy[i].addEventListener('click', function() {
                    area.style.display = "block";
                    area.value = content[i].innerText;
                    area.select();
                    document.execCommand('copy');
                    area.style.display = "none";
                    var html =
                        '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" fill="white"><path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z" /></svg>';
                    var val =
                        '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="white"><path d="M288 448H64V224h64V160H64c-35.3 0-64 28.7-64 64V448c0 35.3 28.7 64 64 64H288c35.3 0 64-28.7 64-64V384H288v64zm-64-96H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H224c-35.3 0-64 28.7-64 64V288c0 35.3 28.7 64 64 64z"></path></svg>';
                    this.innerHTML = html;
                    setTimeout(() => this.innerHTML = val, 2000);
                });
            }
        })();
    </script>

</body>

</html>
