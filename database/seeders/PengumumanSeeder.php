<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PengumumanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pengumuman = [
            ['Libur Idul Fitri 1445 H', 'RSUD Genteng akan libur pada tanggal 10-12 April 2024. Layanan gawat darurat tetap buka 24 jam.', 'libur_idulfitri.jpg', '2024-04-08', '2024-04-15', true],
            ['Vaksinasi COVID-19 Dosis Booster', 'Vaksinasi booster tersedia untuk semua warga yang telah memenuhi syarat. Daftar online sekarang!', 'vaksinasi_booster.jpg', '2024-03-01', '2024-12-31', true],
            ['Pembukaan Poli Geriatri Baru', 'RSUD Genteng membuka poli spesialis geriatri untuk pelayanan kesehatan lansia.', 'poli_geriatri.jpg', '2024-02-15', '2024-06-30', true],
            ['Program Donor Darah Bulanan', 'Donor darah rutin setiap tanggal 20. Mari berbagi darah, selamatkan nyawa!', 'donor_darah.jpg', '2024-01-01', '2024-12-31', true],
            ['Peluncuran Aplikasi Mobile', 'Aplikasi RSUD Genteng kini tersedia di Play Store dan App Store.', 'aplikasi_mobile.jpg', '2024-01-10', '2024-12-31', true],
            ['Seminar Sehat Jantung', 'Seminar gratis sehat jantung bersama dr. Ahmad Wijaya. Daftar sekarang!', 'seminar_jantung.jpg', '2024-03-20', '2024-03-25', true],
            ['Pengumuman Jadwal Libur Nasional', 'Penyesuaian jadwal layanan selama libur nasional. Layanan darurat tetap buka.', 'libur_nasional.jpg', '2024-04-01', '2024-12-31', true],
            ['Program Cek Kesehatan Gratis', 'Cek kesehatan gratis untuk lansia setiap hari Sabtu. Syarat: KTP dan KK.', 'cek_kesehatan.jpg', '2024-02-01', '2024-12-31', true],
            ['Pembukaan Layanan Home Care', 'Layanan home care untuk pasien yang membutuhkan perawatan di rumah.', 'home_care.jpg', '2024-01-15', '2024-12-31', true],
            ['Workshop Diabetes Melitus', 'Workshop gratis manajemen diabetes untuk pasien dan keluarga.', 'workshop_diabetes.jpg', '2024-03-10', '2024-03-15', true],
            ['Pengumuman Biaya Pelayanan', 'Update biaya pelayanan kesehatan RSUD Genteng mulai 1 Maret 2024.', 'biaya_pelayanan.jpg', '2024-02-20', '2024-06-30', true],
            ['Program Vaksinasi Anak', 'Vaksinasi anak gratis sesuai jadwal imunisasi nasional.', 'vaksinasi_anak.jpg', '2024-01-01', '2024-12-31', true],
            ['Pelatihan Bantuan Hidup Dasar', 'Pelatihan BHD gratis untuk masyarakat umum. Terbatas 30 peserta.', 'bhd_training.jpg', '2024-04-05', '2024-04-10', true],
            ['Pengumuman Jam Kunjung Pasien', 'Update jam kunjung pasien rawat inap RSUD Genteng.', 'jam_kunjung.jpg', '2024-02-10', '2024-12-31', true],
            ['Seminar Kesehatan Mental', 'Seminar gratis kesehatan mental di era digital. Daftar sekarang!', 'seminar_mental.jpg', '2024-03-25', '2024-03-30', true],
            ['Program Deteksi Dini Kanker', 'Program deteksi dini kanker serviks dan payudara dengan harga khusus.', 'deteksi_kanker.jpg', '2024-02-05', '2024-12-31', true],
            ['Pengumuman Sistem Antrian Baru', 'RSUD Genteng menggunakan sistem antrian digital untuk kenyamanan pasien.', 'sistem_antrian.jpg', '2024-01-20', '2024-12-31', true],
            ['Workshop Kesehatan Reproduksi', 'Workshop kesehatan reproduksi untuk remaja. Gratis dan terbatas.', 'workshop_reproduksi.jpg', '2024-04-15', '2024-04-20', true],
            ['Program Vaksinasi HPV', 'Vaksinasi HPV untuk remaja putri dengan harga terjangkau.', 'vaksinasi_hpv.jpg', '2024-03-01', '2024-12-31', true],
            ['Pengumuman Layanan Telemedicine', 'Layanan konsultasi online kini tersedia untuk beberapa poli spesialis.', 'telemedicine.jpg', '2024-02-15', '2024-12-31', true],
            ['Seminar Nutrisi Seimbang', 'Seminar gratis nutrisi seimbang untuk keluarga sehat.', 'seminar_nutrisi.jpg', '2024-04-10', '2024-04-15', true],
            ['Program Cek Kolesterol Gratis', 'Cek kolesterol gratis setiap hari Minggu pagi.', 'cek_kolesterol.jpg', '2024-03-05', '2024-12-31', true],
            ['Pengumuman Jam Operasional Farmasi', 'Update jam operasional farmasi RSUD Genteng.', 'jam_farmasi.jpg', '2024-02-25', '2024-12-31', true],
            ['Workshop Manajemen Stres', 'Workshop gratis manajemen stres untuk tenaga medis.', 'workshop_stres.jpg', '2024-04-20', '2024-04-25', true],
            ['Program Vaksinasi Influenza', 'Vaksinasi influenza untuk lansia dan penderita penyakit kronis.', 'vaksinasi_influenza.jpg', '2024-03-15', '2024-12-31', true],
            ['Pengumuman Layanan Laboratorium', 'Layanan laboratorium 24 jam untuk pemeriksaan darah dan urine.', 'lab_24jam.jpg', '2024-03-01', '2024-12-31', true],
            ['Seminar Kesehatan Tulang', 'Seminar gratis kesehatan tulang dan sendi bersama dr. Lisa Permata.', 'seminar_tulang.jpg', '2024-04-25', '2024-04-30', true],
            ['Program Cek Gula Darah Gratis', 'Cek gula darah gratis setiap hari Sabtu pagi.', 'cek_gula.jpg', '2024-03-10', '2024-12-31', true],
            ['Pengumuman Biaya Rawat Inap', 'Update biaya rawat inap kelas VIP dan kelas 1.', 'biaya_rawat_inap.jpg', '2024-03-05', '2024-06-30', true],
            ['Workshop Kesehatan Lansia', 'Workshop gratis kesehatan lansia bersama tim geriatri.', 'workshop_lansia.jpg', '2024-05-01', '2024-05-05', true],
            ['Program Vaksinasi Pneumonia', 'Vaksinasi pneumonia untuk lansia dengan harga khusus.', 'vaksinasi_pneumonia.jpg', '2024-04-01', '2024-12-31', true],
            ['Pengumuman Layanan ICU', 'Layanan ICU dengan peralatan modern dan tim ahli 24 jam.', 'layanan_icu.jpg', '2024-03-20', '2024-12-31', true],
            ['Seminar Kesehatan Paru', 'Seminar gratis kesehatan paru-paru bersama dr. Julia Rahmawati.', 'seminar_paru.jpg', '2024-05-05', '2024-05-10', true],
            ['Program Cek Tekanan Darah Gratis', 'Cek tekanan darah gratis setiap hari kerja.', 'cek_tekanan.jpg', '2024-03-15', '2024-12-31', true],
            ['Pengumuman Jam Kunjung ICU', 'Update jam kunjung pasien di ruang ICU.', 'jam_kunjung_icu.jpg', '2024-03-25', '2024-12-31', true],
            ['Workshop Kesehatan Jantung', 'Workshop gratis kesehatan jantung bersama tim kardiologi.', 'workshop_jantung.jpg', '2024-05-10', '2024-05-15', true],
            ['Program Vaksinasi Demam Berdarah', 'Vaksinasi demam berdarah untuk semua usia.', 'vaksinasi_dbd.jpg', '2024-04-15', '2024-12-31', true],
            ['Pengumuman Layanan Hemodialisa', 'Layanan hemodialisa 24 jam dengan peralatan modern.', 'hemodialisa_24jam.jpg', '2024-04-01', '2024-12-31', true],
            ['Seminar Kesehatan Mata', 'Seminar gratis kesehatan mata bersama dr. Fitri Handayani.', 'seminar_mata.jpg', '2024-05-15', '2024-05-20', true],
            ['Program Cek Mata Gratis', 'Cek mata gratis setiap hari Minggu pagi.', 'cek_mata.jpg', '2024-04-20', '2024-12-31', true],
            ['Pengumuman Biaya Operasi', 'Update biaya operasi untuk berbagai tindakan bedah.', 'biaya_operasi.jpg', '2024-04-10', '2024-06-30', true],
            ['Workshop Kesehatan Gigi', 'Workshop gratis kesehatan gigi dan mulut bersama tim gigi.', 'workshop_gigi.jpg', '2024-05-20', '2024-05-25', true],
            ['Program Vaksinasi Hepatitis', 'Vaksinasi hepatitis A dan B untuk semua usia.', 'vaksinasi_hepatitis.jpg', '2024-05-01', '2024-12-31', true],
            ['Pengumuman Layanan Fisioterapi', 'Layanan fisioterapi modern dengan peralatan lengkap.', 'layanan_fisio.jpg', '2024-04-25', '2024-12-31', true],
            ['Seminar Kesehatan Kulit', 'Seminar gratis kesehatan kulit bersama dr. Kevin Pratama.', 'seminar_kulit.jpg', '2024-05-25', '2024-05-30', true],
            ['Program Cek Kulit Gratis', 'Cek kesehatan kulit gratis setiap hari Sabtu.', 'cek_kulit.jpg', '2024-05-05', '2024-12-31', true],
            ['Pengumuman Sistem Pendaftaran Online', 'Pendaftaran online kini tersedia untuk semua poli.', 'pendaftaran_online.jpg', '2024-05-10', '2024-12-31', true],
        ];

        foreach ($pengumuman as $item) {
            DB::table('pengumuman')->insert([
                'judul' => $item[0],
                'isi' => $item[1],
                'gambar' => $item[2],
                'tanggal_mulai' => $item[3],
                'tanggal_selesai' => $item[4],
                'aktif' => $item[5],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('50 pengumuman records created successfully.');
    }
}