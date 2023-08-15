<ul class="vertical-nav-menu">
    <li class="app-sidebar__heading">Dashboards</li>
    <li>
        <a href="{{ route('dashboard') }}" @if(Route::is('dashboard') )class="mm-active"@endif>
            <i class="metismenu-icon bi bi-house-door"></i>
            {{ __('Home') }}
        </a>
    </li>
    <li class="app-sidebar__heading">Content Management</li>
    <li>
        <a href="{{ route('lands.index') }}" @if(Route::is('land*') )class="mm-active"@endif>
            <i class="metismenu-icon bi bi-columns-gap"></i>
            {{ __('Lahan') }}
        </a>
    </li>
    <li class="app-sidebar__heading">User Management</li>
    <li>
        <a href="{{ route('users.index') }}" @if(Route::is('user*') )class="mm-active"@endif>
            <i class="metismenu-icon bi bi-people"></i>
            {{ __('Users') }}
        </a>
    </li>
</ul>
