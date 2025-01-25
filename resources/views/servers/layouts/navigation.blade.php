<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="" class="brand-link">
        <img src="{{ asset('img/icon.svg') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </a>
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                @if (empty(Auth::user()->profile_photo_path))
                    <img src="{{ asset('img/no_photo.svg') }}" class="img-circle elevation-2" alt="User Image">
                @else
                    <img src="{{ asset('storage/photo_user/' . Auth::user()->profile_photo_path) }}"
                        class="img-circle elevation-2" alt="User Image">
                @endif
            </div>
            <div class="info">
                <a href="{{ route('profile.index') }}" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>
        <nav class="mt-2">
            @php
                $PermissionDashboard = App\Models\PermissionRole::getPermission('Dashboard', Auth::user()->role_id);
                $PermissionUser = App\Models\PermissionRole::getPermission('User', Auth::user()->role_id);
                $PermissionRole = App\Models\PermissionRole::getPermission('Role', Auth::user()->role_id);
                $PermissionCategory = App\Models\PermissionRole::getPermission('Category', Auth::user()->role_id);
            @endphp
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                @if (!empty($PermissionDashboard))
                    <li class="nav-header">General</li>
                @endif

                @if (!empty($PermissionDashboard))
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}"
                            class="nav-link @if (Request::segment(2) == 'dashboard') active @endif">
                            <i class="nav-icon fas fa-home"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>
                @endif

                <li class="nav-item">
                    <a href="{{ route('transaction.index') }}"
                        class="nav-link @if (Request::segment(1) == 'transactions') active @endif">
                        <i class="fas fa-money-bill nav-icon"></i>
                        <p>Transactions</p>
                    </a>
                </li>

                @if (!empty($PermissionUser) || !empty($PermissionRole) || !empty($PermissionCategory))
                    <li class="nav-header">Management</li>
                @endif

                @if (!empty($PermissionCategory))
                    <li class="nav-item">
                        <a href="{{ route('category.index') }}"
                            class="nav-link @if (Request::segment(1) == 'category') active @endif">
                            <i class="fas fa-list nav-icon"></i>
                            <p>Category</p>
                        </a>
                    </li>
                @endif

                @if (!empty($PermissionUser))
                    <li class="nav-item">
                        <a href="{{ route('user.index') }}"
                            class="nav-link @if (Request::segment(1) == 'user') active @endif">
                            <i class="fas fa-users nav-icon"></i>
                            <p>User</p>
                        </a>
                    </li>
                @endif

                @if (!empty($PermissionRole))
                    <li class="nav-item">
                        <a href="{{ route('role.index') }}"
                            class="nav-link @if (Request::segment(1) == 'role') active @endif">
                            <i class="fas fa-users-cog nav-icon"></i>
                            <p>Role</p>
                        </a>
                    </li>
                @endif

                <li class="nav-item mt-4">
                    <a href="{{ route('logout') }}" class="nav-link bg-danger">
                        <i class="nav-icon fas fa-power-off"></i>
                        <p>
                            Logout
                        </p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>
