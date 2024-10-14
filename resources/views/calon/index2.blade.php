@extends('layouts/main')
@section('body')
    <div class="xs-pd-20-10 pd-ltr-20">
        <div class="title pb-20 d-flex justify-content-between align-items-center">
            <h2 class="h2 mb-0">List</h2>
            <div class="text-right">
                <a class="btn btn-sm btn-dark" href="{{ route('calon.form') }}">
                    <i class="fa fa-plus"></i> Tambah Calon
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
                        <table width="100%" id="datatable-table" class="table hover stripe multiple-select-row data-table-export wrap">
                            <thead>
                                <tr>
                                    <th class="table-plus datatable-nosort">Tingkat</th>
                                    <th>Kode Wilayah</th>
                                    <th>Nama Calon</th>
                                    <th>Daerah Pemilihan</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <script>
                            const buttonDelete = (id) => {
                                Swal.fire({
                                    title: "Hapus Data?",
                                    text: "data yang sudah dihapus tidak bisa dikembalikan!",
                                    icon: "warning",
                                    showCancelButton: true,
                                    confirmButtonColor: "#3085d6",
                                    cancelButtonColor: "#d33",
                                    confirmButtonText: "Yes!"
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        TopLoaderService.start()
                                        $.ajax({
                                            type: "DELETE",
                                            url: `{{ route('calon.destroy', ':id') }}`.replace(':id', id),
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
                                                    window.location.replace("/calon");
                                                });
                                            },
                                            error: function(xhr, status, error) {
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'Error',
                                                    text: error
                                                });
                                            },
                                            complete: data => {
                                                TopLoaderService.end()
                                            }
                                        });
                                    }
                                });
                            }
                        </script>
                    </div>
                </div>
                <script>
                    $(document).ready(function() {
                        $('#datatable-table').DataTable({
                            scrollX: true,
                            processing: true,
                            serverSide: true,
                            ajax: {
                                url: "{{ route('calon.all') }}",
                                type: "GET"
                            },
                            columns: [
                                { 
                                    data: 'level', render: function (data, type, row) {
                                        return Formatting.capitalize(row.level)
                                    }
                                },
                                { data: 'code', name: 'code' },
                                { 
                                    data: 'calon_name', render: function (data, type, row) {
                                        return Formatting.capitalize(`${row.calon_name} - ${row.wakil_name}`)
                                    }
                                },
                                { 
                                    data: null, render: function (data, type, row) {
                                        return Formatting.capitalize(row.kabkota_name)
                                    }
                                },
                                {
                                    data: 'id',
                                    render: function(data, type, row) {
                                        const editUrl = "{{ route('calon.form', ['Id' => 'ID_PLACEHOLDER']) }}".replace("ID_PLACEHOLDER", data)
                                        return `
                                            <div class="dropdown">
                                                <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                    <i class="dw dw-more"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                    <a class="dropdown-item" href="#"><i class="dw dw-eye"></i> Lihat</a>
                                                    <a class="dropdown-item" href="${editUrl}"><i class="dw dw-edit2"></i> Edit</a>
                                                    <a class="dropdown-item" onclick="buttonDelete('${data}')" href="#"><i class="dw dw-delete-3"></i> Delete</a>
                                                </div>
                                            </div>
                                        `;
                                    },
                                    orderable: false,
                                    searchable: false
                                }
                            ],
                            language: {
                                processing: "Mohon tunggu, data sedang diambil..." // Ganti teks di sini
                            }
                        });
                    });
                </script>
                <!-- Export Datatable End -->
            </div>
            <div class="col-md-4 mb-20">

            </div>
        </div>
    </div>
@endsection
