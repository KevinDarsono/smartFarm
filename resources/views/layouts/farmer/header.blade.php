<div class="app-header__content">
    <div class="app-header-left">
        <ul class="header-menu nav">
            <li class="nav-item">
                <a href="{{ route('home') }}" class="nav-link @if (Request::is('home')) is-active @endif">
                    <i class="nav-link-icon bi bi-house-door"></i>
                    Home
                </a>
            </li>
            <li class="btn-group nav-item">
                <a href="{{ route('lands.index') }}"
                    class="nav-link @if (Request::is('lands*')) is-active @endif">
                    <i class="nav-link-icon bi bi-columns-gap"></i>
                    Lahan
                </a>
            </li>
        </ul>
    </div>
    <div class="app-header-right">
        <!-- <div class="header-btn-lg pr-0"> -->
            <div class="widget-content p-0">
                <div class="widget-content-wrapper">
                    <div class="widget-content-left">
                        <div class="btn-group">
                            <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">
                                {{ Auth::user()->name . " (" . Auth::user()->role . ")" }}
                                <img width="30" class="rounded-circle" src="{{ asset('images/avatars/avatar.jpg') }}"
                                    alt="">
                                <i class="fa fa-angle-down ml-2 opacity-8"></i>
                            </a>
                            <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
                                <h6 tabindex="-1" class="dropdown-header">Account Settings</h6>
                                <button type="button" tabindex="0" class="dropdown-item">Profile</button>
                                <div tabindex="-1" class="dropdown-divider"></div>
                                <button type="button" tabindex="0" class="dropdown-item" onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">Log Out
                                </button>

                                {{-- Log Out Form --}}
                                <form id="logout-form" action="{{ route('auth.logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!-- </div> -->
    </div>
</div>
