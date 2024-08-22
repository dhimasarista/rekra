<?php

use Ramsey\Uuid\Uuid;

// Konfigurasi utama SDUI
$config = [
    "name" => "Form Input Data", // Nama form atau judul halaman
    "button_helper" => [
        "enable" => true, // menampilkan button jika true
        "button_list" => [
            [
                "name" => "Kembali",
                "icon" => "fa fa-arrow-left",
                "route" => null, // route yang diarahkan ketika event klik
            ]
        ]
    ],
    "submit" => [
        "id" => Uuid::uuid7(), // ID unik untuk tombol submit
        "type" => "input", // Tipe submit, bisa 'input' atau 'redirect'
        "route" => "/submit-data", // Rute yang akan diakses saat submit
        "method" => "POST", // Metode HTTP yang digunakan untuk submit
        "redirect" => "/success-page", // Halaman redirect setelah submit sukses (jika ada)
        "form_data" => [ // Data yang akan dikirim pada saat submit
            [
                "id" => "inputText", // ID dari elemen input
                "name" => "nama", // Nama field yang dikirim
                "type" => "string" // Tipe data yang dikirim (string, array)
            ],
            [
                "id" => "dynamicContainer", // ID dari container elemen dynamic input
                "name" => "skills", // Nama field untuk array dynamic input
                "type" => "array" // Tipe data array karena ada banyak input
            ],
        ]
    ],
    "form" => [
        0 => [
            "id" => "selectCountry", // ID untuk elemen form
            "type" => "select", // Tipe elemen: select, text, number, notification, dynamic-input
            "name" => "Nama Negara", // Label untuk elemen form
            "is_disabled" => false, // Jika true, elemen akan disabled
            "for_submit" => true, // Jika true, elemen ini digunakan untuk submit
            "fetch_data" => [
                "is_fetching" => true, // Jika true, data akan diambil melalui AJAX
                "route" => "/fetch-states/", // Rute untuk AJAX fetch
                "response" => "states", // Key dalam respons untuk data yang diambil
                "sibling_form_id" => "selectState" // ID elemen lain yang akan diupdate berdasarkan fetch
            ],
            "options" => [ // Opsi untuk select
                [
                    "id" => 1,
                    "is_selected" => true, // Opsi yang dipilih secara default
                    "name" => "Indonesia"
                ],
                [
                    "id" => 2,
                    "is_selected" => false,
                    "name" => "Malaysia"
                ]
            ]
        ],
        1 => [
            "id" => "use uuid",
            "type" => "text",
            "name" => "Nama Lengkap",
            "is_disabled" => false,
            "for_submit" => true,
            "fetch_data" => [
                "is_fetching" => false
            ],
            "data" => [
                "placeholder" => "Masukkan nama lengkap Anda",
                "value" => null
            ]
        ],
        2 => [
            "id" => "use uuid",
            "type" => "dynamic-input",
            "name" => "Keahlian",
            "is_disabled" => false,
            "for_submit" => true,
            "button" => [
                "show" => true, // Jika true, tombol tambah input akan ditampilkan
                "id" => "addSkillButton", // ID untuk tombol tambah input
                "name" => "Tambah Keahlian" // Label untuk tombol tambah input
            ],
            "container" => [
                "id" => "skillFieldsContainer" // ID untuk container yang menampung dynamic input
            ],
            "data" => [
                "placeholder" => "Masukkan keahlian Anda",
                "value" => null
            ]
        ],
        3 => [
            "id" => "use uuid",
            "type" => "notification",
            "name" => "Data berhasil disimpan!", // Pesan notifikasi
            "is_disabled" => false,
            "for_submit" => false,
            "fetch_data" => [
                "is_fetching" => false
            ]
        ],
        4 => [
            "id" => "use uuid",
            "type" => "textarea",
            "name" => "Catatan (Tidak Wajib)",
            "fetch_data" => [
                "is_fetching" => false,
            ],
            "data" => [
                "value" => 1000 ?? null,
                "placeholder" => null,
            ],
        ]
    ]
];
?>
