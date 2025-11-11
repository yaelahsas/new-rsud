# Setup Fitur Baru Admin Panel RSUD

Berikut adalah panduan setup untuk fitur-fitur baru yang telah ditambahkan ke admin panel RSUD:

## 1. Prasyarat

- PHP 8.0 atau lebih tinggi
- Composer
- Node.js dan NPM
- Laravel 9.x
- Database MySQL atau MariaDB
- Web server (Apache, Nginx, atau Laravel Valet)

## 2. Setup Database

Pastikan semua migrasi database telah dijalankan:

```bash
php artisan migrate
```

## 3. Setup Seeder

Jalankan seeder untuk mengisi data awal:

```bash
php artisan db:seed
```

## 4. Setup Assets

Compile assets frontend:

```bash
npm install
npm run build
```

## 5. Konfigurasi Environment

Pastikan file `.env` memiliki konfigurasi yang benar:

```env
APP_NAME="RSUD Admin"
APP_ENV=local
APP_KEY=base64:...
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=rsud_db
DB_USERNAME=root
DB_PASSWORD=

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1
MEMCACHED_PORT=11211
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="${APP_NAME}"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1

MIX_PUSHER_APP_KEY=
MIX_PUSHER_APP_SECRET=
MIX_PUSHER_APP_CLUSTER=mt1
```

## 6. Akses Admin Panel

1. Jalankan server development:

```bash
php artisan serve
```

2. Buka browser dan akses `http://localhost:8000/admin`

3. Login dengan kredensial default:
   - Username: `admin`
   - Password: `password`

## 7. Fitur Baru yang Tersedia

Setelah login, Anda akan melihat menu baru di sidebar:

### Galeri
- Manajemen foto galeri
- Upload dan pengaturan foto
- Kategorisasi galeri
- Search dan filter

### Inovasi
- Manajemen inovasi
- CRUD inovasi
- Status inovasi (aktif/non-aktif)
- Search dan filter

### Pengumuman
- Manajemen pengumuman
- CRUD pengumuman
- Status pengumuman (aktif/non-aktif)
- Search dan filter

### Kontak
- Manajemen kontak
- CRUD kontak
- Jenis kontak (telepon, email, alamat, dll)
- Search dan filter

### Log Aktivitas
- Manajemen log aktivitas
- Filter berdasarkan modul
- Filter berdasarkan user
- Filter berdasarkan tanggal
- Search
- Hapus log lama

### Settings
- Manajemen pengaturan sistem
- CRUD setting
- Kategorisasi setting
- Search dan filter
- Bulk update setting

### Review
- Manajemen review
- CRUD review
- Rating bintang (1-5)
- Filter berdasarkan inovasi
- Filter berdasarkan rating
- Search

## 8. Trouleshooting

### Masalah Umum

1. **Error 404 Not Found**
   - Pastikan route telah ditambahkan dengan benar di `routes/web.php`
   - Jalankan `php artisan route:list` untuk memeriksa semua route

2. **Error 500 Server Error**
   - Periksa log Laravel di `storage/logs/laravel.log`
   - Pastikan file `.env` memiliki konfigurasi yang benar
   - Jalankan `php artisan config:cache` dan `php artisan config:clear`

3. **Assets Tidak Berfungsi**
   - Jalankan `npm run build` untuk mengompil ulang assets
   - Pastikan `public/js/app.js` telah diperbarui dengan Alpine JS baru

4. **Database Connection Error**
   - Pastikan database server berjalan
   - Periksa kredensial database di file `.env`
   - Pastikan database dan tabel telah dibuat

### Debug Mode

Untuk mengaktifkan mode debug:

```bash
php artisan config:cache:clear
php artisan config:clear
```

## 9. Kontribusi

Jika menemukan bug atau memiliki saran untuk perbaikan:

1. Fork repository
2. Buat branch baru untuk fitur yang akan diperbaiki
3. Lakukan perubahan
4. Buat pull request dengan deskripsi masalah dan solusi

## 10. Catatan Penting

- Pastikan untuk selalu menjalankan migrasi database saat menambahkan fitur baru
- Backup database sebelum melakukan perubahan besar
- Test semua fitur baru di lingkungan development sebelum deploy ke production
- Ikuti standar coding PSR-12 untuk menjaga kualitas kode