# Setup Proyek Website Rumah Sakit RSUD Genteng

## Persiapan Awal

### 1. Install Dependencies
```bash
composer install
npm install
```

### 2. Konfigurasi Environment
```bash
cp .env.example .env
php artisan key:generate
```

### 3. Konfigurasi Database di .env
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=rsud_genteng
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Jalankan Migration dan Seeder
```bash
# Buat database terlebih dahulu di phpMyAdmin atau MySQL
# Kemudian jalankan:
php artisan migrate
php artisan db:seed
```

### 5. Build Assets
```bash
npm run build
```

### 6. Link Storage
```bash
php artisan storage:link
```

## Login Admin

### Default Admin User
- **Email**: admin@rsudgenteng.com
- **Password**: admin123

### Cara Login
1. Akses `http://localhost:8000/login`
2. Masukkan email dan password admin
3. Klik tombol Login

## Struktur Proyek

### Admin Panel Features
- **Dashboard**: Statistik lengkap dengan grafik
- **Berita Management**: CRUD berita dengan Summernote editor
- **Kategori Berita**: Manajemen kategori berita
- **Dokter Management**: CRUD dokter dengan foto dan relasi poli
- **Poli Management**: CRUD poli dengan counter dokter
- **Jadwal Poli**: CRUD jadwal dengan fitur cuti dokter
- **User Management**: CRUD user dengan role admin/editor
- **Carousel Management**: CRUD carousel untuk homepage

### Teknologi yang Digunakan
- **Backend**: Laravel 12 dengan Livewire 3.6
- **Frontend**: Bootstrap 4 + AdminLTE + Tailwind CSS
- **Database**: MySQL
- **Charts**: Chart.js
- **Editor**: Summernote
- **Authentication**: Laravel Auth

## Troubleshooting

### Masalah Login
Jika tidak bisa login:

1. **Check Database Connection**:
```bash
php artisan tinker
>>> DB::connection()->getPdo()
```

2. **Check User Exists**:
```bash
php artisan tinker
>>> User::where('email', 'admin@rsudgenteng.com')->first()
```

3. **Create Admin User Manual**:
```bash
php artisan tinker
>>> User::create([
...     'nama' => 'Administrator',
...     'email' => 'admin@rsudgenteng.com',
...     'password' => Hash::make('admin123'),
...     'role' => 'admin'
... ])
```

4. **Clear Cache**:
```bash
php artisan cache:clear
php artisan config:clear
php artisan session:clear
php artisan view:clear
```

### Error 404
Jika mengalami error 404:

1. **Check Routes**:
```bash
php artisan route:list
```

2. **Run Server**:
```bash
php artisan serve
```

### File Upload Not Working
Jika upload file tidak berfungsi:

1. **Check Storage Permissions**:
```bash
chmod -R 775 storage/
chmod -R 775 public/
```

2. **Check Storage Link**:
```bash
php artisan storage:link
```

## Development Commands

### Start Development Server
```bash
php artisan serve
```

### Watch Assets
```bash
npm run dev
```

### Production Build
```bash
npm run build
```

### Run Tests
```bash
php artisan test
```

## File Structure

```
app/
├── Http/Controllers/
│   └── AuthController.php
├── Livewire/Admin/
│   ├── Berita/Index.php
│   ├── Kategori/Index.php
│   ├── Dokter/Index.php
│   ├── Poli/Index.php
│   ├── JadwalPoli/Index.php
│   ├── User/Index.php
│   ├── Carousel/Index.php
│   └── Dashboard/Index.php
└── Models/
    ├── Berita.php
    ├── Kategori_berita.php
    ├── Dokter.php
    ├── Poli.php
    ├── Jadwal_poli.php
    ├── Carousel.php
    └── User.php

resources/
├── views/
│   ├── livewire/admin/
│   ├── components/admin/
│   └── login/
└── css/app.css
    └── js/app.js

database/
├── migrations/
└── seeders/
    ├── DatabaseSeeder.php
    └── AdminUserSeeder.php
```

## Notes

1. **Livewire Components**: Semua fitur admin menggunakan Livewire untuk real-time updates
2. **File Upload**: Gambar disimpan di `storage/app/public/uploads/`
3. **Authentication**: Menggunakan Laravel Auth dengan role-based access
4. **Responsive Design**: Admin panel responsive untuk mobile dan desktop
5. **Validation**: Semua form memiliki validasi client dan server side

## Support

Jika mengalami masalah:
1. Check Laravel logs: `storage/logs/laravel.log`
2. Clear cache: `php artisan optimize:clear`
3. Check database connection
4. Verify file permissions