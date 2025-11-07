   <!-- Main Sidebar Container -->
   <aside class="main-sidebar sidebar-dark-primary elevation-4">
       <!-- Brand Logo -->
       <a href="{{ route('admin.dashboard') }}" class="brand-link">
           <img src="https://ui-avatars.com/api/?name=RSUD&background=fff&color=6366f1&size=40"
                alt="RSUD Logo" class="brand-image img-circle elevation-3" style="opacity: 1;">
           <span class="brand-text font-weight-bold">RSUD Admin</span>
       </a>

       <!-- Sidebar -->
       <div class="sidebar">
           <!-- Sidebar user panel (optional) -->
           <div class="user-panel mt-3 pb-3 mb-3 d-flex">
               <div class="image">
                   <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name ?? 'Admin' }}&background=fff&color=6366f1&size=40"
                        class="img-circle elevation-2" alt="User Image">
               </div>
               <div class="info">
                   <a href="#" class="d-block text-white">{{ auth()->user()->name ?? 'Admin' }}</a>
                   <small class="text-muted">{{ ucfirst(auth()->user()->role ?? 'admin') }}</small>
               </div>
           </div>

           <!-- Sidebar Menu -->
           <nav class="mt-2">
               <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                   data-accordion="false">
                   <!-- Dashboard -->
                   <li class="nav-item">
                       <a wire:navigate href="{{ route('admin.dashboard') }}"
                           class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                           <i class="nav-icon fas fa-tachometer-alt"></i>
                           <p>
                               Dashboard
                               <span class="right badge badge-info">Home</span>
                           </p>
                       </a>
                   </li>

                   <li class="nav-header text-uppercase text-muted" style="font-size: 0.75rem; letter-spacing: 0.05em;">
                       <i class="fas fa-layer-group mr-1"></i> Manajemen Konten
                   </li>
                   <li class="nav-item">
                       <a wire:navigate href="{{ route('admin.berita') }}"
                           class="nav-link {{ request()->is('admin/berita') ? 'active' : '' }}">
                           <i class="nav-icon fas fa-newspaper"></i>
                           <p>
                               Berita
                               <span class="right badge badge-warning">New</span>
                           </p>
                       </a>
                   </li>
                   <li class="nav-item">
                       <a wire:navigate href="{{ route('admin.kategori') }}"
                           class="nav-link {{ request()->is('admin/kategori') ? 'active' : '' }}">
                           <i class="nav-icon fas fa-folder-tree"></i>
                           <p>
                               Kategori Berita
                           </p>
                       </a>
                   </li>
                   <li class="nav-item">
                       <a wire:navigate href="{{ route('admin.carousel') }}"
                           class="nav-link {{ request()->is('admin/carousel') ? 'active' : '' }}">
                           <i class="nav-icon fas fa-images"></i>
                           <p>
                               Carousel
                           </p>
                       </a>
                   </li>

                   <li class="nav-header text-uppercase text-muted" style="font-size: 0.75rem; letter-spacing: 0.05em;">
                       <i class="fas fa-hospital mr-1"></i> Manajemen Medis
                   </li>
                   <li class="nav-item">
                       <a wire:navigate href="{{ route('admin.poli') }}"
                           class="nav-link {{ request()->is('admin/poli') ? 'active' : '' }}">
                           <i class="nav-icon fas fa-hospital"></i>
                           <p>
                               Poliklinik
                           </p>
                       </a>
                   </li>
                   <li class="nav-item">
                       <a wire:navigate href="{{ route('admin.dokter') }}"
                           class="nav-link {{ request()->is('admin/dokter') ? 'active' : '' }}">
                           <i class="nav-icon fas fa-user-md"></i>
                           <p>
                               Dokter
                           </p>
                       </a>
                   </li>
                   <li class="nav-item">
                       <a wire:navigate href="{{ route('admin.jadwal-poli') }}"
                           class="nav-link {{ request()->is('admin/jadwal-poli') ? 'active' : '' }}">
                           <i class="nav-icon fas fa-calendar-check"></i>
                           <p>
                               Jadwal Poli
                               <span class="right badge badge-success">Active</span>
                           </p>
                       </a>
                   </li>

                   <li class="nav-header text-uppercase text-muted" style="font-size: 0.75rem; letter-spacing: 0.05em;">
                       <i class="fas fa-users-cog mr-1"></i> Manajemen User
                   </li>
                   <li class="nav-item">
                       <a wire:navigate href="{{ route('admin.users') }}"
                           class="nav-link {{ request()->is('admin/users') ? 'active' : '' }}">
                           <i class="nav-icon fas fa-users"></i>
                           <p>
                               User Management
                           </p>
                       </a>
                   </li>

                   <!-- Additional Menu Items -->
                   <li class="nav-header text-uppercase text-muted" style="font-size: 0.75rem; letter-spacing: 0.05em;">
                       <i class="fas fa-cog mr-1"></i> Pengaturan
                   </li>
                   <li class="nav-item">
                       <a href="#" class="nav-link">
                           <i class="nav-icon fas fa-cog"></i>
                           <p>
                               Pengaturan Sistem
                           </p>
                       </a>
                   </li>
                   <li class="nav-item">
                       <a href="#" class="nav-link">
                           <i class="nav-icon fas fa-chart-line"></i>
                           <p>
                               Laporan
                           </p>
                       </a>
                   </li>
                   <li class="nav-item">
                       <a href="{{ route('home') }}" target="_blank" class="nav-link">
                           <i class="nav-icon fas fa-external-link-alt"></i>
                           <p>
                               Lihat Website
                               <i class="fas fa-arrow-right right text-xs"></i>
                           </p>
                       </a>
                   </li>
               </ul>
           </nav>
           <!-- /.sidebar-menu -->
       </div>
       <!-- /.sidebar -->
   </aside>
