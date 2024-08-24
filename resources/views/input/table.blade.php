@extends('layouts/main')
@section('body')
    <div class="xs-pd-20-10 pd-ltr-20">
        <div class="title pb-20 d-flex justify-content-between align-items-center">
            <h2 class="h2 mb-0">List</h2>
            <div class="text-right">
                <a class="btn btn-sm btn-dark" href="{{ route("input.index") }}">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
        <div class="row pb-10">
            <div class="col-md-12 mb-20">
                <!-- Export Datatable start -->
                <div class="card-box mb-30">
                    <div class="pd-20">
                        <h4 class="text-blue h4">Daftar TPS</h4>
                    </div>
                    @use('App\Helpers\Formatting')
                    <div class="pb-20">
                        <table id="init-table" class="table hover stripe multiple-select-row data-table-export wrap">
                            <thead>
                                <tr>
                                    <th>Nama TPS</th>
                                    <th>Wilayah</th>
                                    <th>Input</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $d)
                                    <tr>
                                        <td>{{ $d->name }}</td>
                                        <td>{{ Formatting::capitalize("$d->kelurahan_name, $d->kecamatan_name, $d->kabkota_name") }}</td>
                                        <td>
                                            <div class="m-10">
                                                <a class="btn btn-sm btn-dark m-1" href="#">
                                                    <i class="fa fa-plus"></i> Provinsi
                                                </a>
                                                <a class="btn btn-sm btn-dark m-1" href="#">
                                                    <i class="fa fa-plus"></i> Kab/Kota
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <script>

                        </script>
                    </div>
                </div>
                <script>
                    $("#init-table").DataTable({
                        "order": []
                    })
                </script>
                <!-- Export Datatable End -->
            </div>
            <div class="col-md-4 mb-20">

            </div>
        </div>
    </div>
    <script src="../admin/src/plugins/apexcharts/apexcharts.min.js"></script>
    <script src="../admin/vendors/scripts/dashboard3.js"></script>
@endsection
