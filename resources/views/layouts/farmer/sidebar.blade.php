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
                <li class="app-sidebar__heading">Lahan {{ $land->name}}</li>
                <li>
                    <a href="{{ route('lands.show', $land->id) }}" @if (Route::is('lands.show')) class="mm-active" @endif>
                        <i class="metismenu-icon bi bi-house-door"></i>
                        {{ __('Overview') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('lands.devices.index', $land->id) }}" @if (Route::is('lands.devices*')) class="mm-active" @endif>
                        <i class="metismenu-icon bi bi-motherboard"></i>
                        {{ __('Devices') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('quality-detector', $land->id) }}" @if (Route::is('quality-detector')) class="mm-active" @endif>
                        <i class="metismenu-icon bi bi-bug"></i>
                        {{ __('Deteksi Kualitas Padi') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('lands.edit', $land->id) }}" @if (Route::is('lands.edit')) class="mm-active" @endif>
                        <i class="metismenu-icon bi bi-gear"></i>
                        {{ __('Pengaturan') }}
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
