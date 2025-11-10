<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DokterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dokters = [
            ['Dr. Ahmad Wijaya', 'Spesialis Penyakit Dalam', 1, '081234567890', 'aktif'],
            ['Dr. Siti Nurhaliza', 'Spesialis Kandungan', 3, '081234567891', 'aktif'],
            ['Dr. Budi Santoso', 'Spesialis Anak', 3, '081234567892', 'aktif'],
            ['Dr. Diana Putri', 'Spesialis Gigi', 2, '081234567893', 'aktif'],
            ['Dr. Eko Prasetyo', 'Spesialis Bedah', 6, '081234567894', 'aktif'],
            ['Dr. Fitri Handayani', 'Spesialis Mata', 7, '081234567895', 'aktif'],
            ['Dr. Gunawan Wijaya', 'Spesialis THT', 8, '081234567896', 'aktif'],
            ['Dr. Hesti Lestari', 'Spesialis Jantung', 9, '081234567897', 'aktif'],
            ['Dr. Indra Kusuma', 'Spesialis Saraf', 10, '081234567898', 'aktif'],
            ['Dr. Julia Rahmawati', 'Spesialis Paru', 11, '081234567899', 'aktif'],
            ['Dr. Kevin Pratama', 'Spesialis Kulit', 12, '081234567900', 'aktif'],
            ['Dr. Lisa Permata', 'Spesialis Orthopedi', 13, '081234567901', 'aktif'],
            ['Dr. Muhammad Rizki', 'Spesialis Urologi', 14, '081234567902', 'aktif'],
            ['Dr. Novita Sari', 'Spesialis Psikiatri', 15, '081234567903', 'aktif'],
            ['Dr. Oscar Hendra', 'Spesialis Rehabilitasi Medik', 16, '081234567904', 'aktif'],
            ['Dr. Putri Anggraini', 'Ahli Gizi', 17, '081234567905', 'aktif'],
            ['Dr. Qori Amalia', 'Spesialis Fisioterapi', 18, '081234567906', 'aktif'],
            ['Dr. Ryan Setiawan', 'Spesialis Laboratorium', 19, '081234567907', 'aktif'],
            ['Dr. Sarah Wijaya', 'Spesialis Radiologi', 20, '081234567908', 'aktif'],
            ['Dr. Tommy Pratama', 'Spesialis Farmasi', 21, '081234567909', 'aktif'],
            ['Dr. Ulfa Hasanah', 'Spesialis Gawat Darurat', 22, '081234567910', 'aktif'],
            ['Dr. Victor Kurniawan', 'Spesialis ICU', 23, '081234567911', 'aktif'],
            ['Dr. Winda Sari', 'Spesialis NICU', 24, '081234567912', 'aktif'],
            ['Dr. Xaverius Hendra', 'Spesialis PICU', 25, '081234567913', 'aktif'],
            ['Dr. Yuniarti Putri', 'Spesialis Hemodialisa', 26, '081234567914', 'aktif'],
            ['Dr. Zainal Abidin', 'Spesialis Onkologi', 27, '081234567915', 'aktif'],
            ['Dr. Amelia Putri', 'Spesialis Endokrin', 28, '081234567916', 'aktif'],
            ['Dr. Bambang Sutrisno', 'Spesialis Geriatri', 29, '081234567917', 'aktif'],
            ['Dr. Citra Dewi', 'Spesialis Kosmetik', 30, '081234567918', 'aktif'],
            ['Dr. Dedi Kurniawan', 'Spesialis Alternatif', 31, '081234567919', 'aktif'],
            ['Dr. Eva Susanti', 'Spesialis Vaksinasi', 32, '081234567920', 'aktif'],
            ['Dr. Fajar Nugroho', 'Spesialis Medical Check Up', 33, '081234567921', 'aktif'],
            ['Dr. Gina Marlina', 'Spesialis Konsultasi Online', 34, '081234567922', 'aktif'],
            ['Dr. Hendra Wijaya', 'Spesialis Home Care', 35, '081234567923', 'aktif'],
            ['Dr. Indah Permata', 'Spesialis Laktasi', 36, '081234567924', 'aktif'],
            ['Dr. Joko Susilo', 'Spesialis Menopause', 37, '081234567925', 'aktif'],
            ['Dr. Kartika Sari', 'Spesialis Andrologi', 38, '081234567926', 'aktif'],
            ['Dr. Lukman Hakim', 'Spesialis Nefrologi', 39, '081234567927', 'aktif'],
            ['Dr. Maya Putri', 'Spesialis Hepatologi', 40, '081234567928', 'aktif'],
            ['Dr. Nurul Hidayah', 'Spesialis Gastroenterologi', 41, '081234567929', 'aktif'],
            ['Dr. Oki Setiawan', 'Spesialis Rheumatologi', 42, '081234567930', 'aktif'],
            ['Dr. Permata Sari', 'Spesialis Allergi', 43, '081234567931', 'aktif'],
            ['Dr. Rizki Ahmad', 'Spesialis Infeksi', 44, '081234567932', 'aktif'],
            ['Dr. Siti Aminah', 'Spesialis Genetik', 45, '081234567933', 'aktif'],
            ['Dr. Teguh Prasetyo', 'Spesialis Sleep', 46, '081234567934', 'aktif'],
            ['Dr. Umar Said', 'Spesialis Sports', 47, '081234567935', 'aktif'],
            ['Dr. Vina Lestari', 'Spesialis Occupational', 48, '081234567936', 'aktif'],
            ['Dr. Wahyu Hidayat', 'Spesialis Travel', 49, '081234567937', 'aktif'],
            ['Dr. Yuni Astuti', 'Spesialis Student Health', 50, '081234567938', 'aktif'],
        ];

        foreach ($dokters as $dokter) {
            DB::table('dokters')->insert([
                'nama' => $dokter[0],
                'spesialis' => $dokter[1],
                'poli_id' => $dokter[2],
                'kontak' => $dokter[3],
                'status' => $dokter[4],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('50 dokter records created successfully.');
    }
}