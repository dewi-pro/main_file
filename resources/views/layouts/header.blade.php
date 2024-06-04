@php
    $users = \Auth::user();
    $currantLang = $users->currentLanguage();
    $languages = Utility::languages();
@endphp
<header class="dash-header {{ $user->transprent_layout == 1 ? 'transprent-bg' : '' }}">
    <div class="header-wrapper">
        <div class="me-auto dash-mob-drp">
            <ul class="list-unstyled">
                <li class="dash-h-item mob-hamburger">
                    <a href="#!" class="dash-head-link" id="mobile-collapse">
                        <div class="hamburger hamburger--arrowturn">
                            <div class="hamburger-box">
                                <div class="hamburger-inner"></div>
                            </div>
                        </div>
                    </a>
                </li>
                <li class="dropdown dash-h-item">
                    <a class="dash-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" aria-expanded="false">
                            <img src="{{ Storage::exists($users->avatar) ? Storage::url(Auth::user()->avatar) : Auth::user()->avatar_image  }}" class="user-avtar ms-2" />
                        <span class="pr-1">
                            <h6 class="mb-0 f-w-500 fs-6 d-inline-flex">{{ Auth::user()->name }}</h6>
                        </span>
                        <i class="ti ti-chevron-down drp-arrow nocolor"></i>
                    </a>
                    <div class="dropdown-menu dash-h-dropdown">
                        <a href="{{ route('profile.index') }}" class="dropdown-item">
                            <i class="ti ti-user"></i>
                            <span>{{ __('Profile') }}</span>
                        </a>
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                            class="dropdown-item">
                            <i class="ti ti-power"></i>
                            <span>{{ __('Logout') }}</span>
                        </a>
                        {!! Form::open([
                            'route' => ['logout'],
                            'method' => 'POST',
                            'id' => 'logout-form',
                            'class' => 'd-none',
                        ]) !!}
                        {!! Form::close() !!}
                    </div>
                </li>
            </ul>
        </div>
        <div class="ms-auto">
            <ul class="list-unstyled">
                @impersonating($guard = null)
                    <li class="dropdown dash-h-item drp-company">
                        <a class="btn btn-primary btn-active-color-primary btn-outline-secondary me-3"
                            href="{{ route('impersonate.leave') }}"><i class="ti ti-ban"></i>
                            {{ __('Exit Impersonation') }}
                        </a>
                    </li>
                @endImpersonating
                <!-- <li class="dash-h-item theme_mode">
                    <a class="dash-head-link add_dark_mode me-0" role="button">
                        <i class="ti {{ Utility::getsettings('dark_mode') == 'off' ? 'ti-sun' : 'ti-moon' }}"></i>
                    </a>
                </li> -->
                {{-- <input type="hidden" name="mode" id="mode" value="{{ auth()->user()->dark_layout == '0' ? 'light' : 'dark' }}"> --}}
                <li class="dropdown dash-h-item drp-notification">
                    <a class="dash-head-link dropdown-toggle arrow-none me-0" id="kt_activities_toggle"
                        data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                        aria-expanded="false">
                        <i class="ti ti-bell"></i>
                        <span
                            class="bg-danger dash-h-badge
                        @if (auth()->user()->unreadnotifications->count()) dots @endif"><span
                                class="sr-only"></span></span>
                    </a>
                    <div class="dropdown-menu dash-h-dropdown dropdown-menu-end">

                        <div class="noti-header">
                            <h5 class="m-0">{{ __('Notification') }}</h5>
                        </div>
                        <div class="noti-body">
                            @foreach (auth()->user()->notifications->where('read_at', '=', '') as $notification)
                                @if ($notification->type == 'App\Notifications\TestingPurpose')
                                    <div class="my-4 d-flex align-items-start">
                                        <div class="theme-avtar bg-danger">
                                            <i class="ti ti-mail"></i>
                                        </div>
                                        <div class="ms-3 flex-grow-1">
                                            <div class="d-flex align-items-start justify-content-between">
                                                <a href="javascript:void(0);">
                                                    <h6>{{ __('Testing Mail Send') }}</h6>
                                                </a>
                                            </div>
                                            <div class="d-flex align-items-end justify-content-between">
                                                <p class="mb-0 text-muted">
                                                    {{ __('you have send mail') }}
                                                    {{ isset($notification->data['data']['email']) ? $notification->data['data']['email'] : '' }}
                                                </p>
                                                <span
                                                    class="text-sm ms-2 text-nowrap">{{ Utility::date_time_format($notification->created_at) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if ($notification->type == 'App\Notifications\RegisterMail')
                                    <div class="d-flex align-items-start my-4">
                                        <div class="theme-avtar bg-danger">
                                            <i class="ti ti-mail"></i>
                                        </div>
                                        <div class="ms-3 flex-grow-1">
                                            <div class="d-flex align-items-start justify-content-between">
                                                <a href="javascript:void(0);">
                                                    <h6>{{ __('New User Create') }}</h6>
                                                </a>
                                            </div>
                                            <div class="d-flex align-items-end justify-content-between">
                                                <p class="mb-0 text-muted">
                                                    {{ __('New') }}
                                                    {{ isset($notification->data['data']['email']) ? $notification->data['data']['email'] : '' }}{{ __(' User Create') }}
                                                </p>
                                                <span
                                                    class="text-sm ms-2 text-nowrap">{{ Utility::date_time_format($notification->created_at) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if ($notification->type == 'App\Notifications\CreateForm')
                                    <div class="my-4 d-flex align-items-start">
                                        <div class="theme-avtar bg-primary">
                                            <i class="ti ti-device-desktop"></i>
                                        </div>
                                        <div class="ms-3 flex-grow-1">
                                            <div class="d-flex align-items-start justify-content-between">
                                                <a href="#">
                                                    <h6>{{ __('New Form create') }}</h6>
                                                </a>
                                            </div>
                                            <div class="d-flex align-items-end justify-content-between">
                                                @php
                                                    $notify = json_decode($notification);
                                                    $email = $notify->data->data->form->email;
                                                @endphp
                                                <p class="mb-0 text-muted">
                                                    {{ $email }}
                                                </p>
                                                <span
                                                    class="text-sm ms-2 text-nowrap">{{ Utility::date_time_format($notification->created_at) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if ($notification->type == 'App\Notifications\NewSurveyDetails')
                                    <div class="my-4 d-flex align-items-start">
                                        <div class="theme-avtar bg-primary">
                                            <i class="ti ti-clipboard-list"></i>
                                        </div>
                                        <div class="ms-3 flex-grow-1">
                                            <div class="d-flex align-items-start justify-content-between">
                                                <a href="#">
                                                    <h6>{{ __('New Form Submit') }}</h6>
                                                </a>
                                            </div>
                                            <div class="d-flex align-items-end justify-content-between">
                                                <p class="mb-0 text-muted">
                                                    {{ __('New') }}
                                                    {{ isset($notification->data['data']['title']) ? $notification->data['data']['title'] : '' }}{{ __(' Form Submit') }}
                                                </p>
                                                <span
                                                    class="text-sm ms-2 text-nowrap">{{ Utility::date_time_format($notification->created_at) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if ($notification->type == 'App\Notifications\NewEnquiryDetails')
                                    <div class="d-flex align-items-start my-4">
                                        <div class="theme-avtar bg-danger">
                                            <i class="ti ti-mail"></i>
                                        </div>
                                        <div class="ms-3 flex-grow-1">
                                            <div class="d-flex align-items-start justify-content-between">
                                                <a href="javascript:void(0);">
                                                    <h6>{{ __('New Enquiry Details') }}</h6>
                                                </a>
                                            </div>
                                            <div class="d-flex align-items-end justify-content-between">
                                                <p class="mb-0 text-muted">
                                                    {{ __('New') }}
                                                    {{ isset($notification->data['data']['email']) ? $notification->data['data']['email'] : '' }}{{ __(' Enquiry Details') }}
                                                </p>
                                                <span
                                                    class="text-sm ms-2 text-nowrap">{{ Utility::date_time_format($notification->created_at) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if ($notification->type == 'App\Notifications\NewBookingSurveyDetails')
                                    <div class="d-flex align-items-start my-4">
                                        <div class="theme-avtar bg-danger">
                                            <i class="ti ti-mail"></i>
                                        </div>
                                        <div class="ms-3 flex-grow-1">
                                            <div class="d-flex align-items-start justify-content-between">
                                                <a href="javascript:void(0);">
                                                    <h6>{{ __('New Booking Details') }}</h6>
                                                </a>
                                            </div>
                                            <div class="d-flex align-items-end justify-content-between">
                                                <p class="mb-0 text-muted">
                                                    {{ __('New') }}
                                                    {{ isset($notification->data['data']['title']) ? $notification->data['data']['title'] : '' }}{{ __(' Booking Details') }}
                                                </p>
                                                <span
                                                    class="text-sm ms-2 text-nowrap">{{ Utility::date_time_format($notification->created_at) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </li>
                <!-- <li class="dropdown dash-h-item drp-language">
                    <a class="dash-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown"
                        href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <i class="pr-1 ti ti-world nocolor"></i>
                        <span class="pr-1 drp-text hide-mob">{{ Str::upper($currantLang) }}</span>
                        <i class="ti ti-chevron-down drp-arrow nocolor"></i>
                    </a>
                    <div class=" dash-lang-width dropdown-menu dash-h-dropdown dropdown-menu-end">
                        @foreach ($languages as $language)
                            <a class="dropdown-item @if ($language == $currantLang) text-danger @endif"
                                href="{{ route('change.language', $language) }}">{{ Str::upper($language) }}</a>
                        @endforeach
                    </div>
                </li> -->
            </ul>
        </div>
    </div>
</header>
