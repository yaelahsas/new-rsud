<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InovasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $inovasis = [
            ['Sistem Antrian Digital', 'Sistem antrian berbasis digital untuk mengurangi waktu tunggu pasien', 'inovasi_1.jpg', 'https://antri.rsudgenteng.com', 'aktif'],
            ['Telemedicine RSUD', 'Layanan konsultasi medis online untuk pasien jarak jauh', 'inovasi_2.jpg', 'https://telemed.rsudgenteng.com', 'aktif'],
            ['Mobile Health App', 'Aplikasi mobile untuk pelayanan kesehatan lengkap', 'inovasi_3.jpg', 'https://app.rsudgenteng.com', 'aktif'],
            ['AI Diagnosis Assistant', 'Sistem AI untuk membantu diagnosis medis', 'inovasi_4.jpg', 'https://ai.rsudgenteng.com', 'aktif'],
            ['Smart Hospital Room', 'Kamar pasien pintar dengan monitoring otomatis', 'inovasi_5.jpg', 'https://smart.rsudgenteng.com', 'aktif'],
            ['E-Pharmacy System', 'Sistem farmasi elektronik untuk manajemen obat', 'inovasi_6.jpg', 'https://farmasi.rsudgenteng.com', 'aktif'],
            ['Digital Medical Records', 'Rekam medis digital yang terintegrasi', 'inovasi_7.jpg', 'https://rm.rsudgenteng.com', 'aktif'],
            ['Health Analytics Platform', 'Platform analitik data kesehatan', 'inovasi_8.jpg', 'https://analytics.rsudgenteng.com', 'aktif'],
            ['Patient Portal', 'Portal pasien untuk akses informasi kesehatan', 'inovasi_9.jpg', 'https://portal.rsudgenteng.com', 'aktif'],
            ['Emergency Response System', 'Sistem respons darurat terintegrasi', 'inovasi_10.jpg', 'https://emergency.rsudgenteng.com', 'aktif'],
            ['Smart ICU Monitoring', 'Monitoring ICU berbasis IoT', 'inovasi_11.jpg', 'https://icu.rsudgenteng.com', 'aktif'],
            ['Digital Radiology', 'Sistem radiologi digital dengan AI', 'inovasi_12.jpg', 'https://radiologi.rsudgenteng.com', 'aktif'],
            ['Robotic Surgery System', 'Sistem bedah robotik untuk presisi tinggi', 'inovasi_13.jpg', 'https://robotic.rsudgenteng.com', 'aktif'],
            ['Virtual Reality Therapy', 'Terapi realitas virtual untuk rehabilitasi', 'inovasi_14.jpg', 'https://vr.rsudgenteng.com', 'aktif'],
            ['Wearable Health Monitor', 'Perangkat wearable untuk monitoring kesehatan', 'inovasi_15.jpg', 'https://wearable.rsudgenteng.com', 'aktif'],
            ['Blockchain Medical Records', 'Sistem rekam medis berbasis blockchain', 'inovasi_16.jpg', 'https://blockchain.rsudgenteng.com', 'aktif'],
            ['AI Drug Discovery', 'Platform AI untuk penemuan obat baru', 'inovasi_17.jpg', 'https://drug.rsudgenteng.com', 'aktif'],
            ['Smart Ambulance', 'Ambulance pintar dengan peralatan canggih', 'inovasi_18.jpg', 'https://ambulance.rsudgenteng.com', 'aktif'],
            ['Digital Pathology', 'Sistem patologi digital dengan AI', 'inovasi_19.jpg', 'https://pathology.rsudgenteng.com', 'aktif'],
            ['Health Chatbot', 'Chatbot AI untuk konsultasi kesehatan awal', 'inovasi_20.jpg', 'https://chatbot.rsudgenteng.com', 'aktif'],
            ['Predictive Analytics', 'Sistem prediksi penyakit berbasis AI', 'inovasi_21.jpg', 'https://predict.rsudgenteng.com', 'aktif'],
            ['Smart Lab System', 'Laboratorium pintar dengan otomasi', 'inovasi_22.jpg', 'https://lab.rsudgenteng.com', 'aktif'],
            ['Digital Pharmacy', 'Farmasi digital dengan manajemen otomatis', 'inovasi_23.jpg', 'https://digital-pharmacy.rsudgenteng.com', 'aktif'],
            ['AI Triage System', 'Sistem triage otomatis berbasis AI', 'inovasi_24.jpg', 'https://triage.rsudgenteng.com', 'aktif'],
            ['Virtual Consultation', 'Konsultasi virtual dengan dokter spesialis', 'inovasi_25.jpg', 'https://virtual.rsudgenteng.com', 'aktif'],
            ['Smart Ward Management', 'Manajemen ruang rawat inap pintar', 'inovasi_26.jpg', 'https://ward.rsudgenteng.com', 'aktif'],
            ['Digital Surgery Planning', 'Perencanaan bedah digital 3D', 'inovasi_27.jpg', 'https://surgery.rsudgenteng.com', 'aktif'],
            ['AI Medical Imaging', 'Analisis citra medis dengan AI', 'inovasi_28.jpg', 'https://imaging.rsudgenteng.com', 'aktif'],
            ['Smart Blood Bank', 'Bank darah pintar dengan tracking digital', 'inovasi_29.jpg', 'https://blood.rsudgenteng.com', 'aktif'],
            ['Digital Rehabilitation', 'Rehabilitasi digital dengan monitoring real-time', 'inovasi_30.jpg', 'https://rehab.rsudgenteng.com', 'aktif'],
            ['AI Mental Health', 'Platform AI untuk kesehatan mental', 'inovasi_31.jpg', 'https://mental.rsudgenteng.com', 'aktif'],
            ['Smart Nutrition', 'Sistem nutrisi pintar berbasis AI', 'inovasi_32.jpg', 'https://nutrition.rsudgenteng.com', 'aktif'],
            ['Digital Vaccination', 'Sistem vaksinasi digital dengan tracking', 'inovasi_33.jpg', 'https://vaccine.rsudgenteng.com', 'aktif'],
            ['AI Emergency Response', 'Respons darurat dengan AI dan IoT', 'inovasi_34.jpg', 'https://emergency-ai.rsudgenteng.com', 'aktif'],
            ['Smart Patient Monitoring', 'Monitoring pasien pintar real-time', 'inovasi_35.jpg', 'https://monitor.rsudgenteng.com', 'aktif'],
            ['Digital Health Education', 'Platform edukasi kesehatan digital', 'inovasi_36.jpg', 'https://edu.rsudgenteng.com', 'aktif'],
            ['AI Disease Prevention', 'Sistem AI untuk pencegahan penyakit', 'inovasi_37.jpg', 'https://prevention.rsudgenteng.com', 'aktif'],
            ['Smart Medical Devices', 'Perangkat medis pintar terintegrasi', 'inovasi_38.jpg', 'https://devices.rsudgenteng.com', 'aktif'],
            ['Digital Health Records', 'Rekam kesehatan digital terenkripsi', 'inovasi_39.jpg', 'https://health-records.rsudgenteng.com', 'aktif'],
            ['AI Medical Research', 'Platform AI untuk penelitian medis', 'inovasi_40.jpg', 'https://research.rsudgenteng.com', 'aktif'],
            ['Smart Hospital Management', 'Manajemen rumah sakit pintar terintegrasi', 'inovasi_41.jpg', 'https://management.rsudgenteng.com', 'aktif'],
            ['Digital Patient Care', 'Perawatan pasien digital holistik', 'inovasi_42.jpg', 'https://care.rsudgenteng.com', 'aktif'],
            ['AI Health Screening', 'Screening kesehatan dengan AI', 'inovasi_43.jpg', 'https://screening.rsudgenteng.com', 'aktif'],
            ['Smart Medical Training', 'Pelatihan medis dengan simulasi digital', 'inovasi_44.jpg', 'https://training.rsudgenteng.com', 'aktif'],
            ['Digital Health Insurance', 'Asuransi kesehatan digital terintegrasi', 'inovasi_45.jpg', 'https://insurance.rsudgenteng.com', 'aktif'],
            ['AI Health Assistant', 'Asisten kesehatan pribadi berbasis AI', 'inovasi_46.jpg', 'https://assistant.rsudgenteng.com', 'aktif'],
            ['Smart Emergency Care', 'Perawatan darurat pintar terintegrasi', 'inovasi_47.jpg', 'https://emergency-care.rsudgenteng.com', 'aktif'],
            ['Digital Health Monitoring', 'Monitoring kesehatan digital 24/7', 'inovasi_48.jpg', 'https://health-monitor.rsudgenteng.com', 'aktif'],
            ['AI Medical Diagnosis', 'Diagnosis medis dengan AI presisi', 'inovasi_49.jpg', 'https://diagnosis.rsudgenteng.com', 'aktif'],
            ['Smart Health Platform', 'Platform kesehatan pintar terintegrasi', 'inovasi_50.jpg', 'https://health-platform.rsudgenteng.com', 'aktif'],
        ];

        foreach ($inovasis as $inovasi) {
            DB::table('inovasis')->insert([
                'nama_inovasi' => $inovasi[0],
                'slug' => Str::slug($inovasi[0]),
                'deskripsi' => $inovasi[1],
                'gambar' => $inovasi[2],
                'link' => $inovasi[3],
                'status' => $inovasi[4],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('50 inovasi records created successfully.');
    }
}