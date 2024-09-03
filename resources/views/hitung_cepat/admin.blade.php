@extends('layouts/main')
@section('body')
    @php
        $segments = request()->segments();
    @endphp
    @use('App\Helpers\Formatting')
    <div class="xs-pd-20-10 pd-ltr-20">
        <div class="title pb-20 d-flex justify-content-between align-items-center">
            <h2 class="h2 mb-0">{{ Formatting::capitalize($segments[0]) }}</h2>
            <div class="text-right">
                <a class="btn btn-sm btn-dark m-1" href="{{ route('wilayah.form', ['Type' => 'Kabkota']) }}">
                    <i class="fa fa-plus"></i> KabKota
                </a>
                <a class="btn btn-sm btn-dark m-1" href="{{ route('wilayah.form', ['Type' => 'Kecamatan']) }}">
                    <i class="fa fa-plus"></i> Kecamatan
                </a>
                <a class="btn btn-sm btn-dark m-1" href="{{ route('wilayah.form', ['Type' => 'Kelurahan']) }}">
                    <i class="fa fa-plus"></i> Kelurahan
                </a>
                <a id="tambah-tps" class="btn btn-sm btn-dark m-1" href="javascript:;">
                    <i class="fa fa-plus"></i> TPS
                </a>
            </div>
        </div>
        <div class="row pb-10">
            <div class="col-md-12 mb-20">
                <!-- Export Datatable start -->
                <div class="card-box mb-30">
                    <div class="pd-20">
                        <h4 class="text-blue h4">Hello</h4>
                    </div>
                    <div class="pb-20">
                        <table id="datatable-table" class="table hover stripe multiple-select-row data-table-export wrap">
                            <thead>
                                <tr>
                                    <th>Hello</th>
                                    <th>Hello</th>
                                    <th>Hello</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr> --}}
                            </tbody>
                        </table>
                    </div>
                    <script>
                        $("#datatable-table").DataTable({
                            "order": []
                        })
                    </script>
                </div>
                <!-- Export Datatable End -->
            </div>
            <div class="col-md-4 mb-20">

            </div>
        </div>
    </div>
    <script src="../admin/src/plugins/apexcharts/apexcharts.min.js"></script>
    <script src="../admin/vendors/scripts/dashboard3.js"></script>
@endsection
