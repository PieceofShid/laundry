<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
    </a>

    @php
        $menus = App\Models\Access::where('user_id', auth()->id())->get();
    @endphp
    
    @foreach ($menus as $menu)
        @if ($menu->hak_akses == 'daftar_laundry')
            <li class="nav-item @if(Route::is('laundry.index')) active @endif">
                <a class="nav-link" href="{{ route('laundry.index')}}">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Daftar Laundry</span></a>
            </li>
        @endif
        @if ($menu->hak_akses == 'input_masuk')
            <li class="nav-item  @if(Route::is('laundry.create')) active @endif">
                <a class="nav-link" href="{{ route('laundry.create')}}">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Input Masuk</span></a>
            </li>
        @endif
        @if ($menu->hak_akses == 'input_keluar')
            <li class="nav-item  @if(Route::is('laundry.edit')) active @endif">
                <a class="nav-link" href="{{ route('laundry.edit')}}">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Input Keluar</span></a>
            </li>
        @endif
        @if ($menu->hak_akses == 'daftar_user')
            <li class="nav-item  @if(Route::is('user.index')) active @endif">
                <a class="nav-link" href="{{ route('user.index')}}">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Daftar User</span></a>
            </li>
        @endif
    @endforeach
    
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
    
    </ul>