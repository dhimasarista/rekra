@extends('layouts/main')
@section('body')
    <div class="xs-pd-20-10 pd-ltr-20">
        <div class="title pb-20 d-flex justify-content-between align-items-center">
            <h2 class="h2 mb-0">List</h2>
            <div class="text-right">
                <a class="btn btn-sm btn-dark" href="{{ route('calon.create') }}">
                    <i class="fa fa-plus"></i> Tambah Calon
                </a>
                <a class="btn btn-sm btn-dark" href="{{ route('calon.create', ['Id' => 1]) }}">
                    <i class="fa fa-plus"></i> Edit Calon
                </a>
            </div>
        </div>
        <div class="row pb-10">
            <div class="col-md-12 mb-20">
                <!-- Export Datatable start -->
                <div class="card-box mb-30">
                    <div class="pd-20">
                        <h4 class="text-blue h4">Daftar Calon</h4>
                    </div>
                    <div class="pb-20">
                        <table id="provinsi-table" class="table hover multiple-select-row data-table-export wrap">
                            <thead>
                                <tr>
                                    <th class="table-plus datatable-nosort">Tingkat</th>
                                    <th>Nama Calon</th>
                                    <th>Daerah Pemilihan</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $counter = 1;
                                @endphp
                                {{-- @dd($data) --}}
                                @use('App\Helpers\Formatting')
                                @foreach ($calon as $c)
                                    <tr>
                                        <td>{{ Formatting::capitalize($c->level) }}</td>
                                        <td>{{ Formatting::capitalize($c->calon_name) }} -
                                            {{ Formatting::capitalize($c->wakil_name) }}</td>
                                        <td>12</td>
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
                                                        href="{{ route('calon.create', ['Id' => $c->id]) }}"><i
                                                            class="dw dw-edit2"></i>
                                                        Edit</a>
                                                    <a class="dropdown-item" href="#"><i class="dw dw-delete-3"></i>
                                                        Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <script>
                    $("#provinsi-table").DataTable({})
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