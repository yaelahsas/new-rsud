<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel - RSUD Genteng')</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- AdminLTE Theme style -->
    <link rel="stylesheet" href="{{ asset('css/admin/adminlte.min.css') }}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        <x-admin.navbar />

        <!-- Main Sidebar Container -->
        <x-admin.sidebar />

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->


            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    {{ $slot }}
                </div>
            </section>
        </div>

        <!-- Footer -->
        <x-admin.footer />

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('js/admin/adminlte.min.js') }}"></script>
    <!-- Chart.js -->
    <script src="{{ asset('plugins/chart.js/Chart.bundle.min.js') }}"></script>
    <!-- Toastr -->
    <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>


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

        // ✍️ Inisialisasi Summernote editor (sinkron ke Livewire)
        function initSummernote() {
            setTimeout(() => {
                const $editor = $('#summernote');

                if ($editor.length && !$editor.data('summernote')) {
                    $editor.summernote({
                        height: 250,
                        placeholder: 'Tulis artikel di sini...',
                        callbacks: {
                            onChange: function(contents) {
                                // Sinkronkan isi editor ke Livewire property "content"
                                const livewireComponent = document.querySelector('[wire\\:id]');
                                if (livewireComponent) {
                                    Livewire.find(livewireComponent.getAttribute('wire:id'))
                                        .set('content', contents);
                                }
                            }
                        }
                    });

                    console.log('✅ Summernote ready');
                }
            }, 200);
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

        // 🚀 Jalankan AdminLTE & Summernote saat pertama kali load
        document.addEventListener('livewire:load', () => {
            initAdminLTE();
            initSummernote();
        });

        // 🔁 Jalankan ulang setelah Livewire navigasi (SPA)
        document.addEventListener('livewire:navigated', () => {
            setTimeout(() => {
                initAdminLTE();
                initSummernote();
            }, 100);
        });

        // 🔄 Jalankan ulang juga setelah komponen Livewire update
        document.addEventListener('livewire:update', () => {
            setTimeout(() => {
                initAdminLTE();
                initSummernote();
            }, 100);
        });
    </script>

    @stack('scripts')
</body>

</html>
