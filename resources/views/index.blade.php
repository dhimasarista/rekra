@extends('layouts/main')
@section('body')
@use('App\Helpers\Formatting')
<link rel="stylesheet" type="text/css" href="../admin/src/plugins/plyr/dist/plyr.css">
    <div class="xs-pd-20-10 pd-ltr-20">
        <div class="title pb-20 d-flex justify-content-between align-items-center">
            <div class="text-right">
            </div>
        </div>
        <div class="card-box pd-20 height-100-p mb-30">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <img src="../admin/vendors/images/banner-img.png" alt="">
                </div>
                <div class="col-md-8">
                    <h4 class="font-20 weight-500 mb-10 text-capitalize">
                        Selamat Datang <div class="weight-600 font-30 text-blue">{{ session()->get('name') }}!</div>
                    </h4>
                    <p class="font-18 max-width-800">Pilih menu sidebar yang ada disebelah kiri, untuk melihat hasil hitung cepat (Admin/Saksi), pilih <b>Rekap Hitung Cepat</b> dan <b>Hitung Cepat (Saksi)</b> untuk mengatur perhitungan suara cepat yang dilakukan oleh saksi. <b>Hitung Cepat (Admin)</b> adalah menu untuk melakukan perhitungan suara cepat yang dapat dilakukan oleh user melalui operator yang akan menginput data suara. Sedangkan menu <b>Input Suara, Rekap Provinsi/KabKota</b> digunakan dalam menginput data suara lengkap dengan data-data yang ada di C-Hasil (C1), Terimakasih.</p>
                </div>
            </div>
            <div class="pb-20">
                <table width="100%" id="datatable-table" class="table hover stripe multiple-select-row data-table-export wrap">
                    <thead class="text-center">
                        <tr>
                            <th>Pasangan Calon</th>
                            <th>Kode Pemilihan</th>
                            <th>Tingkat Pemilihan</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                            @if ($calon)
                                @foreach ($calon as $c)
                                    <tr>
                                        <td>{{ Formatting::capitalize("$c->calon_name & $c->wakil_name") }}</td>
                                        <td class="d-flex justify-content-center">
                                            {{ $c->code }}
                                        </td>
                                        <td>
                                            {{ Formatting::capitalize($c->level) }}
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                    </tbody>
                </table>
            </div>
        </div>
        <script>
            $("#datatable-table").DataTable({
                "order": [],
                "scrollX": true,
            });
        </script>
        {{-- <div class="row">
            <div class="col-md-12">
                <div class="container mb-30">
                    <div data-type="youtube" data-video-id="d1DndVz9dAs"></div>
                </div>
            </div>
        </div> --}}
    </div>

    <script src="../admin/src/plugins/plyr/dist/plyr.js"></script>
    <script>
		plyr.setup({
			tooltips: {
				controls: !0
			},
		});
	</script>
@endsection
