<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class PoliSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get admin user for created_by field
        $adminUser = User::where('email', 'admin@rsudgenteng.com')->first();
        
        $polis = [
            ['Poli Umum', 'A1', 'Pelayanan medis umum untuk semua pasien', 'aktif'],
            ['Poli Gigi', 'A2', 'Pelayanan kesehatan gigi dan mulut', 'aktif'],
            ['Poli Anak', 'B1', 'Pelayanan kesehatan untuk anak-anak', 'aktif'],
            ['Poli Kandungan', 'B2', 'Pelayanan kesehatan untuk ibu hamil dan persalinan', 'aktif'],
            ['Poli Penyakit Dalam', 'C1', 'Pelayanan untuk penyakit dalam dewasa', 'aktif'],
            ['Poli Bedah', 'C2', 'Pelayanan bedah umum dan spesialis', 'aktif'],
            ['Poli Mata', 'D1', 'Pelayanan kesehatan mata', 'aktif'],
            ['Poli THT', 'D2', 'Pelayanan Telinga, Hidung, dan Tenggorokan', 'aktif'],
            ['Poli Jantung', 'E1', 'Pelayanan kesehatan jantung dan pembuluh darah', 'aktif'],
            ['Poli Saraf', 'E2', 'Pelayanan kesehatan sistem saraf', 'aktif'],
            ['Poli Paru', 'F1', 'Pelayanan kesehatan paru-paru dan pernapasan', 'aktif'],
            ['Poli Kulit', 'F2', 'Pelayanan kesehatan kulit dan kelamin', 'aktif'],
            ['Poli Orthopedi', 'G1', 'Pelayanan kesehatan tulang dan sendi', 'aktif'],
            ['Poli Urologi', 'G2', 'Pelayanan kesehatan saluran kemih', 'aktif'],
            ['Poli Psikiatri', 'H1', 'Pelayanan kesehatan jiwa', 'aktif'],
            ['Poli Rehabilitasi Medik', 'H2', 'Pelayanan rehabilitasi medis', 'aktif'],
            ['Poli Gizi', 'I1', 'Konsultasi gizi dan diet', 'aktif'],
            ['Poli Fisioterapi', 'I2', 'Pelayanan fisioterapi', 'aktif'],
            ['Poli Laboratorium', 'J1', 'Pelayanan pemeriksaan laboratorium', 'aktif'],
            ['Poli Radiologi', 'J2', 'Pelayanan pemeriksaan radiologi', 'aktif'],
            ['Poli Farmasi', 'K1', 'Pelayanan obat-obatan', 'aktif'],
            ['Poli Gawat Darurat', 'K2', 'Pelayanan gawat darurat 24 jam', 'aktif'],
            ['Poli ICU', 'L1', 'Unit perawatan intensif', 'aktif'],
            ['Poli NICU', 'L2', 'Unit perawatan intensif neonatal', 'aktif'],
            ['Poli PICU', 'M1', 'Unit perawatan intensif anak', 'aktif'],
            ['Poli Hemodialisa', 'M2', 'Pelayanan cuci darah', 'aktif'],
            ['Poli Onkologi', 'N1', 'Pelayanan kanker', 'aktif'],
            ['Poli Endokrin', 'N2', 'Pelayanan hormon dan metabolisme', 'aktif'],
            ['Poli Geriatri', 'O1', 'Pelayanan kesehatan lansia', 'aktif'],
            ['Poli Kosmetik', 'O2', 'Pelayanan kecantikan medis', 'aktif'],
            ['Poli Alternatif', 'P1', 'Pelayanan pengobatan alternatif', 'aktif'],
            ['Poli Vaksinasi', 'P2', 'Pelayanan imunisasi', 'aktif'],
            ['Poli Medical Check Up', 'Q1', 'Pelayanan pemeriksaan kesehatan', 'aktif'],
            ['Poli Konsultasi Online', 'Q2', 'Konsultasi medis online', 'aktif'],
            ['Poli Home Care', 'R1', 'Pelayanan medis di rumah', 'aktif'],
            ['Poli Laktasi', 'R2', 'Konsultasi menyusui', 'aktif'],
            ['Poli Menopause', 'S1', 'Pelayanan kesehatan menopause', 'aktif'],
            ['Poli Andrologi', 'S2', 'Pelayanan kesehatan pria', 'aktif'],
            ['Poli Nefrologi', 'T1', 'Pelayanan ginjal', 'aktif'],
            ['Poli Hepatologi', 'T2', 'Pelayanan hati', 'aktif'],
            ['Poli Gastroenterologi', 'U1', 'Pelayanan saluran cerna', 'aktif'],
            ['Poli Rheumatologi', 'U2', 'Pelayanan rematik', 'aktif'],
            ['Poli Allergi', 'V1', 'Pelayanan alergi dan imunologi', 'aktif'],
            ['Poli Infeksi', 'V2', 'Pelayanan penyakit infeksi', 'aktif'],
            ['Poli Genetik', 'W1', 'Konsultasi medis genetik', 'aktif'],
            ['Poli Sleep', 'W2', 'Pelayanan gangguan tidur', 'aktif'],
            ['Poli Sports', 'X1', 'Pelayanan kesehatan olahraga', 'aktif'],
            ['Poli Occupational', 'X2', 'Pelayanan kesehatan kerja', 'aktif'],
            ['Poli Travel', 'Y1', 'Konsultasi medis perjalanan', 'aktif'],
            ['Poli Student Health', 'Y2', 'Pelayanan kesehatan pelajar', 'aktif'],
        ];

        foreach ($polis as $index => $poli) {
            DB::table('polis')->insert([
                'nama_poli' => $poli[0],
                'ruangan' => $poli[1],
                'deskripsi' => $poli[2],
                'status' => $poli[3],
                'created_by' => $adminUser ? $adminUser->id : null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('50 poli records created successfully.');
    }
}