@php
    $containerNav = $containerNav ?? 'container-fluid';
    $navbarDetached = $navbarDetached ?? '';
    use App\Models\Notification;
@endphp

<!-- Navbar -->
@if (isset($navbarDetached) && $navbarDetached == 'navbar-detached')
    <nav class="layout-navbar {{ $containerNav }} navbar navbar-expand-xl {{ $navbarDetached }} align-items-center bg-navbar-theme"
        id="layout-navbar">
@endif
@if (isset($navbarDetached) && $navbarDetached == '')
    <nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
        <div class="{{ $containerNav }}">
@endif

<!--  Brand demo (display only for navbar-full and hide on below xl) -->
@if (isset($navbarFull))
    <div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4">
        <a href="{{ url('/') }}" class="app-brand-link gap-2">
            <span class="app-brand-logo demo">
                @include('_partials.macros', ['width' => 25, 'withbg' => '#696cff'])
            </span>
            <span class="app-brand-text demo menu-text fw-bolder">{{ config('variables.templateName') }}</span>
        </a>
    </div>
@endif

<!-- ! Not required for layout-without-menu -->
@if (!isset($navbarHideToggle))
    <div
        class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0{{ isset($menuHorizontal) ? ' d-xl-none ' : '' }} {{ isset($contentNavbar) ? ' d-xl-none ' : '' }}">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>
@endif

@push('style')
    <style>
        .avatar.bell-online:after {
            background-color: #e70505;
        }

        .avatar.bell-online:after {
            content: "";
            position: absolute;
            top: 10px;
            right: 11px;
            width: 8px;
            height: 8px;
            border-radius: 100%;
            box-shadow: 0 0 0 2px #fff;
        }
    </style>
@endpush

@php
    if (auth()->user()->access_type == 1) {
        $notifications = Notification::where(['user_id' => null, 'read' => 0, 'type' => 1])
            ->select('id', 'lead_id', 'notification')
            ->latest()
            ->take(10)
            ->get();
    } else {
        $notifications = Notification::where(['user_id' => auth()->user()->id, 'read' => 0, 'type' => 2])
            ->select('id', 'lead_id', 'notification')
            ->latest()
            ->take(10)
            ->get();
    }
@endphp


<div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
    <!-- Search -->
    <div class="navbar-nav align-items-center">
        <div class="nav-item d-flex align-items-center">
            <i class="bx bx-search fs-4 lh-0"></i>
            <input type="text" class="form-control border-0 shadow-none" placeholder="Search..."
                aria-label="Search...">
        </div>
    </div>
    <!-- /Search -->
    <ul class="navbar-nav flex-row align-items-center ms-auto">

        <!-- Notifucation -->
        <li class="nav-item navbar-dropdown dropdown-notification dropdown">
            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown" title="Notifications">
                <div class="avatar">
                    {{-- bell-online --}}
                    <img src="{{ asset('assets/img/bell2.png') }}" alt class="w-px-30 h-auto rounded-circle mt-2">
                </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg-end" style="width: 400px; max-width: 400px; overflow:hidden">
                <li>
                    <a class="dropdown-item" href="javascript:void(0);">
                        <div class="text-center">
                            <div class="flex-grow-1">
                                <span class="fw-semibold d-block">Notifications</span>
                                {{-- <small
                                class="text-muted">{{ auth()->user()->access_type == 1 ? 'Admin' : 'Staff' }}</small> --}}
                            </div>
                        </div>
                    </a>
                </li>
                <li>
                    <div class="dropdown-divider"></div>
                </li>

                {{-- Notification List --}}
                {{-- {{ printData($notifications->toArray()) }} --}}

                @forelse ($notifications as $notification)

                <li>
                    <a class="dropdown-item" href="javascript:void(0)">
                        <i class="bx bx-bell me-2"></i>
                        <span class="align-middle">{!! $notification->notification !!}</span>
                    </a>
                </li>
                @empty
                <li>
                  <a class="dropdown-item text-center" href="javascript:void(0)">
                      <span class="align-middle">No notifications found.</span>
                  </a>
              </li>
                @endforelse
                {{-- Notification List End --}}
            </ul>
        </li>
        <!--/ Notification -->


        <!-- Place this tag where you want the button to render. -->
        <li class="nav-item lh-1 me-3">
            <a class="github-button" href="javascript:void(0)" data-icon="octicon-star" data-size="large"
                data-show-count="true"
                aria-label="Star themeselection/sneat-html-laravel-admin-template-free on GitHub">{{ auth()->user()->first_name . ' ' . (isset(auth()->user()->last_name) ? auth()->user()->last_name : '') }}</a>
        </li>

        <!-- User -->
        <li class="nav-item navbar-dropdown dropdown-user dropdown">
            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                <div class="avatar avatar-online">
                    @php
                        $name = auth()->user()->first_name . ' ' . (isset(auth()->user()->last_name) ? auth()->user()->last_name : '');
                        function first_letter($str)
                        {
                            return implode(
                                '',
                                array_map(function ($v) {
                                    return $v[0];
                                }, array_filter(array_map('trim', explode(' ', $str)))),
                            );
                        }
                        $shortName = first_letter($name);
                    @endphp
                    <span
                        style="display:block;width: 43px;height: 41px;background-color: #faae15;color: #000000;border: none;border-radius: 20px;text-align: center;padding: 11px 0px;font-weight: 700;">{{ $shortName }}</span>
                    {{-- <img src="{{ asset('assets/img/avatars/1.png') }}" alt class="w-px-40 h-auto rounded-circle"> --}}
                </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="dropdown-item" href="javascript:void(0);">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar avatar-online">
                                    <span
                                        style="display:block;width: 43px;height: 41px;background-color: #faae15;color: #000000;border: none;border-radius: 20px;text-align: center;padding: 11px 0px;font-weight: 700;">{{ $shortName }}</span>
                                    {{-- <img src="{{ asset('assets/img/avatars/1.png') }}" alt
                                        class="w-px-40 h-auto rounded-circle"> --}}
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <span
                                    class="fw-semibold d-block">{{ auth()->user()->first_name . ' ' . (isset(auth()->user()->last_name) ? auth()->user()->last_name : '') }}</span>
                                <small
                                    class="text-muted">{{ auth()->user()->access_type == 1 ? 'Admin' : 'Staff' }}</small>
                            </div>
                        </div>
                    </a>
                </li>
                <li>
                    <div class="dropdown-divider"></div>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('my-profile') }}">
                        <i class="bx bx-user me-2"></i>
                        <span class="align-middle">My Profile</span>
                    </a>
                </li>
                {{-- <li>
                    <a class="dropdown-item" href="javascript:void(0);">
                        <i class='bx bx-cog me-2'></i>
                        <span class="align-middle">Settings</span>
                    </a>
                </li> --}}
                <li>
                    <div class="dropdown-divider"></div>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('logout') }}">
                        <i class='bx bx-power-off me-2'></i>
                        <span class="align-middle">Log Out</span>
                    </a>
                </li>
            </ul>
        </li>
        <!--/ User -->
    </ul>
</div>

@if (!isset($navbarDetached))
    </div>
@endif
</nav>
<!-- / Navbar -->
