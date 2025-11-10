<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class KategoriBeritaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoriBeritas = [
            'Berita Utama',
            'Pengumuman',
            'Kesehatan',
            'Layanan',
            'Event',
            'Prestasi',
            'Inovasi',
            'Penelitian',
            'Pendidikan',
            'Kerjasama',
            'Kegiatan Sosial',
            'Promosi Kesehatan',
            'Vaksinasi',
            'Kampanye',
            'Seminar',
            'Workshop',
            'Pelatihan',
            'Konferensi',
            'Lokakarya',
            'Simposium',
            'Bedah Kasus',
            'Diskusi Ilmiah',
            'Konsultasi Publik',
            'Sosialisasi',
            'Informasi RS',
            'Kebijakan',
            'Regulasi',
            'Standar',
            'Prosedur',
            'Protokol',
            'Pedoman',
            'Jadwal',
            'Lowongan',
            'Beasiswa',
            'Penghargaan',
            'Sertifikat',
            'Akreditasi',
            'Audit',
            'Evaluasi',
            'Monitoring',
            'Laporan',
            'Statistik',
            'Data',
            'Riset',
            'Studi Kasus',
            'Artikel Ilmiah',
            'Jurnal',
            'Publikasi',
            'Buletin',
            'Newsletter',
            'Press Release',
            'Media Coverage',
            'Testimoni',
            'Opini',
            'Editorial',
        ];

        foreach ($kategoriBeritas as $kategori) {
            DB::table('kategori_beritas')->insert([
                'nama_kategori' => $kategori,
                'slug' => Str::slug($kategori),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('50 kategori berita records created successfully.');
    }
}