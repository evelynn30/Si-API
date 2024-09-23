<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        Storage::deleteDirectory('/uploads');

        File::copyDirectory(
            public_path('dummy'),
            storage_path('app/public')
        );
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call(InsidenTableSeeder::class);
        $this->call(OpdTableSeeder::class);
        $this->call(PenemuTableSeeder::class);
        $this->call(TemuanTableSeeder::class);
        $this->call(TemuanInsidenTableSeeder::class);
        $this->call(PerihalSuratTableSeeder::class);
        $this->call(SifatSuratTableSeeder::class);
        $this->call(JenisSuratKeluarTableSeeder::class);
        $this->call(JenisSuratMasukTableSeeder::class);
        $this->call(SuratKeluarTableSeeder::class);
        $this->call(SuratKeluarOpdTableSeeder::class);
        $this->call(SuratKeluarTemuanTableSeeder::class);
        $this->call(SuratMasukTableSeeder::class);
        $this->call(SuratMasukOpdTableSeeder::class);
        $this->call(SuratMasukTerkaitKeluarTableSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}
