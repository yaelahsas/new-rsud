# Dokumentasi Struktur AlpineJS Admin Panel RSUD

## Overview
Dokumen ini menjelaskan struktur admin panel RSUD yang telah bermigrasi dari Livewire ke AlpineJS.

## Struktur Folder

### API Controllers
Lokasi: `app/Http/Controllers/API/`
- `BeritaController.php` - Mengelola data berita (CRUD)
- `CarouselController.php` - Mengelola data carousel (CRUD)
- `DashboardController.php` - Mengelola data dashboard (statistik, recent data)
- `DokterController.php` - Mengelola data dokter (CRUD)
- `JadwalPoliController.php` - Mengelola data jadwal poli (CRUD)
- `KategoriController.php` - Mengelola data kategori (CRUD)
- `PoliController.php` - Mengelola data poli (CRUD)
- `UserController.php` - Mengelola data user (CRUD)

### AlpineJS Managers
Lokasi: `resources/js/alpine/`
- `berita-manager.js` - Manajemen berita dengan fitur:
  - Pagination
  - Search
  - CRUD operations
  - Real-time polling
  - Summernote integration
- `carousel-manager.js` - Manajemen carousel dengan fitur:
  - Pagination
  - Search
  - CRUD operations
  - Real-time polling
  - Image upload
- `dashboard-manager.js` - Manajemen dashboard dengan fitur:
  - Statistik loading
  - Recent data loading
  - Chart initialization
  - Export functionality
- `dokter-manager.js` - Manajemen dokter dengan fitur:
  - Pagination
  - Search
  - CRUD operations
  - Real-time polling
- `jadwal-poli-manager.js` - Manajemen jadwal poli dengan fitur:
  - Pagination
  - Search
  - CRUD operations
  - Real-time polling
- `kategori-manager.js` - Manajemen kategori dengan fitur:
  - Pagination
  - Search
  - CRUD operations
  - Real-time polling
- `poli-manager.js` - Manajemen poli dengan fitur:
  - Pagination
  - Search
  - CRUD operations
  - Real-time polling
- `user-manager.js` - Manajemen user dengan fitur:
  - Pagination
  - Search
  - CRUD operations
  - Real-time polling

### Views
Lokasi: `resources/views/admin/`
Setiap modul memiliki dua view:
1. `index.blade.php` - View lama yang menggunakan Livewire (sudah diperbarui)
2. `alpine-index.blade.php` - View baru yang menggunakan AlpineJS

### Routes
Lokasi: `routes/web.php`
Semua route admin menggunakan AlpineJS:
- `/admin/dashboard` - Dashboard overview
- `/admin/berita` - Manajemen berita
- `/admin/kategori` - Manajemen kategori
- `/admin/users` - Manajemen user
- `/admin/poli` - Manajemen poli
- `/admin/dokter` - Manajemen dokter
- `/admin/jadwal-poli` - Manajemen jadwal poli
- `/admin/carousel` - Manajemen carousel

API Routes:
- `/admin/api/berita` - API untuk berita
- `/admin/api/kategori` - API untuk kategori
- `/admin/api/user` - API untuk user
- `/admin/api/poli` - API untuk poli
- `/admin/api/dokter` - API untuk dokter
- `/admin/api/jadwal-poli` - API untuk jadwal poli
- `/admin/api/carousel` - API untuk carousel
- `/admin/api/dashboard/stats` - API untuk statistik dashboard
- `/admin/api/dashboard/recent-berita` - API untuk berita terbaru
- `/admin/api/dashboard/recent-users` - API untuk user terbaru
- `/admin/api/dashboard/monthly-data` - API untuk data bulanan

## Fitur AlpineJS

### Komponen Bersama
Semua AlpineJS managers memiliki fitur:
1. **CSRF Protection** - Helper function untuk mendapatkan CSRF token
2. **Error Handling** - Centralized error handling dengan toast notifications
3. **Loading States** - Loading indicators untuk semua operasi async
4. **Toast Notifications** - Menggunakan SweetAlert2 untuk notifikasi
5. **Real-time Polling** - Auto-refresh data setiap 30 detik
6. **Pagination** - Pagination dengan navigation controls
7. **Search** - Real-time search dengan debounce
8. **Form Validation** - Server-side validation error handling

