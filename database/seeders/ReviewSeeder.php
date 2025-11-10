<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = [
            'Ahmad Rizki', 'Siti Nurhaliza', 'Budi Santoso', 'Diana Putri', 'Eko Prasetyo',
            'Fitri Handayani', 'Gunawan Wijaya', 'Hesti Lestari', 'Indra Kusuma', 'Julia Rahmawati',
            'Kevin Pratama', 'Lisa Permata', 'Muhammad Rizki', 'Novita Sari', 'Oscar Hendra',
            'Putri Anggraini', 'Qori Amalia', 'Ryan Setiawan', 'Sarah Wijaya', 'Tommy Pratama',
            'Ulfa Hasanah', 'Victor Kurniawan', 'Winda Sari', 'Xaverius Hendra', 'Yuniarti Putri',
            'Zainal Abidin', 'Amelia Putri', 'Bambang Sutrisno', 'Citra Dewi', 'Dedi Kurniawan',
            'Eva Susanti', 'Fajar Nugroho', 'Gina Marlina', 'Hendra Wijaya', 'Indah Permata',
            'Joko Susilo', 'Kartika Sari', 'Lukman Hakim', 'Maya Putri', 'Nurul Hidayah',
            'Oki Setiawan', 'Permata Sari', 'Rizki Ahmad', 'Siti Aminah', 'Teguh Prasetyo',
            'Umar Said', 'Vina Lestari', 'Wahyu Hidayat', 'Yuni Astuti', 'Zulkifli Rahman',
        ];

        $messages = [
            'Layanan sangat memuaskan, dokter dan perawat ramah dan profesional.',
            'Fasilitas modern dan bersih, pelayanan cepat dan tepat.',
            'Sistem antrian digital sangat membantu mengurangi waktu tunggu.',
            'Dokter sangat kompeten dan menjelaskan kondisi dengan detail.',
            'Pelayanan gawat darurat sangat responsif dan cepat tanggap.',
            'Ruang rawat inap nyaman dan perawat sangat perhatian.',
            'Sistem pendaftaran online sangat praktis dan mudah digunakan.',
            'Kualitas pelayanan sangat baik, harga terjangkau.',
            'Tim medis sangat berpengalaman dan ramah pada pasien.',
            'Fasilitas penunjang medis lengkap dan modern.',
            'Pelayanan farmasi cepat dan obat tersedia lengkap.',
            'Laboratorium bersih dan hasil pemeriksaan akurat.',
            'Radiologi modern dan prosedur pemeriksaan cepat.',
            'Poli spesialis lengkap dengan dokter ahli.',
            'Sistem informasi pasien terintegrasi dengan baik.',
            'Kebersihan rumah sakit sangat terjaga.',
            'Parkir luas dan akses mudah untuk difabel.',
            'Kantin bersih dan makanan sehat tersedia.',
            'Pelayanan administrasi cepat dan tidak ribet.',
            'Tim keamanan profesional dan membantu mengatur lalu lintas.',
            'Pelayanan ICU sangat baik dan peralatan modern.',
            'Sistem pembayaran beragam dan mudah.',
            'Pelayanan rehabilitasi sangat membantu pemulihan.',
            'Dokter spesialis sangat ahli di bidangnya.',
            'Perawat sangat sabar dalam merawat pasien lansia.',
            'Sistem rujukan berjalan dengan baik.',
            'Pelayanan vaksinasi terorganisir dengan baik.',
            'Program kesehatan masyarakat sangat bermanfaat.',
            'Tim medis selalu siaga 24 jam.',
            'Pelayanan home care sangat membantu pasien rawat jalan.',
            'Sistem informasi obat sangat lengkap.',
            'Pelayanan gizi sangat baik dan menu sehat.',
            'Fasilitas ibu dan anak sangat nyaman.',
            'Pelayanan psikologi sangat membantu.',
            'Tim bedah sangat profesional dan berpengalaman.',
            'Pelayanan fisioterapi sangat efektif.',
            'Sistem rekam medis digital sangat membantu.',
            'Pelayanan laboratorium 24 jam sangat membantu.',
            'Tim kardiologi sangat ahli dan peralatan modern.',
            'Pelayanan saraf sangat baik dan diagnosis akurat.',
            'Sistem farmasi online sangat praktis.',
            'Pelayanan THT sangat memuaskan.',
            'Tim mata sangat profesional dan peralatan canggih.',
            'Pelayanan kulit sangat baik dan hasil memuaskan.',
            'Sistem informasi kamar sangat akurat.',
            'Pelayanan darah sangat cepat dan aman.',
            'Tim paru sangat ahli dan perawatan intensif.',
            'Pelayanan orthopedi sangat baik dan pemulihan cepat.',
            'Sistem informasi jadwal dokter sangat akurat.',
            'Pelayanan urologi sangat profesional.',
        ];

        $reviews = [];
        for ($i = 0; $i < 50; $i++) {
            $reviews[] = [
                'nama' => $names[$i],
                'rating' => rand(4, 5), // Most reviews are positive (4-5 stars)
                'pesan' => $messages[$i],
                'inovasi_id' => rand(1, 50),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('reviews')->insert($reviews);

        $this->command->info('50 review records created successfully.');
    }
}