<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class BeritaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get admin user for created_by field
        $adminUser = User::where('email', 'admin@rsudgenteng.com')->first();
        
        $beritaTitles = [
            'RSUD Genteng Meluncurkan Layanan Telemedicine',
            'Vaksinasi COVID-19 Dosis Booster Tersedia',
            'Seminar Sehat Jantung Bersama Dr. Ahmad Wijaya',
            'Pembukaan Poli Spesialis Baru: Poli Geriatri',
            'Program Donor Darah Bulanan Juni 2024',
            'Peluncuran Aplikasi Pendaftaran Online RSUD',
            'Workshop Manajemen Diabetes Melitus',
            'Pengumuman Jadwal Libur Idul Fitri 2024',
            'RSUD Genteng Raih Predikat Rumah Sakit Terbaik',
            'Kampanye Stop Rokok di Lingkungan RS',
            'Pelatihan Bantuan Hidup Dasar untuk Masyarakat',
            'Pemeriksaan Kesehatan Gratis untuk Lansia',
            'Seminar Kesehatan Mental di Era Digital',
            'RSUD Genteng Jadi Tuan Rumah Konferensi Medis',
            'Program Vaksinasi Anak Sekolah Gratis',
            'Peluncuran Layanan ICU Modern',
            'Workshop Kesehatan Reproduksi Remaja',
            'RSUD Genteng Terima Penghargaan Pelayanan Prima',
            'Seminar Nutrisi Seimbang untuk Keluarga',
            'Program Deteksi Dini Kanker Serviks',
            'Pelatihan Keselamatan Pasien Rumah Sakit',
            'RSUD Genteng Buka Layanan Hemodialisa 24 Jam',
            'Seminar Kesehatan Tulang dan Sendi',
            'Program Cek Kesehatan Gratis untuk Guru',
            'RSUD Genteng Jadi Pusat Rujukan COVID-19',
            'Workshop Manajemen Laktasi untuk Ibu Menyusui',
            'Peluncuran Program Home Care Service',
            'Seminar Kesehatan Gigi Anak',
            'RSUD Genteng Terima Akreditasi SNARS',
            'Program Vaksinasi HPV untuk Remaja Putri',
            'Workshop Kesehatan Pekerja',
            'RSUD Genteng Buka Layanan Fisioterapi Baru',
            'Seminar Kesehatan Paru-Paru',
            'Program Cek Kolesterol Gratis',
            'RSUD Genteng Jadi Tuan Rumah Olimpiade Medis',
            'Workshop Manajemen Stres untuk Tenaga Medis',
            'Program Vaksinasi Influenza Musiman',
            'Seminar Kesehatan Mata Anak',
            'RSUD Genteng Buka Layanan THT Modern',
            'Program Deteksi Dini Hepatitis',
            'Workshop Kesehatan Lansia',
            'RSUD Genteng Terima Bantuan Alat Medis',
            'Seminar Kesehatan Jantung Anak',
            'Program Vaksinasi Pneumonia untuk Lansia',
            'RSUD Genteng Buka Layanan Laboratorium 24 Jam',
            'Workshop Kesehatan Reproduksi Pria',
            'Program Cek Gula Darah Gratis',
            'RSUD Genteng Jadi Pusat Rujukan Stroke',
            'Seminar Kesehatan Kulit',
            'Program Vaksinasi Demam Berdarah',
            'RSUD Genteng Buka Layanan Radiologi Digital',
        ];

        $beritaContents = [
            'RSUD Genteng dengan bangga mengumumkan peluncuran layanan telemedicine yang memungkinkan pasien untuk berkonsultasi dengan dokter secara online. Layanan ini dirancang untuk meningkatkan aksesibilitas pelayanan kesehatan bagi masyarakat, terutama di masa pandemi. Pasien dapat melakukan konsultasi video dengan dokter spesialis dari rumah mereka.',
            'Dalam upaya meningkatkan kekebalan komunitas, RSUD Genteng kembali menyediakan vaksinasi COVID-19 dosis booster. Vaksin tersedia untuk semua warga yang telah memenuhi syarat. Pendaftaran dapat dilakukan secara online atau datang langsung ke lokasi vaksinasi di RSUD Genteng.',
            'RSUD Genteng akan mengadakan seminar sehat jantung bersama Dr. Ahmad Wijaya, Sp.PD-KKV. Seminar ini akan membahas berbagai aspek kesehatan jantung, mulai dari pencegahan hingga pengobatan. Acara akan dilaksanakan pada tanggal 15 Juni 2024 di Auditorium RSUD Genteng.',
            'RSUD Genteng secara resmi membuka poli spesialis baru, yaitu Poli Geriatri yang fokus pada pelayanan kesehatan untuk lansia. Poli ini dilengkapi dengan fasilitas modern dan tenaga medis yang berpengalaman dalam menangani berbagai masalah kesehatan lansia.',
            'RSUD Genteng akan mengadakan program donor darah bulanan pada tanggal 20 Juni 2024. Kegiatan ini bekerja sama dengan PMI dan terbuka untuk umum. Donor darah adalah cara sederhana untuk menyelamatkan nyawa dan membantu pasien yang membutuhkan transfusi darah.',
            'RSUD Genteng meluncurkan aplikasi pendaftaran online yang memungkinkan pasien untuk mendaftar konsultasi dari rumah. Aplikasi ini tersedia untuk Android dan iOS, serta dapat diakses melalui website. Pasien dapat memilih dokter, poli, dan jadwal yang diinginkan.',
            'RSUD Genteng akan mengadakan workshop manajemen diabetes melitus pada tanggal 25 Juni 2024. Workshop ini ditujukan untuk pasien diabetes dan keluarga, serta tenaga medis yang ingin meningkatkan pengetahuan tentang manajemen diabetes.',
            'Dalam rangka menyambut Idul Fitri 1445 H, RSUD Genteng mengumumkan jadwal libur dan penyesuaian layanan. Layanan gawat darurat akan tetap beroperasi 24 jam, sementara poli rawat jalan akan libur pada tanggal 10-12 April 2024.',
            'RSUD Genteng berhasil meraih predikat Rumah Sakit Terbaik kategori Rumah Sakit Tipe C tingkat nasional. Penghargaan ini diberikan berdasarkan penilaian kualitas pelayanan, manajemen, dan inovasi yang dilakukan oleh rumah sakit.',
            'RSUD Genteng menggelar kampanye stop rokok di lingkungan rumah sakit. Kampanye ini bertujuan untuk menciptakan lingkungan yang bebas rokok dan meningkatkan kesadaran tentang bahaya merokok bagi kesehatan.',
        ];

        foreach ($beritaTitles as $index => $title) {
            $contentIndex = $index % count($beritaContents);
            $publish = rand(0, 10) > 2; // 80% chance of being published
            $tanggalPublish = $publish ? date('Y-m-d', strtotime('-'.rand(0, 365).' days')) : null;
            
            DB::table('beritas')->insert([
                'judul' => $title,
                'slug' => Str::slug($title),
                'kategori_id' => rand(1, 50),
                'isi' => $beritaContents[$contentIndex],
                'thumbnail' => 'berita_' . ($index + 1) . '.jpg',
                'created_by' => $adminUser ? $adminUser->id : null,
                'publish' => $publish,
                'tanggal_publish' => $tanggalPublish,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('50 berita records created successfully.');
    }
}