<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JadwalPoliSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jadwals = [];
        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        
        // Generate 50 jadwal records
        for ($i = 1; $i <= 50; $i++) {
            $dokter_id = rand(1, 50);
            $poli_id = rand(1, 50);
            $hari_index = ($i - 1) % 7;
            $jam_mulai = sprintf('%02d:%02d', rand(7, 15), rand(0, 59));
            $jam_selesai = sprintf('%02d:%02d', rand(16, 21), rand(0, 59));
            $is_cuti = rand(0, 10) > 8; // 20% chance of being on leave
            $tanggal_cuti = $is_cuti ? date('Y-m-d', strtotime('+'.rand(1, 30).' days')) : null;
            
            $keterangan = $is_cuti ? 'Cuti ' . $hari[$hari_index] : 'Jadwal regular ' . $hari[$hari_index];
            
            $jadwals[] = [
                'dokter_id' => $dokter_id,
                'poli_id' => $poli_id,
                'hari' => $hari[$hari_index],
                'jam_mulai' => $jam_mulai,
                'jam_selesai' => $jam_selesai,
                'is_cuti' => $is_cuti,
                'tanggal_cuti' => $tanggal_cuti,
                'keterangan' => $keterangan,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('jadwal_polis')->insert($jadwals);

        $this->command->info('50 jadwal poli records created successfully.');
    }
}