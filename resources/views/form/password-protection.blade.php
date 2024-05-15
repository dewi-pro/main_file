<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ __('Password-Protection') }} | {{ Utility::getsettings('app_name') }}</title>
    @php
        $primaryColor = \App\Facades\UtilityFacades::getsettings('color');

        if (isset($primaryColor)) {
            $color = $primaryColor;
        } else {
            $color = 'theme-2';
        }
    @endphp
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta name="title"
        content="{{ !empty(Utility::getsettings('meta_title'))
            ? Utility::getsettings('meta_title')
            : Utility::getsettings('app_name') }}">
    <meta name="keywords"
        content="{{ !empty(Utility::getsettings('meta_keywords'))
            ? Utility::getsettings('meta_keywords')
            : 'Multi Users,Role & permission , Form & poll management , document Genrator , Booking system' }}">
    <meta name="description"
        content="{{ !empty(Utility::getsettings('meta_description'))
            ? Utility::getsettings('meta_description')
            : 'Discover the efficiency of prime-laravel, a user-friendly web application by Quebix Apps.' }}">
    <meta name="meta_image_logo" property="og:image"
        content="{{ !empty(Utility::getsettings('meta_image_logo'))
            ? Storage::url(Utility::getsettings('meta_image_logo'))
            : Storage::url('seeder-image/meta-image-logo.jpg') }}">
    @if (Utility::getsettings('seo_setting') == 'on')
        {!! app('seotools')->generate() !!}
    @endif

    <!-- Favicon icon -->
    <link rel="manifest" href="{{ asset('/public/manifest.json') }}">

    <link rel="icon"
        href="{{ Utility::getsettings('favicon_logo') ? Storage::url('app-logo/app-favicon-logo.png') : '' }}"
        type="image/png">

    <!-- Favicon icon -->
    <link rel="icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/x-icon" />

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link">
    <link rel="stylesheet" href="{{ asset('vendor/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/customizer.css') }}">
</head>


<body class="{{ $color }}">
    <!-- [ auth-signup ] start -->
    <div class="password-container">
        <div class="password-bg-side password-bg-color"></div>
        <div class="doc-password-card">
            <div class="password-card-inner">
                <div>
                    <h2 class="section-title">{{ __('Form Password') }}</h2>
                </div>
                <div class="card">
                    <div class="card-body">
                        {!! Form::open([
                            'route' => ['form.match.password', $form->id],
                            'method' => 'Post',
                            'data-validate',
                            'class' => 'form-control password-form',
                            'enctype' => 'multipart/form-data',
                        ]) !!}
                        <div class="password-card-content">
                            <img src="{{ $form->logo ? (Storage::exists($form->logo) ? asset('storage/app/' . $form->logo) : Storage::url('docgen-logo/docgenlogo.png')) : ($form->logo != '' ? asset('storage/app/' . $form->logo) : Storage::url('docgen-logo/docgenlogo.png')) }}"
                                class="doc-logo">
                            <h3 class="doc-title">{{ $form->title }}</h3>
                            <div class="form-group mb-3">
                                <label class="form-label">{{ __('Enter Password') }}</label>
                                <input type="password" name="form_password" class="form-control" placeholder="Password"
                                    required />
                            </div>
                            <div class="d-grid password-btn">
                                <button type="submit" class="document-btn btn btn-primary mt-2 p-2 border-0">
                                    {{ __('Unlock') }}
                                </button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

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

    <script src="{{ asset('vendor/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>
    <script src="{{ asset('vendor/modules/tooltip.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap-notify.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>

    <script src="{{ asset('vendor/js/custom.js') }}"></script>
    <script>
        var toster_pos = 'right';
    </script>
    @include('layouts.includes.alerts')
</body>

</html>
