@extends('layouts/main')
@section('body')
    @php
        $segments = request()->segments();
    @endphp
    @use('App\Helpers\Formatting')
    <div class="xs-pd-20-10 pd-ltr-20">
        <div class="title pb-20 d-flex justify-content-between align-items-center">
            <h2 class="h2 mb-0">Data Pemilih</h2>
            <div class="text-right">
                <a class="btn btn-sm btn-dark text-light m-1">
                    <i class="fa fa-plus"></i> Tambah Data
                </a>
                <a class="btn btn-sm btn-dark text-light m-1">
                    <i class="fa fa-search"></i> Cari Data
                </a>
            </div>
        </div>
        <div class="row pb-10">
            <div class="col-md-12 mb-20">
                <!-- Export Datatable start -->
                <div class="card-box mb-30">
                    <div class="pd-20">
                        <h4 class="text-primary h4">Daftar Pemilih</h4>
                    </div>
                    <div class="pb-20">
                        <table width="100%" id="datatable-table"
                            class="table hover stripe multiple-select-row data-table-export no-wrap responsive">
                            <thead>
                                <tr>
                                    <th class="table-plus datatable-nosort">NIK</th>
                                    <th>Nama</th>
                                    <th>Nomor Ponsel</th>
                                    <th>Alamat</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <tr>
                                        <td>Hello</td>
                                        <td>{{ Formatting::capitalize("Anto Selang") }}</td>
                                        <td>Hello</td>
                                        <td>Hello</td>
                                        <td>
                                            <div class="dropdown">
                                                <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle"
                                                    href="#" role="button" data-toggle="dropdown">
                                                    <i class="dw dw-more"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                    <a class="dropdown-item" href="#"><i class="dw dw-eye"></i>
                                                        Lihat</a>
                                                    <a class="dropdown-item"
                                                        href="#"><i
                                                            class="dw dw-edit2"></i>
                                                        Edit</a>
                                                    <a class="dropdown-item"
                                                        href="#"><i class="dw dw-delete-3"></i>
                                                        Hapus</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <script>
                    $("#datatable-table").DataTable({
                        // "scrollX": true,
                    })
                </script>
                <!-- Export Datatable End -->
            </div>
            <div class="col-md-4 mb-20">

            </div>
        </div>
    </div>
@endsection
