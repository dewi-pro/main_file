@php
    use App\Models\Form;
    use App\Models\Booking;
    $user = \Auth::user();
    $currantLang = $user->currentLanguage();
    $languages = Utility::languages();
    $role_id = $user->roles->first()->id;
    $user_id = $user->id;
    if (Auth::user()->type == 'Admin') {
        $forms = Form::orderBy('created_at', 'asc')->get();
        $bookings = Booking::all();
    } else {
        if (\Auth::user()->can('access-all-submitted-form')) {
            $forms = Form::where('created_by', Auth::user()->id)->orWhere('created_by', Auth::user()->created_by)->orderBy('created_at', 'asc')->get();
            $bookings = Booking::all();
        } else {
            $forms = Form::select(['forms.*'])
            ->where(function ($query) use ($role_id, $user_id) {
                $query
                    ->whereIn('forms.id', function ($query1) use ($role_id) {
                        $query1
                            ->select('form_id')
                            ->from('assign_forms_roles')
                            ->where('role_id', $role_id);
                    })
                    ->OrWhereIn('forms.id', function ($query1) use ($user_id) {
                        $query1
                            ->select('form_id')
                            ->from('assign_forms_users')
                            ->where('user_id', $user_id);
                    })
                    ->OrWhere('assign_type', 'public');
            })->orderBy('created_at', 'asc')->get();

        $bookings = Booking::all();
        }
    }
    $bookings = $bookings->all();
