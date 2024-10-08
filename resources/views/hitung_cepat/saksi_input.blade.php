<!DOCTYPE html>
<html lang="en">

<head>
    {{-- Basic Page Info --}}
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" />
    <title>Kamar Juang</title>
    {{-- Site favicon --}}
    <link rel="icon" type="image/x-icon" sizes="16x16" href="./favicon.svg" />
    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <link rel="stylesheet" type="text/css" href="../admin/vendors/styles/core.css" />
    <link rel="stylesheet" type="text/css" href="../admin/vendors/styles/icon-font.min.css" />
    <link rel="stylesheet" type="text/css" href="../admin/src/plugins/TopLoaderService/TopLoaderService.css" />

    <style>
        body {
            background: url('https://images.unsplash.com/photo-1669346861428-da971fd936d5?q=80&w=1887&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            /* color: #fff; */
            /* Mengatur warna teks menjadi putih untuk kontras dengan latar belakang */
        }

        .card {
            border: none;
            /* Menghilangkan border card */
            border-radius: 10px;
            /* Menambahkan sudut melengkung pada card */
            /* opacity: 1; */
            /* Mengatur transparansi card */
        }

        .card-body {
            padding: 2rem;
            /* Menambahkan padding yang lebih besar pada body card */
        }

        h4 {
            font-weight: bold;
            /* Menebalkan judul */
        }

        .btn-dark {
            background-color: #333;
            /* Warna latar belakang tombol */
            border: none;
            /* Menghilangkan border tombol */
        }

        .btn-dark:hover {
            background-color: #555;
            /* Mengubah warna latar belakang tombol saat hover */
        }
    </style>
</head>

<body>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="pd-20 card-box mb-30">
                    <div class="card">
                        <div class="card-body">
                            <div class="clearfix">
                                <div class="pull-left">
                                    <h4 class="text-blue h4">Hitung Cepat Saksi</h4>
                                    <p class="mb-30">Silahkan Hubungi Admin Jika Ada Kendala.</p>
                                </div>
                                <div class="pull-right">
                                    <a href="https://api.whatsapp.com/send/?phone=6285157248841&text&type=phone_number&app_absent=0"
                                        class="btn btn-dark btn-sm scroll-click" target="_blank"><i
                                            class="fa fa-info"></i>
                                        Hubungi Admin</a>
                                </div>
                            </div>
                            <form>
                                <div class="form-group">
                                    <label>Nomor Induk Kependudukan (NIK)</label>
                                    <input class="form-control" type="text" placeholder="Masukkan NIK">
                                </div>
                                <button type="submit" class="btn btn-dark btn-block">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../admin/src/plugins/TopLoaderService/TopLoaderService.js"></script>
    <script src="../admin/vendors/scripts/core.js"></script>
    <script src="../admin/vendors/scripts/script.min.js"></script>
    <script src="../admin/vendors/scripts/process.js"></script>
    <script src="../admin/vendors/scripts/layout-settings.js"></script>
    <script src="../admin/src/plugins/sweetalert2/sweetalert2.js"></script>
    <script src="../admin/js/script.js"></script>
</body>

</html>
