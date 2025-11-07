    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link btn-modern" data-widget="pushmenu" href="#" role="button">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    <i class="fas fa-home"></i> Dashboard
                </a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Search Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="fas fa-search"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="min-width: 300px;">
                    <div class="p-2">
                        <div class="input-group">
                            <input type="text" class="form-control form-control-modern" placeholder="Cari...">
                            <div class="input-group-append">
                                <button class="btn btn-primary-modern" type="button">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            
            <!-- Notifications Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                    <span class="badge badge-warning navbar-badge">3</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-item dropdown-header">3 Notifikasi</span>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-envelope mr-2"></i> 4 pesan baru
                        <span class="float-right text-muted text-sm">3 menit</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-users mr-2"></i> 8 user baru
                        <span class="float-right text-muted text-sm">12 jam</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-file mr-2"></i> 3 laporan baru
                        <span class="float-right text-muted text-sm">2 hari</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">Lihat Semua Notifikasi</a>
                </div>
            </li>
            
            <!-- User Menu -->
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                    <img src="https://ui-avatars.com/api/?name=Admin&background=6366f1&color=fff&size=40"
                         class="user-image img-circle elevation-2" alt="User Image">
                    <span class="d-none d-md-inline">{{ auth()->user()->name ?? 'Admin' }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <!-- User image -->
                    <li class="user-header text-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                        <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name ?? 'Admin' }}&background=fff&color=6366f1&size=80"
                             class="img-circle elevation-2" alt="User Image">
                        <p class="mt-2">
                            {{ auth()->user()->name ?? 'Admin' }}
                            <small>{{ auth()->user()->email ?? 'admin@rsud.com' }}</small>
                            <br>
                            <span class="badge badge-light">{{ ucfirst(auth()->user()->role ?? 'admin') }}</span>
                        </p>
                    </li>
                    
                    <!-- Menu Body -->
                    <li class="user-body">
                        <div class="row">
                            <div class="col-4 text-center">
                                <a href="#" class="text-decoration-none">
                                    <i class="fas fa-user text-primary"></i>
                                    <p class="mb-0">Profile</p>
                                </a>
                            </div>
                            <div class="col-4 text-center">
                                <a href="#" class="text-decoration-none">
                                    <i class="fas fa-cog text-info"></i>
                                    <p class="mb-0">Pengaturan</p>
                                </a>
                            </div>
                            <div class="col-4 text-center">
                                <a href="#" class="text-decoration-none">
                                    <i class="fas fa-question-circle text-success"></i>
                                    <p class="mb-0">Bantuan</p>
                                </a>
                            </div>
                        </div>
                    </li>

                    <!-- Menu Footer-->
                    <li class="user-footer">
                        <a href="#" class="btn btn-default btn-flat btn-modern">
                            <i class="fas fa-user"></i> Profile
                        </a>
                        <a href="{{ route('logout') }}" class="btn btn-default btn-flat float-right btn-danger-modern"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
            
            <!-- Fullscreen -->
            <li class="nav-item">
                <a class="nav-link btn-modern" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
        </ul>
    </nav>
