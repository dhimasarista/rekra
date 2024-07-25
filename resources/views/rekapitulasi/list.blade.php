@extends('layouts/main')
@section('body')
    <div class="xs-pd-20-10 pd-ltr-20">
        <div class="title pb-20 d-flex justify-content-between align-items-center">
            <h2 class="h2 mb-0">List</h2>
            <div class="text-right">
                <a class="btn btn-sm btn-dark" href="{{ url()->previous() }}">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
        <div class="row pb-10">
            <div class="col-md-12 mb-20">
                <!-- Export Datatable start -->
                <div class="card-box mb-30">
                    <div class="pd-20">
                        @use('App\Helpers\Formatting')
                        <h4 class="text-blue h4">{{ Formatting::capitalize(request()->query('Jenis')) }}</h4>
                    </div>
                    <div class="pb-20">
                        <table id="provinsi-table" class="table hover multiple-select-row data-table-export wrap">
                            <thead>
                                <tr>
                                    <th class="table-plus datatable-nosort">Nomor</th>
                                    <th>Nama Calon</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $counter = 1;
                                @endphp
                                {{-- @dd($data) --}}
                                @foreach ($data as $d)
                                    <tr>
                                        <td>{{ $counter++ }}</td>
                                        <td>{{ Formatting::capitalize($d->calon_name . ' - ' . $d->wakil_name) }}</td>
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
                                                    <a class="dropdown-item" href="#"><i class="dw dw-edit2"></i>
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
