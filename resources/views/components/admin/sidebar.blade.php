   <!-- Main Sidebar Container -->
   <aside class="main-sidebar sidebar-dark-primary elevation-4">
       <!-- Brand Logo -->
       <a href="../../index3.html" class="brand-link">
           <img src="../../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
               style="opacity: .8">
           <span class="brand-text font-weight-light">AdminLTE 3</span>
       </a>

       <!-- Sidebar -->
       <div class="sidebar">


           <!-- Sidebar Menu -->
           <nav class="mt-2">
               <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                   data-accordion="false">
                   <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                   <li class="nav-item">
                       <a href="#" class="nav-link">
                           <i class="nav-icon fas fa-tachometer-alt"></i>
                           <p>
                               Dashboard

                           </p>
                       </a>
                   </li>


                   <li class="nav-header">SUPER ADMIN</li>
                   <li class="nav-item active">
                       <a wire:navigate href="{{ route('admin.users') }}"
                           class="nav-link {{ request()->is('admin/users') ? 'active' : '' }}">
                           <i class="nav-icon fas fa-users"></i>
                           <p>
                               User
                           </p>
                       </a>
                   </li>
                   <li class="nav-item active">
                       <a wire:navigate href="{{ route('admin.berita') }}"
                           class="nav-link {{ request()->is('admin/berita') ? 'active' : '' }}">
                           <i class="nav-icon fas fa-users"></i>
                           <p>
                               Berita
                           </p>
                       </a>
                   </li>
                   <li class="nav-item active">
                       <a wire:navigate href="{{ route('admin.poli') }}"
                           class="nav-link {{ request()->is('admin/poli') ? 'active' : '' }}">
                           <i class="nav-icon fas fa-users"></i>
                           <p>
                               Poliklinik
                           </p>
                       </a>
                   </li>
                   <li class="nav-item active">
                       <a wire:navigate href="{{ route('admin.kategori') }}"
                           class="nav-link {{ request()->is('admin/kategori') ? 'active' : '' }}">
                           <i class="nav-icon fas fa-users"></i>
                           <p>
                               Kategori
                           </p>
                       </a>
                   </li>
                   <li class="nav-item active">
                       <a wire:navigate href="{{ route('admin.dokter') }}"
                           class="nav-link {{ request()->is('admin/dokter') ? 'active' : '' }}">
                           <i class="nav-icon fas fa-users"></i>
                           <p>
                               Dokter
                           </p>
                       </a>
                   </li>
                   <li class="nav-header">EDITOR</li>
                   <li class="nav-item">
                       <a href="#" class="nav-link">
                           <i class="nav-icon fas fa-newspaper"></i>
                           <p>
                               Artikel

                           </p>
                       </a>
                   </li>
           </nav>
           <!-- /.sidebar-menu -->
       </div>
       <!-- /.sidebar -->
   </aside>