@endphp
<nav class="dash-sidebar light-sidebar {{ $user->transprent_layout == 1 ? 'transprent-bg' : '' }}">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="{{ route('home') }}" class="text-center b-brand">
                <!-- ========   change your logo hear   ============ -->
                @if ($user->dark_layout == 1)
                    <img src="{{ asset('vendor/app_logo/LogoAntaVaya-removebg-preview.png') }}"
                        class="app-logo" />
                @else
                    <img src="{{ asset('vendor/app_logo/LogoAntaVaya-removebg-preview.png')}}"
                        class="app-logo" />
                @endif
            </a>
        </div>
        <div class="navbar-content">
            <ul class="dash-navbar d-block">
                <li class="dash-item dash-hasmenu {{ request()->is('/') ? 'active' : '' }}">
                    <a href="{{ route('home') }}" class="dash-link"><span class="dash-micon"><i
                                class="ti ti-home"></i></span>
                        <span class="dash-mtext custom-weight">{{ __('Dashboard') }}</span></a>
                </li>
                <!-- @can('manage-dashboardwidget')
                    <li class="dash-item dash-hasmenu {{ request()->is('index-dashboard*') ? 'active' : '' }}">
                        <a href="{{ route('index.dashboard') }}" class="dash-link"><span class="dash-micon"><i
                                    class="ti ti-square"></i></span>
                            <span class="dash-mtext custom-weight">{{ __('Dashboard Widgets') }}</span></a>
                    </li>
                @endcan -->
                @canany(['manage-user', 'manage-role'])
                    <li
                        class="dash-item dash-hasmenu {{ request()->is('users*') || request()->is('roles*') ? 'active dash-trigger' : 'collapsed' }}">
                        <a href="#!" class="dash-link"><span class="dash-micon"><i
                                    class="ti ti-layout-2"></i></span><span
                                class="dash-mtext">{{ __('User Management') }}</span><span class="dash-arrow"><i
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="dash-submenu">
                            @can('manage-user')
                                <li class="dash-item {{ request()->is('users*') ? 'active' : '' }}">
                                    <a class="dash-link" href="{{ route('users.index') }}">{{ __('Users') }}</a>
                                </li>
                            @endcan
                            @can('manage-role')
                                <li class="dash-item {{ request()->is('roles*') ? 'active' : '' }}">
                                    <a class="dash-link" href="{{ route('roles.index') }}">{{ __('Roles') }}</a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcanany

                @canany(['manage-form', 'manage-form-template', 'manage-submitted-form','manage-form-category'  , 'manage-form-type', 'manage-form-cluster', 'manage-form-leader'])
                    <li
                        class="dash-item dash-hasmenu {{ request()->is('forms*', 'design*') || request()->is('form-values*') || request()->is('form-category*') || request()->is('form-template*') || request()->is('form-template/design*')  || request()->is('form-type*') ? 'active dash-trigger' : 'collapsed' }}">
                        <a href="#!" class="dash-link"><span class="dash-micon"><i class="ti ti-table"></i></span><span
                                class="dash-mtext">{{ __('Form') }}</span><span class="dash-arrow"><i
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="dash-submenu">
                            @canany(['manage-submitted-form'])
                                <li class="dash-item">
                                    <a href="#!" class="dash-link"><span
                                            class="dash-mtext custom-weight">{{ __('Component') }}</span><span
                                            class="dash-arrow"><i data-feather="chevron-right"></i></span></a>
                                    <ul
                                        class="dash-submenu {{ Request::route()->getName() == 'view.form.values' ? 'd-block' : '' }}">
                                            @canany(['manage-form-type'])
                                                <li class="dash-item {{ request()->is('form-type*') ? 'active' : '' }}">
                                                    <a class="dash-link" href="{{ route('form-type.index') }}">{{ __('Type') }}</a>
                                                </li>
                                            @endcanany
                                            @canany(['manage-form-category'])
                                                <li class="dash-item {{ request()->is('form-category*') ? 'active' : '' }}">
                                                    <a class="dash-link" href="{{ route('form-category.index') }}">{{ __('Category') }}</a>
                                                </li>
                                            @endcanany
                                            @canany(['manage-form-cluster'])
                                                <li class="dash-item {{ request()->is('form-cluster*') ? 'active' : '' }}">
                                                    <a class="dash-link" href="{{ route('form-cluster.index') }}">{{ __('Cluster') }}</a>
                                                </li>
                                            @endcanany
                                            @canany(['manage-form-leader'])
                                                <li class="dash-item {{ request()->is('form-leader*') ? 'active' : '' }}">
                                                    <a class="dash-link" href="{{ route('form-leader.index') }}">{{ __('Tour Leader') }}</a>
                                                </li>
                                            @endcanany
                                    </ul>
                                </li>
                            @endcanany
                            @canany(['manage-form-template'])
                                <li
                                    class="dash-item {{ request()->is('form-template*') || request()->is('form-template/design*') ? 'active' : '' }}">
                                    <a class="dash-link" href="{{ route('form-template.index') }}">{{ __('Template') }}</a>
                                </li>
                            @endcanany
                            @canany(['manage-form'])
                                <li class="dash-item {{ request()->is('forms*', 'design*') ? 'active' : '' }}">
                                    <a class="dash-link" href="{{ route('forms.index') }}">{{ __('Forms') }}</a>
                                </li>
                            @endcanany
                            <!-- @canany(['manage-submitted-form'])
                                <li class="dash-item">
                                    <a href="#!" class="dash-link"><span
                                            class="dash-mtext custom-weight">{{ __('Submitted Forms') }}</span><span
                                            class="dash-arrow"><i data-feather="chevron-right"></i></span></a>
                                    <ul
                                        class="dash-submenu {{ Request::route()->getName() == 'view.form.values' ? 'd-block' : '' }}">
                                        @foreach ($forms as $form)
                                            @php
                                                $formValueIds = App\Models\FormValue::where('form_id', $form->id)
                                                    ->pluck('id')
                                                    ->toArray();
                                                    $formValueParam = Request::route()->parameters('form_value');
                                                    $formValueId = isset($formValueParam['form_value'])
                                                    ? $formValueParam['form_value']
                                                    : null;
                                            @endphp
                                            <li class="dash-item {{ in_array($formValueId, $formValueIds) ? 'active' : '' }}">
                                                <a class="dash-link {{ Request::route()->getName() == 'view.form.values'  || in_array($formValueId, $formValueIds) ? 'show' : '' }}"
                                                    href="{{ route('view.form.values', $form->id) }}">{{ $form->title }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endcanany -->
                        </ul>
                    </li>
                @endcanany
                @canany(['manage-report', 'manage-report-co'])
                    <li class="dash-item dash-hasmenu {{ request()->is('event*') ? 'active' : '' }}">
                        <a href="#!" class="dash-link"><span class="dash-micon"><i
                                    class="ti ti-calendar"></i></span><span
                                class="dash-mtext">{{ __('Report') }}</span><span class="dash-arrow"><i
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="dash-submenu">
                            @can('manage-report')
                                <li class="dash-item {{ request()->is('event*') ? 'active' : '' }}">
                                    <a class="dash-link" href="{{ route('event.index') }}">{{ __('Tour') }}</a>
                                </li>
                            @endcan
                            @can('manage-report-co')
                                <li class="dash-item {{ request()->is('reportco*') ? 'active' : '' }}">
                                    <a class="dash-link" href="{{ route('reportco.index') }}">{{ __('Corporate & Operation') }}</a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcanany
                <!-- @can('manage-announcement')
                    @if (Auth::user()->type == 1)
                        <li class="dash-item dash-hasmenu {{ request()->is('announcement*') ? 'active' : '' }}">
                            <a href="{{ route('announcement.index') }}" class="dash-link">
                                <span class="dash-micon">
                                    <i class="ti ti-confetti">
                                    </i>
                                </span>
                                <span class="dash-mtext">{{ __('Announcement') }}
                                </span>
                            </a>
                        </li>
                    @else
                        <li
                            class="dash-item {{ request()->is('show-announcement-list*') || request()->is('show-announcement*') ? 'active' : '' }}">
                            <a class="dash-link d-flex align-items-center" href="{{ route('show.announcement.list') }}">
                                <span class="dash-micon">
                                    <i class="ti ti-confetti">
                                    </i>
                                </span>
                                <span>{{ __('Show Announcement List') }}</span></a>
                        </li>
                    @endif
                @endcan -->
                <!-- @canany(['manage-chat'])
                    @if (setting('pusher_status') == '1')
                        <li
                            class="dash-item dash-hasmenu {{ request()->is('chat*') ? 'active dash-trigger' : 'collapsed' }}">
                            <a href="#!" class="dash-link"><span class="dash-micon"><i
                                        class="ti ti-table"></i></span><span
                                    class="dash-mtext">{{ __('Support') }}</span><span class="dash-arrow"><i
                                        data-feather="chevron-right"></i></span></a>
                            <ul class="dash-submenu">
                                @can('manage-chat')
                                    <li class="dash-item">
                                        <a class="dash-link" href="{{ route('chats') }}">{{ __('Chats') }}</a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endif
                @endcanany
               @canany(['manage-mailtemplate', 'manage-sms-template', 'manage-language', 'manage-setting']) 
                    <li
                        class="dash-item dash-hasmenu {{ request()->is('mailtemplate*') || request()->is('sms-template*') || request()->is('manage-language*') || request()->is('create-language*') || request()->is('settings*') ? 'active dash-trigger' : 'collapsed' }} || {{ request()->is('create-language*') || request()->is('settings*') ? 'active' : '' }}">
                        <a href="#!" class="dash-link"><span class="dash-micon"><i
                                    class="ti ti-apps"></i></span><span
                                class="dash-mtext">{{ __('Account Setting') }}</span><span class="dash-arrow"><i
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="dash-submenu">
                            @can('manage-mailtemplate')
                                <li class="dash-item {{ request()->is('mailtemplate*') ? 'active' : '' }}">
                                    <a class="dash-link"
                                        href="{{ route('mailtemplate.index') }}">{{ __('Email Templates') }}</a>
                                </li>
                            @endcan
                            @can('manage-sms-template')
                                <li class="dash-item {{ request()->is('sms-template*') ? 'active' : '' }}">
                                    <a class="dash-link"
                                        href="{{ route('sms-template.index') }}">{{ __('Sms Templates') }}</a>
                                </li>
                            @endcan
                            @can('manage-language')
                                <li
                                    class="dash-item {{ request()->is('manage-language*') || request()->is('create-language*') ? 'active' : '' }}">
                                    <a class="dash-link"
                                        href="{{ route('manage.language', [$currantLang]) }}">{{ __('Manage Languages') }}</a>
                                </li>
                            @endcan
                            @can('manage-setting')
                                <li class="dash-item {{ request()->is('settings*') ? 'active' : '' }}">
                                    <a class="dash-link" href="{{ route('settings') }}">{{ __('Settings') }}</a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcanany
                @canany(['manage-landing-page', 'manage-faqs', 'manage-testimonial', 'manage-page-setting'])
                    <li
                        class="dash-item dash-hasmenu {{ request()->is('landingpage-setting*') || request()->is('faqs*') || request()->is('page-setting*') || request()->is('testimonials*') ? 'active dash-trigger' : 'collapsed' }}">
                        <a href="#!" class="dash-link"><span class="dash-micon"><i
                                    class="ti ti-table"></i></span><span
                                class="dash-mtext">{{ __('Frontend Setting') }}</span><span class="dash-arrow"><i
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="dash-submenu">
                            @can('manage-landing-page')
                                <li class="dash-item {{ request()->is('landingpage-setting*') ? 'active' : '' }}">
                                    <a class="dash-link"
                                        href="{{ route('landing-page.setting') }}">{{ __('Landing Page') }}</a>
                                </li>
                            @endcan
                            @can('manage-testimonial')
                                <li class="dash-item {{ request()->is('testimonials*') ? 'active' : '' }}">
                                    <a class="dash-link"
                                        href="{{ route('testimonial.index') }}">{{ __('Testimonials') }}</a>
                                </li>
                            @endcan
                            @can('manage-faqs')
                                <li class="dash-item {{ request()->is('faqs*') ? 'active' : '' }}">
                                    <a class="dash-link" href="{{ route('faqs.index') }}">{{ __('FAQs') }}</a>
                                </li>
                            @endcan
                            @can('manage-page-setting')
                                <li class="dash-item {{ request()->is('page-setting*') ? 'active' : '' }}">
                                    <a class="dash-link"
                                        href="{{ route('page-setting.index') }}">{{ __('Page Settings') }}</a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcanany
                 @if (Auth::user()->type == 'Admin')
                    <li
                        class="dash-item dash-hasmenu {{ request()->is('telescope*') ? 'active dash-trigger' : 'collapsed' }}">
                        <a class="dash-link"><span class="dash-micon"><i
                                    class="ti ti-device-desktop-analytics"></i></span><span
                                class="dash-mtext">{{ __('System Analytics') }}</span><span class="dash-arrow"><i
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="dash-submenu">
                            <li class="dash-item {{ request()->is('telescope*') ? 'active' : '' }}">
                                <a class="dash-link"
                                    href="{{ route('telescope') }}">{{ __('Telescope Dashboard') }}</a>
                            </li>
                        </ul>
                    </li>
                @endif-->
            </ul>
        </div>
    </div>
</nav>
