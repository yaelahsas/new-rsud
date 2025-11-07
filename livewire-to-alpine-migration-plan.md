# Rencana Migrasi dari Livewire ke AlpineJS

## Overview
Dokumen ini merinci rencana lengkap untuk menghapus Livewire dan menggantinya dengan AlpineJS di admin panel RSUD.

## Analisis Saat Ini

### Komponen Livewire yang Ada
1. `app/Livewire/Admin/Berita/Index.php` - Management berita
2. `app/Livewire/Admin/Carousel/Index.php` - Management carousel
3. `app/Livewire/Admin/Dashboard/Index.php` - Dashboard overview
4. `app/Livewire/Admin/Dokter/Index.php` - Management dokter
5. `app/Livewire/Admin/JadwalPoli/Index.php` - Management jadwal poli
6. `app/Livewire/Admin/Kategori/Index.php` - Management kategori
7. `app/Livewire/Admin/Poli/Index.php` - Management poli
8. `app/Livewire/Admin/User/Index.php` - Management user

### View Livewire yang Ada
1. `resources/views/livewire/admin/berita/index.blade.php`
2. `resources/views/livewire/admin/carousel/index.blade.php`
3. `resources/views/livewire/admin/dashboard/index.blade.php`
4. `resources/views/livewire/admin/dokter/index.blade.php`
5. `resources/views/livewire/admin/jadwal-poli/index.blade.php`
6. `resources/views/livewire/admin/kategori/index.blade.php`
7. `resources/views/livewire/admin/poli/index.blade.php`
8. `resources/views/livewire/admin/user/index.blade.php`
9. `resources/views/livewire/admin/user/create.blade.php`

### AlpineJS Managers yang Sudah Ada
1. `resources/js/alpine/berita-manager.js` ✓
2. `resources/js/alpine/carousel-manager.js` ✓
3. `resources/js/alpine/dokter-manager.js` ✓
4. `resources/js/alpine/jadwal-poli-manager.js` ✓
5. `resources/js/alpine/kategori-manager.js` ✓
6. `resources/js/alpine/poli-manager.js` ✓
7. `resources/js/alpine/user-manager.js` ✓

### AlpineJS Views yang Sudah Ada
1. `resources/views/admin/berita/alpine-index.blade.php` ✓
2. `resources/views/admin/carousel/alpine-index.blade.php` ✓
3. `resources/views/admin/dokter/alpine-index.blade.php` ✓
4. `resources/views/admin/jadwal-poli/alpine-index.blade.php` ✓
5. `resources/views/admin/kategori/alpine-index.blade.php` ✓
6. `resources/views/admin/poli/alpine-index.blade.php` ✓
7. `resources/views/admin/user/alpine-index.blade.php` ✓

### API Controllers yang Sudah Ada
1. `app/Http/Controllers/API/BeritaController.php` ✓
2. `app/Http/Controllers/API/CarouselController.php` ✓
3. `app/Http/Controllers/API/DokterController.php` ✓
4. `app/Http/Controllers/API/JadwalPoliController.php` ✓
5. `app/Http/Controllers/API/KategoriController.php` ✓
6. `app/Http/Controllers/API/PoliController.php` ✓
7. `app/Http/Controllers/API/UserController.php` ✓

## Tugas yang Perlu Dilakukan

### 1. Membuat API Controller untuk Dashboard
- Buat `app/Http/Controllers/API/DashboardController.php`
- Endpoint yang diperlukan:
  - `GET /admin/api/dashboard/stats` - Statistik umum
  - `GET /admin/api/dashboard/recent-berita` - Berita terbaru
  - `GET /admin/api/dashboard/recent-users` - User terbaru
  - `GET /admin/api/dashboard/monthly-data` - Data bulanan untuk chart

### 2. Membuat AlpineJS Manager untuk Dashboard
- Buat `resources/js/alpine/dashboard-manager.js`
- Fungsi yang diperlukan:
  - Mengambil data statistik
  - Mengambil data berita terbaru
  - Mengambil data user terbaru
  - Mengambil data chart bulanan
  - Refresh data otomatis (opsional)

