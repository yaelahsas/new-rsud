<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GaleriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $galeris = [
            ['Gedung Utama RSUD Genteng', 'gedung_utama.jpg', 'Gedung utama RSUD Genteng yang modern dan megah', 'foto'],
            ['Lobi Pendaftaran', 'lobi_pendaftaran.jpg', 'Lobi pendaftaran yang nyaman dan modern', 'foto'],
            ['Ruang Tunggu Pasien', 'ruang_tunggu.jpg', 'Ruang tunggu pasien yang nyaman dengan fasilitas lengkap', 'foto'],
            ['Poli Umum', 'poli_umum.jpg', 'Poli umum dengan pelayanan terbaik', 'foto'],
            ['Poli Gigi', 'poli_gigi.jpg', 'Poli gigi dengan peralatan modern', 'foto'],
            ['Poli Anak', 'poli_anak.jpg', 'Poli anak yang ramah dan nyaman untuk anak-anak', 'foto'],
            ['Ruang Operasi', 'ruang_operasi.jpg', 'Ruang operasi modern dengan teknologi canggih', 'foto'],
            ['ICU', 'icu.jpg', 'Unit perawatan intensif dengan peralatan lengkap', 'foto'],
            ['Laboratorium', 'lab.jpg', 'Laboratorium dengan peralatan modern dan akurat', 'foto'],
            ['Radiologi', 'radiologi.jpg', 'Unit radiologi dengan teknologi digital', 'foto'],
            ['Farmasi', 'farmasi.jpg', 'Unit farmasi dengan obat-obatan lengkap', 'foto'],
            ['Ruang Rawat Inap', 'rawat_inap.jpg', 'Ruang rawat inap yang nyaman dan bersih', 'foto'],
            ['Ruang Bersalin', 'bersalin.jpg', 'Ruang bersalin yang modern dan nyaman', 'foto'],
            ['NICU', 'nicu.jpg', 'Unit perawatan intensif neonatal', 'foto'],
            ['PICU', 'picu.jpg', 'Unit perawatan intensif anak', 'foto'],
            ['Hemodialisa', 'hemodialisa.jpg', 'Unit hemodialisa dengan peralatan modern', 'foto'],
            ['Fisioterapi', 'fisioterapi.jpg', 'Unit fisioterapi dengan peralatan lengkap', 'foto'],
            ['Kantin', 'kantin.jpg', 'Kantin sehat dengan menu bergizi', 'foto'],
            ['Masjid', 'masjid.jpg', 'Masjid RSUD Genteng yang nyaman', 'foto'],
            ['Parkir', 'parkir.jpg', 'Area parkir yang luas dan aman', 'foto'],
            ['Taman', 'taman.jpg', 'Taman yang asri dan nyaman', 'foto'],
            ['Video Profil RSUD', 'profil.mp4', 'Video profil RSUD Genteng', 'video'],
            ['Video Layanan', 'layanan.mp4', 'Video layanan unggulan RSUD Genteng', 'video'],
            ['Video Testimoni', 'testimoni.mp4', 'Video testimoni pasien', 'video'],
            ['Seminar Kesehatan', 'seminar.jpg', 'Kegiatan seminar kesehatan', 'foto'],
            ['Workshop Medis', 'workshop.jpg', 'Workshop medis untuk tenaga kesehatan', 'foto'],
            ['Donor Darah', 'donor_darah.jpg', 'Kegiatan donor darah rutin', 'foto'],
            ['Vaksinasi', 'vaksinasi.jpg', 'Kegiatan vaksinasi massal', 'foto'],
            ['Sosialisasi Kesehatan', 'sosialisasi.jpg', 'Sosialisasi kesehatan ke masyarakat', 'foto'],
            ['Pelatihan BHD', 'bhd.jpg', 'Pelatihan bantuan hidup dasar', 'foto'],
            ['Kunjungan Sekolah', 'kunjungan_sekolah.jpg', 'Kunjungan siswa sekolah ke RSUD', 'foto'],
            ['Video Edukasi', 'edukasi.mp4', 'Video edukasi kesehatan', 'video'],
            ['Tim Medis', 'tim_medis.jpg', 'Tim medis RSUD Genteng', 'foto'],
            ['Peresmian Gedung Baru', 'peresmian.jpg', 'Acara peresmian gedung baru', 'foto'],
            ['Penghargaan', 'penghargaan.jpg', 'Penyerahan penghargaan kepada RSUD', 'foto'],
            ['Akreditasi', 'akreditasi.jpg', 'Proses akreditasi RSUD Genteng', 'foto'],
            ['Kerjasama', 'kerjasama.jpg', 'Penandatanganan kerjasama', 'foto'],
            ['Video Inovasi', 'inovasi.mp4', 'Video inovasi RSUD Genteng', 'video'],
            ['Alat Medis Baru', 'alat_medis.jpg', 'Alat medis terbaru di RSUD', 'foto'],
            ['Simulasi Bencana', 'simulasi.jpg', 'Simulasi penanggulangan bencana', 'foto'],
            ['Video Promosi', 'promosi.mp4', 'Video promosi layanan RSUD', 'video'],
            ['Kegiatan Sosial', 'sosial.jpg', 'Kegiatan sosial kemasyarakatan', 'foto'],
            ['Olahraga Karyawan', 'olahraga.jpg', 'Kegiatan olahraga karyawan', 'foto'],
            ['Video Tutorial', 'tutorial.mp4', 'Video tutorial kesehatan', 'video'],
            ['Ruang Meeting', 'meeting.jpg', 'Ruang meeting modern', 'foto'],
            ['Perpustakaan', 'perpustakaan.jpg', 'Perpustakaan medis RSUD', 'foto'],
            ['Video Dokumentasi', 'dokumentasi.mp4', 'Video dokumentasi kegiatan RSUD', 'video'],
            ['Ruang Istirahat', 'istirahat.jpg', 'Ruang istirahat karyawan', 'foto'],
            ['Video Virtual Tour', 'virtual_tour.mp4', 'Video virtual tour RSUD Genteng', 'video'],
        ];

        foreach ($galeris as $galeri) {
            DB::table('galeris')->insert([
                'judul' => $galeri[0],
                'gambar' => $galeri[1],
                'deskripsi' => $galeri[2],
                'kategori' => $galeri[3],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('50 galeri records created successfully.');
    }
}