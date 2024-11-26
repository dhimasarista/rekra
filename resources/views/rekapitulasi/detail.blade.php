@extends('layouts/main')
@section('body')
    <div class="xs-pd-20-10 pd-ltr-20">
        <div class="title pb-20 d-flex justify-content-between align-items-center">
            {{-- <h2 class="h2 mb-0">List</h2> --}}
            <div class="text-left">
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
                        <h4 class="text-blue h4">
                            {{ Formatting::capitalize($wilayah) }}
                        </h4>
                        {{-- <h4 class="text-blue h4">{{ Formatting::capitalize(request()->query('Type')) }}</h4> --}}
                    </div>
                    <div class="pb-20">
                        @dd($data)
                        <table width="100%" id="datatable-table" class="table stripe multiple-select-row data-table-export wrap">
                            <thead>
                                <tr>
                                    <th class="table-plus datatable-nosort">Nama</th>
                                    @foreach ($data[0]["calon"] as $d)
                                            <th>{{ Formatting::capitalize($d['calon_name']) }}</th>
                                    @endforeach
                                    <th>DPT</th>
                                    <th>DPT</th>
                                    <th>DPK</th>
                                    <th>Surat Suara Diterima</th>
                                    <th>Surat Suara Digunakan</th>
                                    <th>Surat Suara Tdk Digunakan</th>
                                    <th>Surat Suara Rusak</th>
                                    <th>Sah</th>
                                    <th>Tdk Sah</th>
                                    <th>Sah/Tdk Sah</th>
                                    @if ($wilayah !== 'TPS')
                                        <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @if ($data)
                                    @php
                                        $code = null;
                                        $typeQuery = request()->query('Type');
                                    @endphp
                                    @foreach ($data as $d)
                                        <tr>
                                            <td>{{ Formatting::capitalize($d['name']) }}</td>
                                            @foreach ($d['calon'] as $calon)
                                                <td>{{ $calon['total_suara'] ?? 0 }}</td> <!-- Menampilkan 0 jika total_suara tidak ada -->
                                            @endforeach
                                            <!-- Menampilkan 0 jika calon tidak ada -->
                                            @php
                                                $calonCount = count($d['calon']);
                                            @endphp
                                            @for ($i = $calonCount; $i < 2; $i++) <!-- Menampilkan 0 untuk calon yang tidak ada -->
                                                <td>0</td>
                                            @endfor
                                            <td>{{ $d['jumlah_suara']["dpt"] }}</td>
                                            <td>{{ $d['jumlah_suara']["dptb"] }}</td>
                                            <td>{{ $d['jumlah_suara']["dptk"] }}</td>
                                            <td>{{ $d['jumlah_suara']["surat_suara_diterima"] }}</td>
                                            <td>{{ $d['jumlah_suara']["surat_suara_digunakan"] }}</td>
                                            <td>{{ $d['jumlah_suara']["surat_suara_tidak_digunakan"] }}</td>
                                            <td>{{ $d['jumlah_suara']["surat_suara_rusak"] }}</td>
                                            <td>{{ $d['jumlah_suara']["total_suara_sah"] }}</td>
                                            <td>{{ $d['jumlah_suara']["total_suara_tidak_sah"] }}</td>
                                            <td>{{ $d['jumlah_suara']["total_sah_tidak_sah"] }}</td>
                                            @if ($wilayah !== 'TPS')
                                                <td>
                                                    <a href="{{ route('rekap.detail', [
                                                'Type' => $wilayah,
                                                "Type" => $level,
                                                'Code' => $d["id"],
                                            ]) }}" style="text-decoration: underline">Detail</a>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                @endif
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

            </div>
        </div>
    </div>
@endsection
