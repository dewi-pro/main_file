@php
    $footerMainMenus = App\Models\FooterSetting::where('parent_id', 0)->get();
    $users = \Auth::user();

    $user = App\Models\User::where('created_by', null)->first();
    $lang = App\Facades\UtilityFacades::getActiveLanguage();
    \App::setLocale($lang)

@endphp
<!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
             dir="{{ \App\Facades\UtilityFacades::getsettings('rtl') == '1' || $lang == 'ar' ? 'rtl' : '' }}">
<head>
    <title>@yield('title') | {{ Utility::getsettings('app_name') }}</title>
    <!-- Meta -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="title"
    content="{{ !empty(Utility::getsettings('meta_title'))
        ? Utility::getsettings('meta_title') :  Utility::getsettings('app_name')  }}">
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
    <!-- font css -->

    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/landing-page2/css/custom.css') }}">

    <link rel="stylesheet" href="{{ asset('vendor/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/landing-page2/css/landingpage-2.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/landing-page2/css/landingpage2-responsive.css') }}">


</head>

<body>
    <!-- [ auth-signup ] start -->
    <div class="auth-wrapper auth-v3">
        <!--header start here-->
        @include('layouts.app-header')
        <!--header end here-->
        @yield('content')
    </div>
    <!-- [ auth-signup ] end -->
    </div>
    <!--footer start here-->
    @include('layouts.app-footer')
    <!--footer end here-->
    <!--scripts start here-->
    <script src="{{ asset('vendor/landing-page2/js/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/landing-page2/js/slick.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap-notify.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bouncer.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form-validation.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>
    <script src="{{ asset('vendor/landing-page2/js/custom.js') }}"></script>

    <!--scripts end here-->
    <script>
        var toster_pos = 'right';
        feather.replace();
    </script>
    <script src="{{ asset('vendor/js/custom.js') }}"></script>
    <script>
        @if (session('failed'))
            show_toastr('Failed!', '{{ session('failed') }}', 'danger');
        @endif
        @if (session('errors'))
            show_toastr('Error!', '{{ session('errors') }}', 'danger');
        @endif
        @if (session('successful'))
            show_toastr('SuccessfulLY!', '{{ session('successful') }}', 'success');
        @endif
        @if (session('success'))
            show_toastr('Done!', '{{ session('success') }}', 'success');
        @endif
        @if (session('warning'))
            show_toastr('Warning!', '{{ session('warning') }}', 'warning');
        @endif

        @if (session('status'))
            show_toastr('Great!', '{{ session('status') }}', 'info');
        @endif

        $(document).on('click', '.delete-action', function() {
            var form_id = $(this).attr('data-form-id')
            $.confirm({
                title: '{{ __('Alert !') }}',
                content: '{{ __('Are You sure ?') }}',
                buttons: {
                    confirm: function() {
                        $("#" + form_id).submit();
                    },
                    cancel: function() {}
                }
            });
        });
    </script>

    <script>
        function myFunction() {
            const element = document.body;
            element.classList.toggle("dark-mode");
            const isDarkMode = element.classList.contains("dark-mode");
            const expirationDate = new Date();
            expirationDate.setDate(expirationDate.getDate() + 30);
            document.cookie = `mode=${isDarkMode ? "dark" : "light"}; expires=${expirationDate.toUTCString()}; path=/`;
            if (isDarkMode) {
                $('.switch-toggle').find('.switch-moon').addClass('d-none');
                $('.switch-toggle').find('.switch-sun').removeClass('d-none');
            } else {
                $('.switch-toggle').find('.switch-sun').addClass('d-none');
                $('.switch-toggle').find('.switch-moon').removeClass('d-none');
            }
        }
        window.addEventListener("DOMContentLoaded", () => {
            const modeCookie = document.cookie.split(";").find(cookie => cookie.includes("mode="));
            if (modeCookie) {
                const mode = modeCookie.split("=")[1];
                if (mode === "dark") {
                    $('.switch-toggle').find('.switch-moon').addClass('d-none');
                    $('.switch-toggle').find('.switch-sun').removeClass('d-none');
                    document.body.classList.add("dark-mode");
                } else {
                    $('.switch-toggle').find('.switch-sun').addClass('d-none');
                    $('.switch-toggle').find('.switch-moon').removeClass('d-none');
                }
            }
        });
    </script>
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
                data.name        = "{{ Utility::getsettings('app_name') }}";
                data.short_name  = "{{ Utility::getsettings('app_name') }}";
                data.start_url   = appUrl;

                const updatedManifest = JSON.stringify(data);
                const blob = new Blob([updatedManifest], {
                    type: 'application/json'
                });
                const url = URL.createObjectURL(blob);
                document.querySelector('link[rel="manifest"]').href = url;
            })
            .catch(error => console.error('Error fetching manifest.json:', error));
    </script>

    @stack('script')

    @if (Utility::getsettings('cookie_setting_enable') == 'on')
        @include('layouts.cookie-consent')
    @endif
</body>

</html>
