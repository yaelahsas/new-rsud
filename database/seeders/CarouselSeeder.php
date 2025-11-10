<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CarouselSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $carousels = [
            ['RSUD Genteng - Pelayanan Terbaik', 'Menyediakan pelayanan kesehatan terbaik dengan dokter spesialis dan fasilitas modern', 'carousel_1.jpg', '/layanan', 1, true],
            ['Layanan Telemedicine', 'Konsultasi dengan dokter spesialis dari rumah Anda', 'carousel_2.jpg', '/telemedicine', 2, true],
            ['Vaksinasi COVID-19', 'Vaksinasi lengkap untuk semua usia', 'carousel_3.jpg', '/vaksinasi', 3, true],
            ['Poli Spesialis', 'Poli spesialis lengkap dengan dokter ahli', 'carousel_4.jpg', '/poli', 4, true],
            ['Fasilitas Modern', 'Fasilitas medis modern dan canggih', 'carousel_5.jpg', '/fasilitas', 5, true],
            ['ICU 24 Jam', 'Unit perawatan intensif dengan peralatan lengkap', 'carousel_6.jpg', '/icu', 6, true],
            ['Laboratorium', 'Laboratorium modern dengan hasil akurat', 'carousel_7.jpg', '/lab', 7, true],
            ['Radiologi Digital', 'Pemeriksaan radiologi dengan teknologi digital', 'carousel_8.jpg', '/radiologi', 8, true],
            ['Farmasi 24 Jam', 'Layanan farmasi siaga 24 jam', 'carousel_9.jpg', '/farmasi', 9, true],
            ['Ambulance', 'Layanan ambulance cepat tanggap', 'carousel_10.jpg', '/ambulance', 10, true],
            ['Rawat Inap Nyaman', 'Ruang rawat inap yang nyaman dan bersih', 'carousel_11.jpg', '/rawat-inap', 11, true],
            ['Ruang Bersalin', 'Ruang bersalin modern dan nyaman', 'carousel_12.jpg', '/bersalin', 13, true],
            ['NICU', 'Unit perawatan intensif neonatal', 'carousel_13.jpg', '/nicu', 14, true],
            ['PICU', 'Unit perawatan intensif anak', 'carousel_14.jpg', '/picu', 15, true],
            ['Hemodialisa', 'Layanan cuci darah dengan peralatan modern', 'carousel_15.jpg', '/hemodialisa', 16, true],
            ['Fisioterapi', 'Layanan fisioterapi untuk pemulihan', 'carousel_16.jpg', '/fisioterapi', 17, true],
            ['Poli Gigi', 'Pelayanan kesehatan gigi dan mulut', 'carousel_17.jpg', '/poli-gigi', 18, true],
            ['Poli Anak', 'Pelayanan kesehatan anak yang ramah', 'carousel_18.jpg', '/poli-anak', 19, true],
            ['Poli Kandungan', 'Pelayanan kesehatan ibu dan anak', 'carousel_19.jpg', '/poli-kandungan', 20, true],
            ['Poli Jantung', 'Pelayanan kesehatan jantung spesialis', 'carousel_20.jpg', '/poli-jantung', 21, true],
            ['Poli Mata', 'Pelayanan kesehatan mata modern', 'carousel_21.jpg', '/poli-mata', 22, true],
            ['Poli THT', 'Pelayanan Telinga, Hidung, dan Tenggorokan', 'carousel_22.jpg', '/poli-tht', 23, true],
            ['Poli Saraf', 'Pelayanan kesehatan sistem saraf', 'carousel_23.jpg', '/poli-saraf', 24, true],
            ['Poli Paru', 'Pelayanan kesehatan paru-paru', 'carousel_24.jpg', '/poli-paru', 25, true],
            ['Poli Kulit', 'Pelayanan kesehatan kulit dan kelamin', 'carousel_25.jpg', '/poli-kulit', 26, true],
            ['Poli Orthopedi', 'Pelayanan kesehatan tulang dan sendi', 'carousel_26.jpg', '/poli-orthopedi', 27, true],
            ['Poli Urologi', 'Pelayanan kesehatan saluran kemih', 'carousel_27.jpg', '/poli-urologi', 28, true],
            ['Poli Psikiatri', 'Pelayanan kesehatan jiwa', 'carousel_28.jpg', '/poli-psikiatri', 29, true],
            ['Poli Geriatri', 'Pelayanan kesehatan lansia', 'carousel_29.jpg', '/poli-geriatri', 30, true],
            ['Medical Check Up', 'Paket pemeriksaan kesehatan lengkap', 'carousel_30.jpg', '/mcu', 31, true],
            ['Home Care', 'Layanan perawatan di rumah', 'carousel_31.jpg', '/home-care', 32, true],
            ['Donor Darah', 'Program donor darah rutin', 'carousel_32.jpg', '/donor-darah', 33, true],
            ['Seminar Kesehatan', 'Seminar kesehatan gratis', 'carousel_33.jpg', '/seminar', 34, true],
            ['Workshop Medis', 'Workshop untuk tenaga medis', 'carousel_34.jpg', '/workshop', 35, true],
            ['Pelatihan BHD', 'Pelatihan bantuan hidup dasar', 'carousel_35.jpg', '/bhd', 36, true],
            ['Sosialisasi Kesehatan', 'Sosialisasi kesehatan masyarakat', 'carousel_36.jpg', '/sosialisasi', 37, true],
            ['Kerjasama', 'Program kerjasama institusi', 'carousel_37.jpg', '/kerjasama', 38, true],
            ['Penelitian', 'Program penelitian medis', 'carousel_38.jpg', '/penelitian', 39, true],
            ['Pendidikan', 'Program pendidikan medis', 'carousel_39.jpg', '/pendidikan', 40, true],
            ['Penghargaan', 'Penghargaan dan prestasi', 'carousel_40.jpg', '/penghargaan', 41, true],
            ['Akreditasi', 'Proses akreditasi rumah sakit', 'carousel_41.jpg', '/akreditasi', 42, true],
            ['Inovasi', 'Program inovasi pelayanan', 'carousel_42.jpg', '/inovasi', 43, true],
            ['Teknologi Medis', 'Teknologi medis terkini', 'carousel_43.jpg', '/teknologi', 44, true],
            ['Kualitas Pelayanan', 'Komitmen kualitas pelayanan', 'carousel_44.jpg', '/kualitas', 45, true],
            ['Keselamatan Pasien', 'Program keselamatan pasien', 'carousel_45.jpg', '/keselamatan', 46, true],
            ['Kepuasan Pasien', 'Survey kepuasan pasien', 'carousel_46.jpg', '/kepuasan', 47, true],
            ['Testimoni', 'Testimoni pasien', 'carousel_47.jpg', '/testimoni', 48, true],
            ['Karir', 'Karir di RSUD Genteng', 'carousel_48.jpg', '/karir', 49, true],
            ['Volunteer', 'Program volunteer', 'carousel_49.jpg', '/volunteer', 50, true],
            ['Donasi', 'Program donasi', 'carousel_50.jpg', '/donasi', 51, true],
        ];

        foreach ($carousels as $carousel) {
            DB::table('carousels')->insert([
                'judul' => $carousel[0],
                'deskripsi' => $carousel[1],
                'gambar' => $carousel[2],
                'link' => $carousel[3],
                'urutan' => $carousel[4],
                'aktif' => $carousel[5],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('50 carousel records created successfully.');
    }
}