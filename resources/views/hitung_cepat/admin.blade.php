@extends('layouts/main')
@section('body')
    @php
        $segments = request()->segments();
    @endphp
    @use('App\Helpers\Formatting')
    <div class="xs-pd-20-10 pd-ltr-20">
        < class="title pb-20 d-flex justify-content-between align-items-center">
            <div class="row">
                <div class="col-md-6">
                    <select class="custom-select form-control">
                        <option disabled selected="">Tingkat</option>
                        <option value="1">Provinsi</option>
                        <option value="2">KabKota</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <select class="custom-select">
                        <option disabled selected="">Kab/Kota</option>
                        <option value="1">One</option>
                    </select>
                </div>
            </div>
            <div class="text-right">

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