### 3. Membuat View Dashboard dengan AlpineJS
- Buat `resources/views/admin/dashboard/alpine-index.blade.php`
- Konversi dari Livewire ke AlpineJS
- Pertahankan styling dan functionality yang ada

### 4. Memperbarui Routes
- Hapus route Livewire: `Route::get('/carousel', \App\Livewire\Admin\Carousel\Index::class)`
- Tambahkan route AlpineJS: `Route::get('/carousel', function () { return view('admin.carousel.alpine-index'); })`
- Tambahkan route dashboard API:
  - `Route::get('/api/dashboard/stats', [\App\Http\Controllers\API\DashboardController::class, 'stats'])`
  - `Route::get('/api/dashboard/recent-berita', [\App\Http\Controllers\API\DashboardController::class, 'recentBerita'])`
  - `Route::get('/api/dashboard/recent-users', [\App\Http\Controllers\API\DashboardController::class, 'recentUsers'])`
  - `Route::get('/api/dashboard/monthly-data', [\App\Http\Controllers\API\DashboardController::class, 'monthlyData'])`

### 5. Memperbarui Dashboard View
- Ubah `resources/views/admin/dashboard/index.blade.php` untuk menggunakan AlpineJS
- Hapus referensi `<livewire:admin.dashboard.index />`

### 6. Menghapus File Livewire
- Hapus semua file di `app/Livewire/`
- Hapus semua file di `resources/views/livewire/`

### 7. Membersihkan Dependensi
- Hapus `livewire/livewire` dari `composer.json`
- Jalankan `composer remove livewire/livewire`
- Hapus konfigurasi Livewire jika ada

### 8. Memperbarui App.js
- Pastikan semua AlpineJS managers di-import dengan benar
- Tambahkan import untuk dashboard-manager.js

## Implementasi Dashboard Controller

### Struktur DashboardController.php
```php
<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Dokter;
use App\Models\Poli;
use App\Models\User;
use App\Models\Carousel;
use App\Models\Jadwal_poli;

class DashboardController extends Controller
{
    public function stats()
    {
        // Mengembalikan statistik umum
        $stats = [
            'total_berita' => Berita::count(),
            'berita_publish' => Berita::where('publish', true)->count(),
            'berita_draft' => Berita::where('publish', false)->count(),
            'total_dokter' => Dokter::count(),
            'dokter_aktif' => Dokter::where('status', 'aktif')->count(),
            'total_poli' => Poli::count(),
            'poli_aktif' => Poli::where('status', 'aktif')->count(),
            'total_user' => User::count(),
            'admin_users' => User::where('role', 'admin')->count(),
            'editor_users' => User::where('role', 'editor')->count(),
            'total_carousel' => Carousel::count(),
            'carousel_aktif' => Carousel::where('aktif', true)->count(),
            'total_jadwal' => Jadwal_poli::count(),
            'jadwal_hari_ini' => Jadwal_poli::where('hari', now()->format('l'))->count(),
        ];
        
        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }
    
    public function recentBerita()
    {
        // Mengembalikan 5 berita terbaru
        $recent_berita = Berita::with('kategori', 'author')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        return response()->json([
            'success' => true,
            'data' => $recent_berita
        ]);
    }
    
    public function recentUsers()
    {
        // Mengembalikan 5 user terbaru
        $recent_users = User::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        return response()->json([
            'success' => true,
            'data' => $recent_users
        ]);
    }
    
    public function monthlyData()
    {
        // Mengembalikan data berita per bulan
        $berita_per_month = Berita::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();
        
        // Fill missing months with 0
        $monthly_data = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthly_data[] = $berita_per_month[$i] ?? 0;
        }
        
        return response()->json([
            'success' => true,
            'data' => $monthly_data
        ]);
    }
}
```

