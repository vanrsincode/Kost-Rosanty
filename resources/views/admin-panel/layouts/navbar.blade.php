<div class="navbar-bg" style="position: fixed;">
    <div class="header">
        <div class="inner-header"></div>
    </div>
</div>
<nav class="navbar navbar-expand-lg main-navbar" id="navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li>
                <a href="#" data-toggle="sidebar" class="nav-link nav-link-lg" aria-label="NavBars" id="navLink1">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
        </ul>
    </form>
    <ul class="navbar-nav navbar-right">
        <li class="dropdown">
            <a aria-label="vanrsin" href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user d-flex justify-content-between align-items-center" id="navLink2">
                <i class="fas fa-user-circle rounded-circle mr-1" style="font-size: 20px;"></i>
                <div class="d-sm-none d-lg-inline-block ml-1" id="navUsers">Hi, {{ auth()->user()->name }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                @if (auth()->check() && (auth()->user()->role === 1 || auth()->user()->role === 3))
                    <a href="{{ url('profile') }}" class="dropdown-item has-icon d-flex align-items-center">
                        <i class="far fa-user"></i> Profile
                    </a>
                @else
                    <a href="{{ url('user/profile') }}" class="dropdown-item has-icon d-flex align-items-center">
                        <i class="far fa-user"></i> Profile
                    </a>
                @endif

                <a href="#" class="dropdown-item has-icon text-danger d-flex align-items-center"
                    data-toggle="modal" data-target="#modalLogout">
                    <i class="fas fa-power-off mr-2"></i> Logout
                </a>
            </div>
        </li>
    </ul>
</nav>
