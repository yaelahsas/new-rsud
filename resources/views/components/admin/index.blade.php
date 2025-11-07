<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-modern.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <x-admin.navbar></x-admin.navbar>
        <!-- Sidebar -->
        <x-admin.sidebar></x-admin.sidebar>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>{{ $judul }}</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">{{ $title }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                {{ $headerActions ?? '' }}
                            </div>
                            <div>
                                {{ $headerRight ?? '' }}
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        {{ $slot }}
                    </div>
                </div>
            </section>
        </div>

        <x-admin.footer></x-admin.footer>
    </div>

    <script src="{{ asset('plugins/jquery/jquery.min.js') }}" data-navigate-once></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}" data-navigate-once></script>
    <script src="{{ asset('js/admin/adminlte.min.js') }}" data-navigate-once></script>
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.all.js') }}" data-navigate-once></script>
    <script>
        // Make SweetAlert2 available globally
        window.Swal = Swal;
    </script>
    <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}" data-navigate-once></script>
<script data-navigate-once>
    /**
     * ============================================================
     * FIX UNTUK ADMINLTE 3 + LIVEWIRE 3 + SUMMERNOTE
     * ============================================================
     */

    // 🔧 Inisialisasi ulang fitur AdminLTE setelah navigasi Livewire
    function initAdminLTE() {
        try {
            // Re-init Sidebar & Treeview
            $('[data-widget="pushmenu"]').PushMenu();
            $('[data-widget="treeview"]').Treeview('init');
          

            // Bersihkan backdrop modal yang tertinggal
            $('.modal-backdrop').remove();
            $('body').removeClass('modal-open').css('padding-right', '');

            console.log('✅ AdminLTE 3 reinitialized after Livewire navigation');
        } catch (err) {
            console.warn('⚠️ AdminLTE reinit error:', err);
        }
    }

    // 🧹 Bersihkan editor & modal saat pindah halaman SPA
    document.addEventListener('livewire:navigating', () => {
        // Hapus Summernote instance jika ada
        if ($('#summernote').data('summernote')) {
            $('#summernote').summernote('destroy');
        }

        // Hapus backdrop modal & reset body
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open').css('padding-right', '');
    });

    // 🚀 Jalankan AdminLTE saat pertama kali load
    document.addEventListener('livewire:load', () => {
        initAdminLTE();
    });

    // 🔁 Jalankan ulang setelah Livewire navigasi (SPA)
    document.addEventListener('livewire:navigated', () => {
        setTimeout(() => {
            initAdminLTE();
        }, 100);
    });

    // 🔄 Jalankan ulang juga setelah komponen Livewire update
    document.addEventListener('livewire:update', () => {
        setTimeout(() => {
            initAdminLTE();
        }, 100);
    });
</script>


</body>

</html>
