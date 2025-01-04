<div class="main-sidebar sidebar-style-2 irounded-1 shadow" tabindex="0">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ url('/') }}">Kos Rosanty</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ url('/') }}">KR</a>
        </div>
        <ul class="sidebar-menu">

            <li class="menu-header">Home</li>
            <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a aria-label="skost" class="nav-link" href="{{ route('dashboard') }}"><i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            @if (auth()->user()->role == 1)
                <li class="menu-header">Pages</li>
                {{-- Kelola Data --}}
                <li class="nav-item dropdown {{ request()->routeIs('fasilitas.index', 'kamar.index') ? 'active' : '' }}">
                    <a aria-label="skost" href="#" class="nav-link has-dropdown"><i class="fas fa-server"></i><span>Kelola
                            Data</span></a>
                    <ul class="dropdown-menu">
                        <li class="{{ request()->routeIs('fasilitas.index') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('fasilitas.index') }}">Fasilitas</a>
                        </li>
                        <li class="{{ request()->routeIs('kamar.index') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('kamar.index') }}">Kamar</a>
                        </li>
                    </ul>
                </li>

                {{-- Penyewaan --}}
                <li class="nav-item dropdown {{ request()->routeIs('penghuni.index', 'penyewa-kamar.index') ? 'active' : '' }}">
                    <a aria-label="skost" href="#" class="nav-link has-dropdown"><i class="fas fa-hotel"></i><span>Penyewaan Kos</span></a>
                    <ul class="dropdown-menu">
                        <li class="{{ request()->routeIs('penyewa-kamar.index') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('penyewa-kamar.index') }}">Penyewa Kamar</a>
                        </li>
                        <li class="{{ request()->routeIs('penghuni.index') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('penghuni.index') }}">Penghuni</a>
                        </li>
                    </ul>
                </li>

                {{-- Transaksi --}}
                <li class="nav-item dropdown {{ request()->routeIs('tagihan.index', 'pembayaran.index') ? 'active' : '' }}">
                    <a aria-label="skost" href="#" class="nav-link has-dropdown"><i
                            class="fas fa-dollar-sign"></i><span>Transaksi</span></a>
                    <ul class="dropdown-menu">
                        <li class="{{ request()->routeIs('tagihan.index') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('tagihan.index') }}">Tagihan</a>
                        </li>
                        <li class="{{ request()->routeIs('pembayaran.index') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('pembayaran.index') }}">Pembayaran</a>
                        </li>
                    </ul>
                </li>

                {{-- Feedback --}}
                {{-- <li class="{{ request()->routeIs('feedback.index') ? 'active' : '' }}">
                    <a aria-label="skost" class="nav-link" href="{{ route('feedback.index') }}"><i class="fas fa-share"></i>
                        <span>Feedback</span>
                    </a>
                </li> --}}

                {{-- Report --}}
                <li class="menu-header">Report</li>
                <li class="{{ request()->routeIs('laporan.index') ? 'active' : '' }}">
                    <a aria-label="skost" class="nav-link" href="{{ route('laporan.index') }}"><i class="fas fa-file"></i>
                        <span>Laporan</span>
                    </a>
                </li>

                {{-- Hak Akses --}}
                <li class="menu-header">Settings</li>
                <li class="{{ request()->routeIs('hak-akses.index') ? 'active' : '' }}">
                    <a aria-label="skost" class="nav-link" href="{{ route('hak-akses.index') }}"><i class="fas fa-users-cog"></i>
                        <span>Hak Akses</span>
                    </a>
                </li>
            @elseif(auth()->user()->role == 2) 
                <li class="menu-header">Page</li>
                <li class="{{ request()->routeIs('riwayat.index') ? 'active' : '' }}">
                    <a aria-label="skost" class="nav-link" href="{{ route('riwayat.index') }}"><i class="fas fa-history"></i>
                        <span>Riwayat</span>
                    </a>
                </li>
                {{-- <li class="{{ request()->routeIs('feedback.penghuni.index') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('feedback.penghuni.index') }}"><i class="fas fa-share"></i>
                        <span>Feedback</span>
                    </a>
                </li> --}}
            @elseif(auth()->user()->role == 3)
                <li class="menu-header">Pages</li>
                <li class="{{ request()->routeIs('penghuni.index') ? 'active' : '' }}">
                    <a aria-label="skost" class="nav-link" href="{{ route('penghuni.index') }}"><i class="fas fa-users"></i>
                        <span>Penghuni</span>
                    </a>
                </li>
                {{-- <li class="{{ request()->routeIs('feedback.index') ? 'active' : '' }}">
                    <a aria-label="skost" class="nav-link" href="{{ route('feedback.index') }}"><i class="fas fa-share"></i>
                        <span>Feedback</span>
                    </a>
                </li> --}}

                {{-- Report --}}
                <li class="menu-header">Report</li>
                <li class="{{ request()->routeIs('laporan.index') ? 'active' : '' }}">
                    <a aria-label="skost" class="nav-link" href="{{ route('laporan.index') }}"><i class="fas fa-file"></i>
                        <span>Laporan</span>
                    </a>
                </li>
            @endif


        </ul>
    </aside>
</div>
