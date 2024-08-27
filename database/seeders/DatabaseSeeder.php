<?php

namespace Database\Seeders;

use App\Models\KabKota;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
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
            'password' => "123",
            "level" => "master",
            "code" => 1,
        ]);
        User::create([
            'name' => 'Kota Batam - Test (DEV)',
            'username' => 'batamdev',
            'password' => "123",
            "code" => 2171,
            "level" => "kabkota"
        ]);
        $kecamatan = [
            "batam kota" => [
                "id" => Uuid::uuid7(),
                "name" => "batam kota",
                "kabkota_id" => 2171
            ],
            "batu aji" => [
                "id" => Uuid::uuid7(),
                "name" => "batu aji",
                "kabkota_id" => 2171
            ],
            "batu ampar" => [
                "id" => Uuid::uuid7(),
                "name" => "batu ampar",
                "kabkota_id" => 2171
            ],
            "belakang padang" => [
                "id" => Uuid::uuid7(),
                "name" => "belakang padang",
                "kabkota_id" => 2171
            ],
            "bengkong" => [
                "id" => Uuid::uuid7(),
                "name" => "bengkong",
                "kabkota_id" => 2171
            ],
            "bulang" => [
                "id" => Uuid::uuid7(),
                "name" => "bulang",
                "kabkota_id" => 2171
            ],
            "galang" => [
                "id" => Uuid::uuid7(),
                "name" => "galang",
                "kabkota_id" => 2171
            ],
            "lubuk baja" => [
                "id" => Uuid::uuid7(),
                "name" => "lubuk baja",
                "kabkota_id" => 2171
            ],
            "nongsa" => [
                "id" => Uuid::uuid7(),
                "name" => "nongsa",
                "kabkota_id" => 2171
            ],
            "sagulung" => [
                "id" => Uuid::uuid7(),
                "name" => "sagulung",
                "kabkota_id" => 2171
            ],
            "sei beduk" => [
                "id" => Uuid::uuid7(),
                "name" => "sei beduk",
                "kabkota_id" => 2171
            ],
            "sekupang" => [
                "id" => Uuid::uuid7(),
                "name" => "sekupang",
                "kabkota_id" => 2171
            ],
        ];
        Kecamatan::insert($kecamatan);
        $kelurahan = [
            // Batam Kota
            ["id" => Uuid::uuid7(), "name" => "baloi permai", "kecamatan_id" => $kecamatan["batam kota"]["id"]],
            ["id" => Uuid::uuid7(), "name" => "belian", "kecamatan_id" => $kecamatan["batam kota"]["id"]],
            ["id" => Uuid::uuid7(), "name" => "sukajadi", "kecamatan_id" => $kecamatan["batam kota"]["id"]],
            ["id" => Uuid::uuid7(), "name" => "sungai panas", "kecamatan_id" => $kecamatan["batam kota"]["id"]],
            ["id" => Uuid::uuid7(), "name" => "taman baloi", "kecamatan_id" => $kecamatan["batam kota"]["id"]],
            ["id" => Uuid::uuid7(), "name" => "teluk tering", "kecamatan_id" => $kecamatan["batam kota"]["id"]],

            // Batu Aji
            ["id" => Uuid::uuid7(), "name" => "bukit tempayan", "kecamatan_id" => $kecamatan["batu aji"]["id"]],
            ["id" => Uuid::uuid7(), "name" => "buliang", "kecamatan_id" => $kecamatan["batu aji"]["id"]],
            ["id" => Uuid::uuid7(), "name" => "kibing", "kecamatan_id" => $kecamatan["batu aji"]["id"]],
            ["id" => Uuid::uuid7(), "name" => "tanjung uncang", "kecamatan_id" => $kecamatan["batu aji"]["id"]],

            // Batu Ampar
            ["id" => Uuid::uuid7(), "name" => "batu merah", "kecamatan_id" => $kecamatan["batu ampar"]["id"]],
            ["id" => Uuid::uuid7(), "name" => "kampung seraya", "kecamatan_id" => $kecamatan["batu ampar"]["id"]],
            ["id" => Uuid::uuid7(), "name" => "sungai jodoh", "kecamatan_id" => $kecamatan["batu ampar"]["id"]],
            ["id" => Uuid::uuid7(), "name" => "tanjung sengkuang", "kecamatan_id" => $kecamatan["batu ampar"]["id"]],

            // Belakang Padang
            ["id" => Uuid::uuid7(), "name" => "kasu", "kecamatan_id" => $kecamatan["belakang padang"]["id"]],
            ["id" => Uuid::uuid7(), "name" => "pecong", "kecamatan_id" => $kecamatan["belakang padang"]["id"]],
            ["id" => Uuid::uuid7(), "name" => "pemping", "kecamatan_id" => $kecamatan["belakang padang"]["id"]],
            ["id" => Uuid::uuid7(), "name" => "pulau terong", "kecamatan_id" => $kecamatan["belakang padang"]["id"]],
            ["id" => Uuid::uuid7(), "name" => "sekanak raya", "kecamatan_id" => $kecamatan["belakang padang"]["id"]],
            ["id" => Uuid::uuid7(), "name" => "tanjung sari", "kecamatan_id" => $kecamatan["belakang padang"]["id"]],

            // Bengkong
            ["id" => Uuid::uuid7(), "name" => "bengkong indah", "kecamatan_id" => $kecamatan["bengkong"]["id"]],
            ["id" => Uuid::uuid7(), "name" => "bengkong laut", "kecamatan_id" => $kecamatan["bengkong"]["id"]],
            ["id" => Uuid::uuid7(), "name" => "sadai", "kecamatan_id" => $kecamatan["bengkong"]["id"]],
            ["id" => Uuid::uuid7(), "name" => "tanjung buntung", "kecamatan_id" => $kecamatan["bengkong"]["id"]],

            // Bulang
            ["id" => Uuid::uuid7(), "name" => "batu legong", "kecamatan_id" => $kecamatan["bulang"]["id"]],
            ["id" => Uuid::uuid7(), "name" => "bulang lintang", "kecamatan_id" => $kecamatan["bulang"]["id"]],
            ["id" => Uuid::uuid7(), "name" => "pantai gelam", "kecamatan_id" => $kecamatan["bulang"]["id"]],
            ["id" => Uuid::uuid7(), "name" => "pulau buluh", "kecamatan_id" => $kecamatan["bulang"]["id"]],
            ["id" => Uuid::uuid7(), "name" => "setokok", "kecamatan_id" => $kecamatan["bulang"]["id"]],
            ["id" => Uuid::uuid7(), "name" => "temoyong", "kecamatan_id" => $kecamatan["bulang"]["id"]],

            // Galang
            ["id" => Uuid::uuid7(), "name" => "air raja", "kecamatan_id" => $kecamatan["galang"]["id"]],
            ["id" => Uuid::uuid7(), "name" => "galang baru", "kecamatan_id" => $kecamatan["galang"]["id"]],
            ["id" => Uuid::uuid7(), "name" => "karas", "kecamatan_id" => $kecamatan["galang"]["id"]],
            ["id" => Uuid::uuid7(), "name" => "pulau abang", "kecamatan_id" => $kecamatan["galang"]["id"]],
            ["id" => Uuid::uuid7(), "name" => "rempang cate", "kecamatan_id" => $kecamatan["galang"]["id"]],
            ["id" => Uuid::uuid7(), "name" => "sembulang", "kecamatan_id" => $kecamatan["galang"]["id"]],
            ["id" => Uuid::uuid7(), "name" => "sijantung", "kecamatan_id" => $kecamatan["galang"]["id"]],
            ["id" => Uuid::uuid7(), "name" => "subang mas", "kecamatan_id" => $kecamatan["galang"]["id"]],

            // Lubuk Baja
            ["id" => Uuid::uuid7(), "name" => "baloi indah", "kecamatan_id" => $kecamatan["lubuk baja"]["id"]],
            ["id" => Uuid::uuid7(), "name" => "batu selicin", "kecamatan_id" => $kecamatan["lubuk baja"]["id"]],
            ["id" => Uuid::uuid7(), "name" => "kampung pelita", "kecamatan_id" => $kecamatan["lubuk baja"]["id"]],
            ["id" => Uuid::uuid7(), "name" => "lubuk baja kota", "kecamatan_id" => $kecamatan["lubuk baja"]["id"]],
            ["id" => Uuid::uuid7(), "name" => "tanjung uma", "kecamatan_id" => $kecamatan["lubuk baja"]["id"]],

            // Nongsa
            ["id" => Uuid::uuid7(), "name" => "batu besar", "kecamatan_id" => $kecamatan["nongsa"]["id"]],
            ["id" => Uuid::uuid7(), "name" => "kabil", "kecamatan_id" => $kecamatan["nongsa"]["id"]],
            ["id" => Uuid::uuid7(), "name" => "ngenang", "kecamatan_id" => $kecamatan["nongsa"]["id"]],
            ["id" => Uuid::uuid7(), "name" => "sambau", "kecamatan_id" => $kecamatan["nongsa"]["id"]],

            // Sagulung
            ["id" => Uuid::uuid7(), "name" => "sagulung kota", "kecamatan_id" => $kecamatan["sagulung"]["id"]],
            ["id" => Uuid::uuid7(), "name" => "sungai binti", "kecamatan_id" => $kecamatan["sagulung"]["id"]],
            ["id" => Uuid::uuid7(), "name" => "sungai langkai", "kecamatan_id" => $kecamatan["sagulung"]["id"]],
            ["id" => Uuid::uuid7(), "name" => "sungai lekop", "kecamatan_id" => $kecamatan["sagulung"]["id"]],
            ["id" => Uuid::uuid7(), "name" => "sungai pelunggut", "kecamatan_id" => $kecamatan["sagulung"]["id"]],
            ["id" => Uuid::uuid7(), "name" => "tembesi", "kecamatan_id" => $kecamatan["sagulung"]["id"]],

            // Sei Beduk
            ["id" => Uuid::uuid7(), "name" => "duriangkang", "kecamatan_id" => $kecamatan["sei beduk"]["id"]],
            ["id" => Uuid::uuid7(), "name" => "mangsang", "kecamatan_id" => $kecamatan["sei beduk"]["id"]],
            ["id" => Uuid::uuid7(), "name" => "mukakuning", "kecamatan_id" => $kecamatan["sei beduk"]["id"]],
            ["id" => Uuid::uuid7(), "name" => "seipanas", "kecamatan_id" => $kecamatan["sei beduk"]["id"]],

            // Sekupang
            ["id" => Uuid::uuid7(), "name" => "patam lestari", "kecamatan_id" => $kecamatan["sekupang"]["id"]],
            ["id" => Uuid::uuid7(), "name" => "puskesmas", "kecamatan_id" => $kecamatan["sekupang"]["id"]],
            ["id" => Uuid::uuid7(), "name" => "sungai harapan", "kecamatan_id" => $kecamatan["sekupang"]["id"]],
            ["id" => Uuid::uuid7(), "name" => "tanjung pinggir", "kecamatan_id" => $kecamatan["sekupang"]["id"]],
            ["id" => Uuid::uuid7(), "name" => "tiban baru", "kecamatan_id" => $kecamatan["sekupang"]["id"]],
            ["id" => Uuid::uuid7(), "name" => "tiban indah", "kecamatan_id" => $kecamatan["sekupang"]["id"]],
            ["id" => Uuid::uuid7(), "name" => "tiban lama", "kecamatan_id" => $kecamatan["sekupang"]["id"]],
            ["id" => Uuid::uuid7(), "name" => "tiban makmur", "kecamatan_id" => $kecamatan["sekupang"]["id"]],
            ["id" => Uuid::uuid7(), "name" => "tiban sari", "kecamatan_id" => $kecamatan["sekupang"]["id"]],
            ["id" => Uuid::uuid7(), "name" => "tiban kampung", "kecamatan_id" => $kecamatan["sekupang"]["id"]],
            ["id" => Uuid::uuid7(), "name" => "tiban kampung baru", "kecamatan_id" => $kecamatan["sekupang"]["id"]],

            // Bulang
            ["id" => Uuid::uuid7(), "name" => "kampung bulang", "kecamatan_id" => $kecamatan["bulang"]["id"]],
            ["id" => Uuid::uuid7(), "name" => "kampung pinang", "kecamatan_id" => $kecamatan["bulang"]["id"]],
            ["id" => Uuid::uuid7(), "name" => "kampung panjang", "kecamatan_id" => $kecamatan["bulang"]["id"]],
            ["id" => Uuid::uuid7(), "name" => "kampung pinang panjang", "kecamatan_id" => $kecamatan["bulang"]["id"]],
        ];
        Kelurahan::insert($kelurahan);
    }
}
