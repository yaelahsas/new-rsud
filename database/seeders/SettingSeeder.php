<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            ['app_name', 'RSUD Genteng'],
            ['app_description', 'Rumah Sakit Umum Daerah Genteng - Pelayanan Kesehatan Terbaik untuk Masyarakat'],
            ['app_logo', 'logo.png'],
            ['app_favicon', 'favicon.ico'],
            ['app_address', 'Jl. Sehat No. 123, Genteng, Jawa Timur, Indonesia'],
            ['app_phone', '(0234) 123456'],
            ['app_email', 'info@rsudgenteng.com'],
            ['app_website', 'https://rsudgenteng.com'],
            ['app_facebook', 'https://facebook.com/rsudgenteng'],
            ['app_twitter', 'https://twitter.com/rsudgenteng'],
            ['app_instagram', 'https://instagram.com/rsudgenteng'],
            ['app_youtube', 'https://youtube.com/rsudgenteng'],
            ['app_linkedin', 'https://linkedin.com/rsudgenteng'],
            ['app_google_maps', 'https://maps.google.com/?q=RSUD+Genteng'],
            ['operational_hours', 'Senin - Sabtu: 07:00 - 21:00, Minggu: 08:00 - 17:00'],
            ['emergency_hours', '24 Jam'],
            ['registration_hours', 'Senin - Sabtu: 07:00 - 20:00, Minggu: 08:00 - 16:00'],
            ['pharmacy_hours', 'Senin - Sabtu: 07:00 - 21:00, Minggu: 08:00 - 17:00'],
            ['lab_hours', 'Senin - Sabtu: 07:00 - 20:00, Minggu: 08:00 - 16:00'],
            ['radiology_hours', 'Senin - Sabtu: 07:00 - 20:00, Minggu: 08:00 - 16:00'],
            ['visiting_hours', 'Senin - Sabtu: 11:00 - 13:00, 17:00 - 20:00, Minggu: 10:00 - 20:00'],
            ['icu_visiting_hours', 'Senin - Minggu: 12:00 - 13:00, 17:00 - 18:00'],
            ['nicu_visiting_hours', 'Senin - Minggu: 12:00 - 13:00, 17:00 - 18:00'],
            ['picu_visiting_hours', 'Senin - Minggu: 12:00 - 13:00, 17:00 - 18:00'],
            ['emergency_contact', '(0234) 119'],
            ['ambulance_contact', '(0234) 118'],
            ['whatsapp_number', '+6281234567890'],
            ['email_info', 'info@rsudgenteng.com'],
            ['email_complaint', 'keluhan@rsudgenteng.com'],
            ['email_suggestion', 'saran@rsudgenteng.com'],
            ['email_career', 'karir@rsudgenteng.com'],
            ['email_cooperation', 'kerjasama@rsudgenteng.com'],
            ['bank_name', 'Bank Negara Indonesia'],
            ['bank_account', '1234567890'],
            ['bank_account_name', 'RSUD Genteng'],
            ['payment_methods', 'Tunai, Debit, Kredit, Transfer, E-Wallet'],
            ['insurance_partners', 'BPJS, Asuransi A, Asuransi B, Asuransi C'],
            ['meta_title', 'RSUD Genteng - Rumah Sakit Terpercaya di Genteng'],
            ['meta_description', 'RSUD Genteng menyediakan pelayanan kesehatan terbaik dengan dokter spesialis dan fasilitas modern'],
            ['meta_keywords', 'rumah sakit, rsud, genteng, kesehatan, dokter, poli, rawat inap, igd'],
            ['google_analytics', 'UA-123456789-1'],
            ['google_tag_manager', 'GTM-XXXXXXX'],
            ['facebook_pixel', '123456789012345'],
            ['maintenance_mode', '0'],
            ['maintenance_message', 'Sedang dalam pemeliharaan. Silakan kembali beberapa saat lagi.'],
            ['max_file_upload', '10240'],
            ['allowed_file_types', 'jpg,jpeg,png,pdf,doc,docx'],
            ['pagination_limit', '10'],
            ['session_timeout', '120'],
            ['password_min_length', '8'],
            ['password_require_special', '1'],
            ['password_require_number', '1'],
            ['password_require_uppercase', '1'],
            ['backup_schedule', 'daily'],
            ['backup_retention', '30'],
            ['email_smtp_host', 'smtp.gmail.com'],
            ['email_smtp_port', '587'],
            ['email_smtp_username', 'noreply@rsudgenteng.com'],
            ['email_smtp_encryption', 'tls'],
            ['api_rate_limit', '100'],
            ['api_timeout', '30'],
            ['cache_duration', '3600'],
            ['log_retention_days', '90'],
        ];

        foreach ($settings as $setting) {
            DB::table('settings')->insert([
                'key' => $setting[0],
                'value' => $setting[1],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('50 setting records created successfully.');
    }
}