## Implementasi Dashboard Manager

### Struktur dashboard-manager.js
```javascript
document.addEventListener('alpine:init', () => {
    // Helper function to safely get CSRF token
    function getCsrfToken() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : '';
    }

    Alpine.data('dashboardManager', () => ({
        stats: {},
        recentBerita: [],
        recentUsers: [],
        monthlyData: [],
        loading: false,
        
        init() {
            this.loadStats();
            this.loadRecentBerita();
            this.loadRecentUsers();
            this.loadMonthlyData();
        },
        
        async loadStats() {
            this.loading = true;
            try {
                const response = await fetch('/admin/api/dashboard/stats');
                const data = await response.json();
                
                if (data.success) {
                    this.stats = data.data;
                }
            } catch (error) {
                console.error('Error loading stats:', error);
            } finally {
                this.loading = false;
            }
        },
        
        async loadRecentBerita() {
            try {
                const response = await fetch('/admin/api/dashboard/recent-berita');
                const data = await response.json();
                
                if (data.success) {
                    this.recentBerita = data.data;
                }
            } catch (error) {
                console.error('Error loading recent berita:', error);
            }
        },
        
        async loadRecentUsers() {
            try {
                const response = await fetch('/admin/api/dashboard/recent-users');
                const data = await response.json();
                
                if (data.success) {
                    this.recentUsers = data.data;
                }
            } catch (error) {
                console.error('Error loading recent users:', error);
            }
        },
        
        async loadMonthlyData() {
            try {
                const response = await fetch('/admin/api/dashboard/monthly-data');
                const data = await response.json();
                
                if (data.success) {
                    this.monthlyData = data.data;
                    // Initialize chart after data is loaded
                    this.$nextTick(() => {
                        this.initCharts();
                    });
                }
            } catch (error) {
                console.error('Error loading monthly data:', error);
            }
        },
        
        initCharts() {
            // Initialize Chart.js charts here
            // This would be similar to the existing chart initialization in Livewire
        },
        
        refreshAll() {
            this.loadStats();
            this.loadRecentBerita();
            this.loadRecentUsers();
            this.loadMonthlyData();
        }
    }));
});
```

## Langkah Implementasi

1. **Buat API Controller** - Buat DashboardController dengan semua endpoint yang diperlukan
2. **Buat AlpineJS Manager** - Buat dashboard-manager.js dengan fungsi untuk mengambil data
3. **Buat View Dashboard** - Konversi view Livewire ke AlpineJS
4. **Update Routes** - Tambahkan route API dan update route yang ada
5. **Update App.js** - Tambahkan import untuk dashboard-manager.js
6. **Test Dashboard** - Pastikan semua fungsi berjalan dengan baik
7. **Hapus Livewire** - Hapus semua file Livewire yang tidak lagi digunakan
8. **Clean Dependencies** - Hapus dependensi Livewire dari composer.json
9. **Final Testing** - Test semua modul untuk memastikan tidak ada yang rusak

## Catatan Penting

1. **Backup** - Pastikan untuk membuat backup sebelum menghapus file Livewire
2. **Testing** - Test setiap modul secara individual setelah konversi
3. **API Compatibility** - Pastikan API endpoints mengembalikan data dalam format yang sama dengan Livewire
4. **Error Handling** - Implementasikan error handling yang baik di AlpineJS managers
5. **Loading States** - Tambahkan loading indicators untuk pengalaman user yang lebih baik

## Checklist Final

- [ ] DashboardController.php dibuat
- [ ] dashboard-manager.js dibuat
- [ ] alpine-index.blade.php untuk dashboard dibuat
- [ ] Routes diperbarui
- [ ] app.js diperbarui
- [ ] Dashboard berfungsi dengan baik
- [ ] File Livewire dihapus
- [ ] View Livewire dihapus
- [ ] Dependensi Livewire dihapus
- [ ] Semua modul AlpineJS berfungsi
- [ ] Dokumentasi dibuat