### Fitur Khusus
- **Berita Manager**: Summernote integration untuk rich text editor
- **Dashboard Manager**: Chart.js integration untuk visualisasi data
- **Carousel Manager**: Image upload dengan preview
- **User Manager**: Password handling untuk create/update

## Cara Penggunaan

### Inisialisasi
Setiap AlpineJS manager diinisialisasi secara otomatis melalui `resources/js/app.js`:
```javascript
import './alpine/berita-manager.js';
import './alpine/kategori-manager.js';
import './alpine/user-manager.js';
import './alpine/poli-manager.js';
import './alpine/dokter-manager.js';
import './alpine/jadwal-poli-manager.js';
import './alpine/carousel-manager.js';
import './alpine/dashboard-manager.js';
```

### Penggunaan di View
Setiap view menggunakan Alpine component dengan `x-data`:
```html
<div x-data="beritaManager" x-init="init()" x-cloak>
    <!-- Content -->
</div>
```

## Keuntungan AlpineJS vs Livewire

### AlpineJS
✅ **Lebih Ringan** - Tidak memerlukan server-side rendering
✅ **Lebih Cepat** - Client-side processing
✅ **Lebih Fleksibel** - Dapat dikombinasikan dengan library JavaScript apa pun
✅ **Bundle Size Lebih Kecil** - Hanya JavaScript yang diperlukan
✅ **Offline Support** - Dapat berfungsi tanpa koneksi server
✅ **Better UX** - Real-time updates tanpa page reload

### Livewire
❌ **Lebih Berat** - Memerlukan server-side rendering
❌ **Lebih Lambat** - Round-trip ke server untuk setiap aksi
❌ **Kurang Fleksibel** - Terbatas pada ekosistem Laravel
❌ **Bundle Size Lebih Besar** - JavaScript + server-side components
❌ **Tidak Support Offline** - Memerlukan koneksi server
❌ **UX Kurang Smooth** - Page reload untuk setiap aksi

## Best Practices

### 1. Error Handling
Gunakan centralized error handling:
```javascript
try {
    // API call
} catch (error) {
    console.error('Error:', error);
    this.showToast('Error message', 'error');
}
```

### 2. Loading States
Selalu tampilkan loading state:
```javascript
this.loading = true;
try {
    // API call
} finally {
    this.loading = false;
}
```

### 3. Real-time Updates
Gunakan polling untuk data yang sering berubah:
```javascript
startPolling() {
    this.pollingInterval = setInterval(() => {
        this.loadData();
    }, 30000); // 30 seconds
}
```

### 4. Form Validation
Handle validation errors dengan baik:
```javascript
if (data.errors) {
    this.errors = data.errors;
    this.showToast(data.message || 'Validation error', 'error');
}
```

## Troubleshooting

### Common Issues
1. **AlpineJS tidak terinisialisasi**
   - Pastikan `resources/js/app.js` mengimport semua managers
   - Check console untuk error messages

2. **API calls tidak berfungsi**
   - Pastikan route sudah terdaftar di `routes/web.php`
   - Check CSRF token configuration

3. **Charts tidak tampil**
   - Pastikan Chart.js sudah di-load
   - Check data format dari API

4. **Real-time polling tidak berfungsi**
   - Pastikan `destroy()` method dipanggil saat page unload
   - Check interval cleanup

### Debug Tips
1. Gunakan `console.log()` untuk debugging
2. Check Network tab di browser dev tools
3. Test API endpoints secara manual
4. Gunakan `x-cloak` untuk prevent FOUC (Flash of Unstyled Content)

## Migration Checklist
- [x] Hapus semua Livewire components
- [x] Hapus semua Livewire views
- [x] Hapus Livewire dependency dari composer.json
- [x] Update semua routes untuk menggunakan AlpineJS views
- [x] Update semua views untuk menggunakan AlpineJS
- [x] Clear view cache
- [x] Test semua modul admin
- [x] Test API endpoints
- [x] Test real-time updates

## Kesimpulan
Migrasi dari Livewire ke AlpineJS telah berhasil dilakukan dengan:
1. Performa lebih baik
2. User experience lebih smooth
3. Bundle size lebih kecil
4. Lebih fleksibel untuk pengembangan future
5. Offline support capability

Admin panel RSUD sekarang sepenuhnya menggunakan AlpineJS dengan semua fitur yang sebelumnya ada di Livewire.