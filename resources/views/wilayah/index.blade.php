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
            <script>
                $("#tambah-tps").on("click", e => {
                    Swal.fire({
                        title: '<h1>Pilih Jenis Input Data</h1>',
                        html: `
                            <a href="{{ route('wilayah.form', ['Type' => 'TPS', 'Form' => 'Single']) }}" class="btn btn-success">Satu</a>
                            <a href="{{ route('wilayah.form', ['Type' => 'TPS', 'Form' => 'Multiple']) }}" class="btn btn-warning">Banyak</a>
                        `,
                        showConfirmButton: false,
                        showCancelButton: false
                    });
                })
            </script>
        </div>
        <div class="row pb-10">
            <div class="col-md-12 mb-20">
                <!-- Export Datatable start -->
                <div class="card-box mb-30">
                    <div class="pd-20">
                        <h4 class="text-blue h4">{{ Formatting::capitalize($tableName) }}</h4>
                    </div>
                    <div class="pb-20">
                        <table id="datatable-table" class="table hover stripe multiple-select-row data-table-export wrap">
                            <thead>
                                <tr>
                                    <th class="table-plus datatable-nosort">Nama</th>
                                    @if (request()->query('Type') == 'TPS' || request()->query('Type') != 'tps')
                                        <th>Jumlah TPS</th>
                                    @endif
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @dd($data) --}}
                                @if ($data)
                                    @foreach ($data as $d)
                                        <tr>
                                            <td>{{ Formatting::capitalize($d['name']) }}</td>
                                            @if (request()->query('Type') != 'TPS' || request()->query('Type') != 'tps')
                                                <td>{{ $d['total'] }}</td>
                                            @endif
                                            <td>
                                                <div class="dropdown">
                                                    <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle"
                                                        href="#" role="button" data-toggle="dropdown">
                                                        <i class="dw dw-more"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                        <a class="dropdown-item" href="{{ $d['detail'] }}"><i
                                                                class="dw dw-eye"></i>
                                                            Lihat</a>
                                                        <a class="dropdown-item" href="{{ $d['edit'] }}"><i
                                                                class="dw dw-edit2"></i>
                                                            Edit</a>
                                                        <a class="dropdown-item" href="javascript:;" onclick="DeleteData('{!! $d['delete'] !!}')"><i
                                                                class="dw dw-delete-3"></i>
                                                            Delete</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <script>
                        $("#datatable-table").DataTable({
                            "order": []
                        })
                        const DeleteData = (url) => {
                            TopLoaderService.start()
                            $.ajax({
                                type: "DELETE",
                                url: url,
                                data: "data",
                                dataType: "json",
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function(response) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success',
                                        text: response.message
                                    }).then(() => {
                                        window.location.replace(`
                                            {!! route("wilayah.index",["Type" => request()->query("Type"), "Id" => request()->query("Id")]) !!}
                                        `);
                                    });
                                },
                                error: function(xhr, status, error) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: xhr.responseJSON.message ?? error
                                    });
                                },
                                complete: data => {
                                    TopLoaderService.end()
                                }
                            });
                        }
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
