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
            {{-- <div class="text-right">
                <a class="btn btn-sm btn-dark" href="{{ route('rekap.list') }}">
                    <i class="fa fa-pie-chart"></i> Chart
                </a>
            </div> --}}
        </div>
        <div class="row pb-10">
            <div class="col-md-12 mb-20">
                <!-- Export Datatable start -->
                <div class="card-box mb-30">
                    <div class="pd-20">
                        @use('App\Helpers\Formatting')
                        <h4 class="text-blue h4">
                            {{ Formatting::capitalize($wilayah . ' - ' . $calon->calon_name . ' & ' . $calon->wakil_name) }}
                        </h4>
                        {{-- <h4 class="text-blue h4">{{ Formatting::capitalize(request()->query('Type')) }}</h4> --}}
                    </div>
                    <div class="pb-20">
                        <table width="100%" id="datatable-table" class="table stripe multiple-select-row data-table-export wrap">
                            <thead>
                                <tr>
                                    <th class="table-plus datatable-nosort">Nama</th>
                                    <th>Jumlah</th>
                                    @if ($wilayah !== "TPS")
                                    <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @if ($data)
                                    @php
                                        $code = null;
                                        $typeQuery = request()->query("Type");
                                    @endphp
                                    @foreach ($data as $d)
                                        <tr>
                                            <td>{{ Formatting::capitalize($d->name) }}</td>
                                            <td>{{ $d->total }}</td>
                                            @if ($wilayah !== "TPS")
                                            <td>
                                                <a href="{{ route('rekap.detail', [
                                                    'Type' => $wilayah,
                                                    'Code' => $d->id,
                                                    'Id' => $calon->id,
                                                ]) }}"
                                                    style="text-decoration: underline">Detail</a>
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
