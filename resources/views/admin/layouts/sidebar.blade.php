<div class="app-sidebar sidebar-shadow">
    <div class="app-header__logo">
        <div class="logo-src"></div>
        <div class="header__pane ml-auto">
            <div>
                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <div class="app-header__mobile-menu">
        <div>
            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
    </div>
    <div class="app-header__menu">
        <span>
            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                <span class="btn-icon-wrapper">
                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                </span>
            </button>
        </span>
    </div>
    <div class="scrollbar-sidebar">
        <div class="app-sidebar__inner">
            <ul class="vertical-nav-menu">
                <li class="app-sidebar__heading">Dashboards</li>
                <li>
                    <a href="{{ route('dashboard') }}" @if (Route::is('dashboard')) class="mm-active" @endif>
                        <i class="metismenu-icon bi bi-house-door"></i>
                        {{ __('Home') }}
                    </a>
                </li>
                <li>
                    <a href="{{ url('/lands') }}" @if (Route::is('lands')) class="mm-active" @endif>
                        <i class="metismenu-icon bi bi-columns-gap"></i>
                        {{ __('Lands') }}
                    </a>
                </li>
                <li>
                    <a href="{{ url('/users') }}" @if (Route::is('users*')) class="mm-active" @endif>
                        <i class="metismenu-icon bi bi-people"></i>
                        {{ __('Users') }}
                    </a>
                </li>
                <li>
                    <a href="{{ url('/sensor') }}" @if (Route::is('sensor')) class="mm-active" @endif>
                        <i class="metismenu-icon bi bi-tools"></i>
                        {{ __('Sensor Configuration')}}
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
