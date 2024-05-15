<div class="left-bar">
    <div class="left-sidebar-toggler">
        <div class="menu-bar">
            <svg width="20" height="20" class="menu-btn" viewBox="0 0 13 10">
                <path d="M0 0h13v2H0V0zm0 4h13v2H0V4zm0 4h13v2H0V8z" fill-rule="evenodd"></path>
            </svg>
            <div class="main-logo doc-logo mobile-device">
                <a href="javascript:void(0);" class="logo-space" tabindex="0">
                    @if (App\Facades\UtilityFacades::getsettings('storage_type') == 'local')
                    {!! Form::image(
                        $document->logo
                            ? (Storage::exists($document->logo)
                                ? asset('storage/app/' . $document->logo)
                                : Storage::url('app-logo/app-dark-logo.png'))
                            : ($document->logo != ''
                                ? asset('storage/app/' . $document->logo)
                                : Storage::url('app-logo/app-dark-logo.png')),
                        null,
                        [
                            'class' => 'me-3 wid-50 side-bar-logo',
                        ],
                    ) !!}
                @else
                    {!! Form::image(Storage::url($document->logo), null, [
                        'class' => 'me-3 wid-logo side-bar-logo wid-50',
                    ]) !!}
                @endif
                </a>
            </div>
        </div>
    </div>
    <div class="left-inner-content">
        <div class="main-logo doc-logo desktop-device">
            <a href="javascript:void(0);" class="logo-space" tabindex="0">
                @if (App\Facades\UtilityFacades::getsettings('storage_type') == 'local')
                {!! Form::image(
                    $document->logo
                        ? (Storage::exists($document->logo)
                            ? asset('storage/app/' . $document->logo)
                            : Storage::url('app-logo/app-dark-logo.png'))
                        : ($document->logo != ''
                            ? asset('storage/app/' . $document->logo)
                            : Storage::url('app-logo/app-dark-logo.png')),
                    null,
                    [
                        'class' => 'me-3 wid-50 side-bar-logo',
                    ],
                ) !!}
            @else
                {!! Form::image(Storage::url($document->logo), null, [
                    'class' => 'me-3 wid-50 side-bar-logo',
                ]) !!}
            @endif
            </a>
        </div>
        <span class="search-wrapper">
            <input type="text" placeholder="Search" id="myInput" onkeyup="myFunction()" title="Type in a name">
        </span>
        <ul class="left-inner-menu acnav-list" id="myUL">
            @php $i = 0; @endphp
            @foreach ($docMenu as $key => $menu)
                @if ($menu->parent_id == 0)
                    @if (in_array($menu->id, $parentArray))
                        @php
                            $documentmenu = App\Models\DocumentMenu::where('parent_id', $menu->id)->get();
                        @endphp
                        <li
                            class="menu-item has-children
                            @if (isset($documentMenu->slug)) @if ($menu->slug == $documentMenu->slug)
                                        active-color @endif
