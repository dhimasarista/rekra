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
            <div class="title pb-20 d-flex justify-content-between align-items-center">
                {{-- <h2 class="h2 mb-0">{{ Formatting::capitalize($segments[0]) }}</h2> --}}
                <div class="text-left">
                    <div class="row">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <select class="custom-select">
                                    <option selected="">Tingkatan</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    {{-- <a class="btn btn-sm btn-dark m-1" href="{{ url()->previous() }}">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a> --}}
                </div>
            </div>
            <div class="row pb-10">
                <div class="col-md-12 mb-20">
                    <!-- Export Datatable start -->
                    <div class="card-box mb-30">
                        <div class="pd-20">
                            <h4 class="text-blue h4">Hitung Cepat</h4>
                        </div>
                        <div class="pb-20">
                            <table id="datatable-table"
                                class="table hover stripe multiple-select-row data-table-export wrap">
                                <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>Login Time</th>
                                        <th>IP Address</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <script>
                        $("#datatable-table").DataTable({})
                    </script>
                    <!-- Export Datatable End -->
                </div>
                <div class="col-md-4 mb-20">

                </div>
            </div>
        </div>
    @endsection
