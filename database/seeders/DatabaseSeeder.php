<?php

namespace Database\Seeders;

use App\Models\KabKota;
use App\Models\Provinsi;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Provinsi::insert([
            "id" => 21,
            "name" => "kepulauan riau",
        ]);

        KabKota::insert([
            [
                "id" => 2101,
                "name" => "karimun",
                "provinsi_id" => 21
            ],
            [
                "id" => 2102,
                "name" => "bintan",
                "provinsi_id" => 21
            ],
            [
                "id" => 2103,
                "name" => "natuna",
                "provinsi_id" => 21
            ],
            [
                "id" => 2104,
                "name" => "lingga",
                "provinsi_id" => 21
            ],
            [
                "id" => 2105,
                "name" => "kepulauan anambas",
                "provinsi_id" => 21
            ],
            [
                "id" => 2171,
                "name" => "kota batam",
                "provinsi_id" => 21
            ],
            [
                "id" => 2172,
                "name" => "kota tanjungpinang",
                "provinsi_id" => 21
            ],
        ]);

        User::create([
            'name' => 'Master - Test (DEV)',
            'username' => 'masterdev',
            'password' => "soliddd45",
            "level" => "master",
            "code" => 1,
        ]);
        User::create([
            'name' => 'Kota Batam - Test (DEV)',
            'username' => 'kotabatamdev',
            'password' => "soliddd45",
            "code" => 2171,
            "level" => "kabkota"
        ]);
    }
}
