<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KontakSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kontaks = [
            ['WhatsApp', 'Pendaftaran Online', '+6281234567890', 'fab fa-whatsapp'],
            ['Telepon', 'Hotline Darurat', '(0234) 123456', 'fas fa-phone'],
            ['Email', 'Informasi Umum', 'info@rsudgenteng.com', 'fas fa-envelope'],
            ['WhatsApp', 'Layanan Farmasi', '+6281234567891', 'fab fa-whatsapp'],
            ['Telepon', 'Poli Spesialis', '(0234) 123457', 'fas fa-phone'],
            ['Email', 'Kerjasama', 'kerjasama@rsudgenteng.com', 'fas fa-envelope'],
            ['WhatsApp', 'Layanan Laboratorium', '+6281234567892', 'fab fa-whatsapp'],
            ['Telepon', 'ICU', '(0234) 123458', 'fas fa-phone'],
            ['Email', 'Karir', 'karir@rsudgenteng.com', 'fas fa-envelope'],
            ['WhatsApp', 'Layanan Radiologi', '+6281234567893', 'fab fa-whatsapp'],
            ['Telepon', 'Ruang Bersalin', '(0234) 123459', 'fas fa-phone'],
            ['Email', 'Keluhan', 'keluhan@rsudgenteng.com', 'fas fa-envelope'],
            ['WhatsApp', 'Layanan Gigi', '+6281234567894', 'fab fa-whatsapp'],
            ['Telepon', 'Hemodialisa', '(0234) 123460', 'fas fa-phone'],
            ['Email', 'Saran', 'saran@rsudgenteng.com', 'fas fa-envelope'],
            ['WhatsApp', 'Layanan Anak', '+6281234567895', 'fab fa-whatsapp'],
            ['Telepon', 'Fisioterapi', '(0234) 123461', 'fas fa-phone'],
            ['Email', 'Humas', 'humas@rsudgenteng.com', 'fas fa-envelope'],
            ['WhatsApp', 'Layanan Kandungan', '+6281234567896', 'fab fa-whatsapp'],
            ['Telepon', 'NICU', '(0234) 123462', 'fas fa-phone'],
            ['Email', 'IT Support', 'it@rsudgenteng.com', 'fas fa-envelope'],
            ['WhatsApp', 'Layanan Mata', '+6281234567897', 'fab fa-whatsapp'],
            ['Telepon', 'PICU', '(0234) 123463', 'fas fa-phone'],
            ['Email', 'Akademik', 'akademik@rsudgenteng.com', 'fas fa-envelope'],
            ['WhatsApp', 'Layanan THT', '+6281234567898', 'fab fa-whatsapp'],
            ['Telepon', 'IGD', '(0234) 123464', 'fas fa-phone'],
            ['Email', 'Penelitian', 'riset@rsudgenteng.com', 'fas fa-envelope'],
            ['WhatsApp', 'Layanan Jantung', '+6281234567899', 'fab fa-whatsapp'],
            ['Telepon', 'Rawat Inap VIP', '(0234) 123465', 'fas fa-phone'],
            ['Email', 'Donasi', 'donasi@rsudgenteng.com', 'fas fa-envelope'],
            ['WhatsApp', 'Layanan Saraf', '+6281234567900', 'fab fa-whatsapp'],
            ['Telepon', 'Rawat Inap Kelas 1', '(0234) 123466', 'fas fa-phone'],
            ['Email', 'Volunteer', 'volunteer@rsudgenteng.com', 'fas fa-envelope'],
            ['WhatsApp', 'Layanan Paru', '+6281234567901', 'fab fa-whatsapp'],
            ['Telepon', 'Rawat Inap Kelas 2', '(0234) 123467', 'fas fa-phone'],
            ['Email', 'Media', 'media@rsudgenteng.com', 'fas fa-envelope'],
            ['WhatsApp', 'Layanan Kulit', '+6281234567902', 'fab fa-whatsapp'],
            ['Telepon', 'Rawat Inap Kelas 3', '(0234) 123468', 'fas fa-phone'],
            ['Email', 'Legal', 'legal@rsudgenteng.com', 'fas fa-envelope'],
            ['WhatsApp', 'Layanan Orthopedi', '+6281234567903', 'fab fa-whatsapp'],
            ['Telepon', 'Kamar Operasi', '(0234) 123469', 'fas fa-phone'],
            ['Email', 'Procurement', 'procurement@rsudgenteng.com', 'fas fa-envelope'],
            ['WhatsApp', 'Layanan Urologi', '+6281234567904', 'fab fa-whatsapp'],
            ['Telepon', 'Laboratorium 24 Jam', '(0234) 123470', 'fas fa-phone'],
            ['Email', 'Finance', 'finance@rsudgenteng.com', 'fas fa-envelope'],
            ['WhatsApp', 'Layanan Psikiatri', '+6281234567905', 'fab fa-whatsapp'],
            ['Telepon', 'Farmasi 24 Jam', '(0234) 123471', 'fas fa-phone'],
            ['Email', 'Marketing', 'marketing@rsudgenteng.com', 'fas fa-envelope'],
            ['WhatsApp', 'Layanan Geriatri', '+6281234567906', 'fab fa-whatsapp'],
            ['Telepon', 'Ambulance', '(0234) 123472', 'fas fa-phone'],
            ['Email', 'General', 'admin@rsudgenteng.com', 'fas fa-envelope'],
        ];

        foreach ($kontaks as $kontak) {
            DB::table('kontaks')->insert([
                'jenis_kontak' => $kontak[0],
                'label' => $kontak[1],
                'value' => $kontak[2],
                'icon' => $kontak[3],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('50 kontak records created successfully.');
    }
}