@else
@if ($key == 0) active-color @endif
                                @endif
                            @foreach ($documentmenu as $key => $docmenu)
                                    @if (Request::is('document/' . $menu->slug . '/*'))
                                        active
                                    @elseif (isset($documentMenu->slug))
                                        @if ($menu->slug == $documentMenu->slug)
                                            active
                                        @endif
                                    @else
                                        @if ($i == 0 && Request::is('document/public*'))
                                            active
                                        @endif
                                    @endif @endforeach">
                            <span class="acnav-label @if (request()->is('document/' . $menu->slug . '/' . $menus->slug . '/*')) is-open @endif">
                                <a href="{{ route('documentmenu.menu', $menu->slug) }}" tabindex="0">
                                    {{ substr($menu->title, 0, 22) . (strlen($menu->title) > 22 ? '...' : '') }}
                                </a>
                                <div class="down-arrow">
                                    <svg width="24" height="24" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M7.29571 15.3171C7.48307 15.5034 7.73652 15.6079 8.00071 15.6079C8.26489 15.6079 8.51834 15.5034 8.70571 15.3171L12.2957 11.7771L15.8357 15.3171C16.0231 15.5034 16.2765 15.6079 16.5407 15.6079C16.8049 15.6079 17.0583 15.5034 17.2457 15.3171C17.3394 15.2242 17.4138 15.1136 17.4646 14.9917C17.5154 14.8698 17.5415 14.7391 17.5415 14.6071C17.5415 14.4751 17.5154 14.3444 17.4646 14.2225C17.4138 14.1007 17.3394 13.9901 17.2457 13.8971L13.0057 9.65712C12.9127 9.56339 12.8021 9.48899 12.6803 9.43823C12.5584 9.38746 12.4277 9.36132 12.2957 9.36132C12.1637 9.36132 12.033 9.38746 11.9111 9.43823C11.7893 9.48899 11.6787 9.56339 11.5857 9.65712L7.29571 13.8971C7.20198 13.9901 7.12758 14.1007 7.07681 14.2225C7.02605 14.3444 6.99991 14.4751 6.99991 14.6071C6.99991 14.7391 7.02605 14.8698 7.07681 14.9917C7.12758 15.1136 7.20198 15.2242 7.29571 15.3171Z">
                                        </path>
                                    </svg>
                                </div>
                            </span>
                            <ul class="acnav-list">
                                @foreach ($documentmenu as $key => $docmenu)
                                    <li class="@if (Request::is('document/' . $menu->slug . '/' . $docmenu->slug)) activemenu @endif">
                                        <a class="active" tabindex="0"
                                            href="{{ route('documentsubmenu.submenu', [$menu->slug, $docmenu->slug]) }}">
                                            {{ substr($docmenu->title, 0, 22) . (strlen($docmenu->title) > 22 ? '...' : '') }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                            </span>
                        </li>
                    @else
                        <li
                            class="menu-item @if (isset($documentMenu->id)) @if ($menu->id == $documentMenu->id)
                            activemenu @endif
@else
@if ($key == 0) activemenu @endif @endif">
                            <a class="acnav-label" href="{{ route('documentmenu.menu', $menu->slug) }}">
                                <span>{{ substr($menu->title, 0, 24) . (strlen($menu->title) > 24 ? '...' : '') }}</span>
                            </a>
                        </li>
                    @endif
                @endif
                @php $i++; @endphp
            @endforeach
            @php
                if (str_contains(Request::url(), '/document/')) {
                    $segments = explode('/', Request::url());
                    $lastSegment = $segments[count($segments) - 2];
                    if (str_contains(Request::url(), '/document/public')) {
                        $lastSegment = last($segments);
                    }
                    $lastSegments = last($segments);
                } elseif (str_contains(Request::url(), '/documents/')) {
                    $segments = explode('/', Request::url());
                    $lastSegments = last($segments);
                    if ($lastSegments == 'changelog') {
                        $lastSegment = $segments[count($segments) - 2];
                    } else {
                        $lastSegment = last($segments);
                    }
                }
                if ($changeLogJsons) {
                    usort($changeLogJsons, function ($a, $b) {
                        return version_compare($b['version'], $a['version']);
                    });
                }
            @endphp
            @if ($document->change_log_status == 'on')
                <li class="menu-item has-children">
                    <span class="acnav-label">
                        <a href="javascript:void(0);" class="nav-link text-menu">
                            <span class="">
                                {{ __('Change Log') }}
                            </span>
                        </a>
                        <div class="down-arrow">
                            <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M7.29571 15.3171C7.48307 15.5034 7.73652 15.6079 8.00071 15.6079C8.26489 15.6079 8.51834 15.5034 8.70571 15.3171L12.2957 11.7771L15.8357 15.3171C16.0231 15.5034 16.2765 15.6079 16.5407 15.6079C16.8049 15.6079 17.0583 15.5034 17.2457 15.3171C17.3394 15.2242 17.4138 15.1136 17.4646 14.9917C17.5154 14.8698 17.5415 14.7391 17.5415 14.6071C17.5415 14.4751 17.5154 14.3444 17.4646 14.2225C17.4138 14.1007 17.3394 13.9901 17.2457 13.8971L13.0057 9.65712C12.9127 9.56339 12.8021 9.48899 12.6803 9.43823C12.5584 9.38746 12.4277 9.36132 12.2957 9.36132C12.1637 9.36132 12.033 9.38746 11.9111 9.43823C11.7893 9.48899 11.6787 9.56339 11.5857 9.65712L7.29571 13.8971C7.20198 13.9901 7.12758 14.1007 7.07681 14.2225C7.02605 14.3444 6.99991 14.4751 6.99991 14.6071C6.99991 14.7391 7.02605 14.8698 7.07681 14.9917C7.12758 15.1136 7.20198 15.2242 7.29571 15.3171Z">
                                </path>
                            </svg>
                        </div>
                    </span>
                    <ul class="dropdown-menu acnav-list">
                        @foreach ($changeLogJsons as $changeLog)
                            @php
                                $changelogId = str_replace('.', '_', $changeLog['version']);
                            @endphp
                            <li class="c_log">
                                <a class="nav-link"
                                    href="{{ $lastSegments != 'changelog' ? route('documentmenu.menu', [$lastSegment, 'changelog']) . '#' . $changelogId : '#' . $changelogId }}">
                                    {{ 'v' . $changeLog['version'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endif
        </ul>
        <div class="left-bar-logo">
            <a href="javascript:void(0);" tabindex="0">
                © {{ date('Y') }} {{ config('app.name') }}
            </a>
        </div>
    </div>
</div>
