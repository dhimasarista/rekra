@extends('layouts/main')
@section('body')
    <div class="xs-pd-20-10 pd-ltr-20">
        <div class="title pb-20 d-flex justify-content-between align-items-center">
            {{-- <h2 class="h2 mb-0">List</h2> --}}
            <div class="text-left">
                <a class="btn btn-sm btn-dark" href="{{ route('rekap.index', ['Type' => 'Kabkota']) }}">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
            </div>
            <div class="text-right">
                <a class="btn btn-sm btn-dark"
                    href="{{ route('rekap.list', [
                        'Type' => request()->query('Type'),
                        'Id' => request()->query('Id'),
                        'Chart' => 'true',
                    ]) }}">
                    <i class="fa fa-pie-chart"></i> Chart
                </a>
            </div>
        </div>
        <div class="row pb-10">
            <div class="col-md-8 mb-20">
                <!-- Export Datatable start -->
                <div class="card-box mb-30">
                    <div class="pd-20">
                        @use('App\Helpers\Formatting')
                        <h4 class="text-blue h4">{{ Formatting::capitalize($wilayah->name) }}</h4>
                        {{-- <h4 class="text-blue h4">{{ Formatting::capitalize(request()->query('Type')) }}</h4> --}}
                    </div>
                    <div class="pb-20">
                        <table width="100%" id="datatable-table"
                            class="table stripe multiple-select-row data-table-export wrap">
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
                                        <td>{{ number_format($d->total) }}</td>
                                        <td>
                                            <a href="{{ route('rekap.detail', [
                                                'Type' => request()->query('Type'),
                                                'Code' => request()->query('Id'),
                                                // 'Id' => $d->id,
                                            ]) }}"
                                                style="text-decoration: underline">Detail</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <script>
                    $("#datatable-table").DataTable({
                        "scrollX": true,
                    })
                </script>
                <!-- Export Datatable End -->
            </div>
            <div class="col-md-4 mb-20">
                <div class="card-box mb-30">
                    <div class="pd-20">
                        <h4 class="text-blue h4">CHasil</h4>
                    </div>
                    <div class="pb-20">
                        <div class="container">
                            <div><strong>Total DPT:</strong> {{ $data[0]->total_dpt }}</div>
                            <div><strong>Total DPTB:</strong> {{ $data[0]->total_dptb }}</div>
                            <div><strong>Total DPTK:</strong> {{ $data[0]->total_dptk }}</div>
                            <div><strong>Surat Suara Diterima:</strong> {{ $data[0]->surat_suara_diterima }}</div>
                            <div><strong>Surat Suara Digunakan:</strong> {{ $data[0]->surat_suara_digunakan }}</div>
                            <div><strong>Surat Suara Tidak Digunakan:</strong> {{ $data[0]->surat_suara_tidak_digunakan }}
                            </div>
                            <div><strong>Surat Suara Rusak:</strong> {{ $data[0]->surat_suara_rusak }}</div>
                            <div><strong>Total Suara Sah:</strong> {{ $data[0]->total_suara_sah }}</div>
                            <div><strong>Total Suara Tidak Sah:</strong> {{ $data[0]->total_suara_tidak_sah }}</div>
                            <div><strong>Total Sah dan Tidak Sah:</strong> {{ $data[0]->total_sah_tidak_sah }}</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
