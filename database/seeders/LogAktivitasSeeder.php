<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class LogAktivitasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get admin user for user_id field
        $adminUser = User::where('email', 'admin@rsudgenteng.com')->first();
        
        $activities = [
            ['Menambah Berita', 'Berita', 'Menambah berita baru: RSUD Genteng Meluncurkan Layanan Telemedicine', '192.168.1.100'],
            ['Mengedit Berita', 'Berita', 'Mengedit berita: Vaksinasi COVID-19 Dosis Booster Tersedia', '192.168.1.101'],
            ['Menghapus Berita', 'Berita', 'Menghapus berita: Pengumuman Jadwal Libur', '192.168.1.102'],
            ['Menambah Poli', 'Poli', 'Menambah poli baru: Poli Geriatri', '192.168.1.103'],
            ['Mengedit Poli', 'Poli', 'Mengedit poli: Poli Umum', '192.168.1.104'],
            ['Menambah Dokter', 'Dokter', 'Menambah dokter baru: Dr. Ahmad Wijaya', '192.168.1.105'],
            ['Mengedit Dokter', 'Dokter', 'Mengedit data dokter: Dr. Siti Nurhaliza', '192.168.1.106'],
            ['Menambah Jadwal', 'Jadwal', 'Menambah jadwal dokter: Dr. Budi Santoso', '192.168.1.107'],
            ['Mengedit Jadwal', 'Jadwal', 'Mengedit jadwal poli: Poli Anak', '192.168.1.108'],
            ['Menambah Kategori', 'Kategori', 'Menambah kategori berita: Kesehatan', '192.168.1.109'],
            ['Mengedit Kategori', 'Kategori', 'Mengedit kategori: Layanan', '192.168.1.110'],
            ['Menambah Inovasi', 'Inovasi', 'Menambah inovasi baru: Sistem Antrian Digital', '192.168.1.111'],
            ['Mengedit Inovasi', 'Inovasi', 'Mengedit inovasi: Telemedicine RSUD', '192.168.1.112'],
            ['Menambah Review', 'Review', 'Menambah review baru: Layanan sangat memuaskan', '192.168.1.113'],
            ['Mengedit Review', 'Review', 'Mengedit review: Fasilitas modern dan bersih', '192.168.1.114'],
            ['Menambah Galeri', 'Galeri', 'Menambah galeri baru: Gedung Utama RSUD', '192.168.1.115'],
            ['Mengedit Galeri', 'Galeri', 'Mengedit galeri: Lobi Pendaftaran', '192.168.1.116'],
            ['Menambah Pengumuman', 'Pengumuman', 'Menambah pengumuman: Libur Idul Fitri', '192.168.1.117'],
            ['Mengedit Pengumuman', 'Pengumuman', 'Mengedit pengumuman: Vaksinasi COVID-19', '192.168.1.118'],
            ['Menambah Kontak', 'Kontak', 'Menambah kontak baru: WhatsApp Pendaftaran', '192.168.1.119'],
            ['Mengedit Kontak', 'Kontak', 'Mengedit kontak: Hotline Darurat', '192.168.1.120'],
            ['Menambah Setting', 'Setting', 'Menambah setting: App Name', '192.168.1.121'],
            ['Mengedit Setting', 'Setting', 'Mengedit setting: App Description', '192.168.1.122'],
            ['Menambah Carousel', 'Carousel', 'Menambah carousel baru: Slide 1', '192.168.1.123'],
            ['Mengedit Carousel', 'Carousel', 'Mengedit carousel: Slide 2', '192.168.1.124'],
            ['Login', 'Auth', 'User login: admin@rsudgenteng.com', '192.168.1.125'],
            ['Logout', 'Auth', 'User logout: admin@rsudgenteng.com', '192.168.1.126'],
            ['Menambah User', 'User', 'Menambah user baru: editor@rsudgenteng.com', '192.168.1.127'],
            ['Mengedit User', 'User', 'Mengedit user: editor@rsudgenteng.com', '192.168.1.128'],
            ['Menghapus User', 'User', 'Menghapus user: test@rsudgenteng.com', '192.168.1.129'],
            ['Backup Database', 'System', 'Melakukan backup database', '192.168.1.130'],
            ['Restore Database', 'System', 'Melakukan restore database', '192.168.1.131'],
            ['Export Data', 'System', 'Export data pasien', '192.168.1.132'],
            ['Import Data', 'System', 'Import data dokter', '192.168.1.133'],
            ['Menambah Laporan', 'Laporan', 'Menambah laporan bulanan', '192.168.1.134'],
            ['Mengedit Laporan', 'Laporan', 'Mengedit laporan keuangan', '192.168.1.135'],
            ['Menambah Antrian', 'Antrian', 'Menambah antrian baru', '192.168.1.136'],
            ['Mengedit Antrian', 'Antrian', 'Mengedit status antrian', '192.168.1.137'],
            ['Menambah Resep', 'Resep', 'Menambah resep baru', '192.168.1.138'],
            ['Mengedit Resep', 'Resep', 'Mengedit resep pasien', '192.168.1.139'],
            ['Menambah Pemeriksaan', 'Pemeriksaan', 'Menambah pemeriksaan baru', '192.168.1.140'],
            ['Mengedit Pemeriksaan', 'Pemeriksaan', 'Mengedit hasil pemeriksaan', '192.168.1.141'],
            ['Menambah Diagnosis', 'Diagnosis', 'Menambah diagnosis baru', '192.168.1.142'],
            ['Mengedit Diagnosis', 'Diagnosis', 'Mengedit diagnosis pasien', '192.168.1.143'],
            ['Menambah Tindakan', 'Tindakan', 'Menambah tindakan medis', '192.168.1.144'],
            ['Mengedit Tindakan', 'Tindakan', 'Mengedit tindakan pasien', '192.168.1.145'],
            ['Menambah Obat', 'Obat', 'Menambah obat baru', '192.168.1.146'],
            ['Mengedit Obat', 'Obat', 'Mengedit data obat', '192.168.1.147'],
            ['Menambah Ruangan', 'Ruangan', 'Menambah ruangan baru', '192.168.1.148'],
            ['Mengedit Ruangan', 'Ruangan', 'Mengedit data ruangan', '192.168.1.149'],
            ['Menambah Peralatan', 'Peralatan', 'Menambah peralatan medis', '192.168.1.150'],
            ['Mengedit Peralatan', 'Peralatan', 'Mengedit data peralatan', '192.168.1.151'],
        ];

        foreach ($activities as $activity) {
            DB::table('log_aktivitas')->insert([
                'user_id' => $adminUser ? $adminUser->id : null,
                'aksi' => $activity[0],
                'modul' => $activity[1],
                'detail' => $activity[2],
                'ip' => $activity[3],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('50 log aktivitas records created successfully.');
    }
}