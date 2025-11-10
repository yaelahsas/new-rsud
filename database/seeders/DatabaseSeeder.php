<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            PoliSeeder::class,
            DokterSeeder::class,
            KategoriBeritaSeeder::class,
            InovasiSeeder::class,
            BeritaSeeder::class,
            ReviewSeeder::class,
            GaleriSeeder::class,
            PengumumanSeeder::class,
            KontakSeeder::class,
            SettingSeeder::class,
            CarouselSeeder::class,
            LogAktivitasSeeder::class,
            JadwalPoliSeeder::class,
        ]);

        // User::factory(1000)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
