@extends('layouts/main')
@section('body')
    <div class="xs-pd-20-10 pd-ltr-20">
        <div class="title pb-20">
            <h2 class="h2 mb-0">List</h2>
        </div>
        <div class="row pb-10">
            <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
                <div class="card-box height-100-p widget-style3">
                    <div class="d-flex flex-wrap">
                        <div class="widget-data">
                            <div class="weight-700 font-24 text-dark">1</div>
                            <div class="font-14 text-secondary weight-500">
                                Items
                            </div>
                        </div>
                        <div class="widget-icon">
                            <div class="icon" data-color="#00eccf">
                                <i class="icon-copy bi bi-archive"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
                <div class="card-box height-100-p widget-style3">
                    <div class="d-flex flex-wrap">
                        <div class="widget-data">
                            <div class="weight-700 font-24 text-dark">1</div>
                            <div class="font-14 text-secondary weight-500">
                                Success Orders
                            </div>
                        </div>
                        <div class="widget-icon">
                            <div class="icon" data-color="#ff5b5b">
                                <span class="icon-copy bi bi-view-list"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
                <div class="card-box height-100-p widget-style3">
                    <div class="d-flex flex-wrap">
                        <div class="widget-data">
                            <div class="weight-700 font-24 text-dark">1</div>
                            <div class="font-14 text-secondary weight-500">
                                Fail Orders
                            </div>
                        </div>
                        <div class="widget-icon">
                            <div class="icon">
                                <i class="icon-copy bi bi-arrow-left-square" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
                <div class="card-box height-100-p widget-style3">
                    <div class="d-flex flex-wrap">
                        <div class="widget-data">
                            <div class="weight-700 font-24 text-dark">1</div>
                            <div class="font-14 text-secondary weight-500">Users</div>
                        </div>
                        <div class="widget-icon">
                            <div class="icon" data-color="#09cc06">
                                <i class="icon-copy bi bi-people" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row pb-10">
            <div class="col-md-12 mb-20">
                <!-- Export Datatable start -->
                <div class="card-box mb-30">
                    <div class="pd-20">
                        {{-- {{ url()->previous() }} --}}
                        @use('App\Helpers\Formatting')
                        <h4 class="text-blue h4">{{ Formatting::capitalize($name) }}</h4>
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
                                @foreach ($data as $d)
                                    <tr>
                                        <td>{{ $counter++ }}</td>
                                        <td>{{ $d["name"] }}</td>
                                        <td>{{ $d["total"] }}</td>
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
