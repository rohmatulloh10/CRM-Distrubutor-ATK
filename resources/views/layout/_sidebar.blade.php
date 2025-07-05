<!-- resources/views/layouts/sidebar.blade.php -->
<aside class="main-sidebar sidebar-mini sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    {{-- <a href="{{ route('dashboard') }}" class="brand-link text-center">
        <span class="brand-text font-weight-bold text-white" style="display: block;">CRM Distributor</span>
    </a> --}}

    <a href="{{ route('dashboard') }}" class="brand-link text-center">
    <img src="{{ asset('AdminLTE/logo.png') }}" alt="CRM Logo"
        class="brand-image img-circle elevation-2"
        style="opacity: .9; width: 35px; height: 35px; object-fit: cover;">
    <span class="brand-text font-weight-bold text-white">CRM Distributor</span>
</a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel -->
        <!-- Sidebar user panel -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex justify-content-center align-items-center flex-column text-center">
            <div class="info">
                <a href="#" class="d-block font-weight-bold text-white">{{ auth()->user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        @php
            $currentRoute = Route::currentRouteName();
        @endphp

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">

                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link {{ $currentRoute === 'dashboard' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                {{-- {{ auth()->user()->role }} --}}
                @if (auth()->user()->role === 'admin')
                    <li class="nav-item">
                        <a href="{{ route('users.index') }}"
                            class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users-cog"></i>
                            <p>Manajemen Pengguna</p>
                        </a>
                    </li>
                @endif

                <li class="nav-item">
                    <a href="{{ route('stores.index') }}"
                        class="nav-link {{ str_starts_with($currentRoute, 'stores.') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-store"></i>
                        <p>Manajemen Toko</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('leads.index') }}"
                        class="nav-link {{ str_starts_with($currentRoute, 'leads.') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Prospek</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('activities.index') }}"
                        class="nav-link {{ str_starts_with($currentRoute, 'activities.') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tasks"></i>
                        <p>Aktivitas</p>
                    </a>
                </li>

                {{-- <li class="nav-item">
                    <a href="{{ route('log.index') }}"
                        class="nav-link {{ str_starts_with($currentRoute, 'log.') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-history"></i>
                        <p>Log Aktifitas</p>
                    </a>
                </li> --}}

                {{-- <li class="nav-item">
                    <a href="{{ route('access.index') }}"
                        class="nav-link {{ str_starts_with($currentRoute, 'access.') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-shield-alt"></i>
                        <p>Akses</p>
                    </a>
                </li> --}}
                @if (auth()->user()->role === 'admin')
                    <li
                        class="nav-item has-treeview {{ str_starts_with($currentRoute, 'laporan.') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ str_starts_with($currentRoute, 'laporan.') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-chart-line"></i>
                            <p>
                                Laporan
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview ml-2">
                            <li class="nav-item">
                                <a href="{{ route('laporan.toko') }}"
                                    class="nav-link {{ $currentRoute === 'laporan.toko' ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Laporan Toko</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('laporan.prospek') }}"
                                    class="nav-link {{ $currentRoute === 'laporan.prospek' ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Laporan Prospek</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('laporan.aktifitas') }}"
                                    class="nav-link {{ $currentRoute === 'laporan.aktifitas' ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Laporan Aktivitas</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                <li class="nav-item">
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
