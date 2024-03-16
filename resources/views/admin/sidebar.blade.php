<div class="sidebar-menu">
    <ul class="menu">
        <li class="sidebar-title">Menu</li>

        <li class="sidebar-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <a href="{{ route('admin.dashboard') }}" class='sidebar-link'>
                <i class="bi bi-grid-fill"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="sidebar-item {{ request()->routeIs('admin.absence.*') ? 'active' : '' }}">
            <a href="{{ route('admin.absence.index') }}" class='sidebar-link'>
                <i class="bi bi-collection-fill"></i>
                <span>Absensi</span>
            </a>
        </li>

        <li class="sidebar-item {{ request()->routeIs('admin.employee.*') ? 'active' : '' }}">
            <a href="{{ route('admin.employee.index') }}" class='sidebar-link'>
                <i class="bi bi-collection-fill"></i>
                <span>Karyawan</span>
            </a>
        </li>

        <li class="sidebar-item {{ request()->routeIs('admin.division.*') ? 'active' : '' }}">
            <a href="{{ route('admin.division.index') }}" class='sidebar-link'>
                <i class="bi bi-collection-fill"></i>
                <span>Divisi</span>
            </a>
        </li>

        <li class="sidebar-item {{ request()->routeIs('admin.user.*') ? 'active' : '' }}">
            <a href="{{ route('admin.user.index') }}" class='sidebar-link'>
                <i class="bi bi-collection-fill"></i>
                <span>Pengguna</span>
            </a>
        </li>

    </ul>
</div>
