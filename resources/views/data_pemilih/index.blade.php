@extends('layouts/main')
@section('body')
    @php
        $segments = request()->segments();
        $idModal = 'X' . bin2hex(random_bytes(8));
        $buttonSubmit = 'X' . bin2hex(random_bytes(8));
        $nikForm = 'X' . bin2hex(random_bytes(8));
        $nameForm = 'X' . bin2hex(random_bytes(8));
        $phoneForm = 'X' . bin2hex(random_bytes(8));
        $addressForm = 'X' . bin2hex(random_bytes(8));

        $uploadDptBtn = 'X' . bin2hex(random_bytes(8));
        $uploadDptForm = 'X' . bin2hex(random_bytes(8));
    @endphp
    @use('App\Helpers\Formatting')
    <div class="xs-pd-20-10 pd-ltr-20">
        <div class="title pb-20 d-flex justify-content-between align-items-center">
            <h2 class="h2 mb-0">Data Pemilih</h2>
            <div class="text-right">
                <input type="file" name="pdf" id="pdf" accept="application/pdf" style="display: none;" required>
                <a class="btn btn-sm btn-dark text-light m-1" id="{{ $uploadDptBtn }}">
                    <i class="fa fa-cloud-upload"></i> Upload DPT
                </a>
                <script>
                    $('{{ $uploadDptBtn }}').on('click', function() {
                        $('#pdf').click();
                    });
                    $('#uploadForm').on('submit', function(e) {
                        e.preventDefault();

                        var formData = new FormData(this);

                        $.ajax({
                            url: '/parse-pdf',
                            type: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                // Display parsed data
                                $('#parsedData').text(JSON.stringify(response, null, 2));
                            },
                            error: function(xhr) {
                                alert('Error parsing PDF: ' + xhr.responseText);
                            }
                        });
                    });
                </script>
                <a class="btn btn-sm btn-dark text-light m-1" data-toggle="modal" data-target="#{{ $idModal }}">
                    <i class="fa fa-plus"></i> Tambah Data
                </a>
                {{-- <a class="btn btn-sm btn-dark text-light m-1">
                    <i class="fa fa-trash"></i> Hapus Data
                </a> --}}
            </div>
        </div>
        <div class="row pb-10">
            <div class="col-md-12 mb-20">
                {{-- data table button --}}
                <script src="{{ asset('admin/src/plugins/datatables/js/dataTables.buttons.min.js') }}"></script>
                <script src="{{ asset('admin/src/plugins/datatables/js/buttons.bootstrap4.min.js') }}"></script>
                <script src="{{ asset('admin/src/plugins/datatables/js/buttons.print.min.js') }}"></script>
                <script src="{{ asset('admin/src/plugins/datatables/js/buttons.html5.min.js') }}"></script>
                <script src="{{ asset('admin/src/plugins/datatables/js/buttons.flash.min.js') }}"></script>
                <script src="{{ asset('admin/src/plugins/datatables/js/pdfmake.min.js') }}"></script>
                <script src="{{ asset('admin/src/plugins/datatables/js/vfs_fonts.js') }}"></script>
                <div class="card-box mb-30">
                    <div class="pd-20 d-flex justify-content-between align-items-center">
                        <h4 class="text-primary h4">Daftar Pemilih</h4>
                        <!-- Tombol export akan dimasukkan di sini -->
                        <div id="export-buttons"></div>
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
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>

                <script>
                    let table = $("#datatable-table").DataTable({
                        scrollCollapse: true,
                        autoWidth: false,
                        responsive: true,
                        columnDefs: [{
                            targets: "datatable-nosort",
                            orderable: false,
                        }],
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: "{{ route('data-pemilih.all') }}",
                            type: "GET"
                        },
                        "lengthMenu": [
                            [10, 25, 50, 100, -1],
                            [10, 25, 50, 100, "All"]
                        ],
                        "language": {
                            "info": "_START_-_END_ of _TOTAL_ entries",
                            searchPlaceholder: "Search",
                            lengthMenu: "Show _MENU_ entries",
                            paginate: {
                                next: '<i class="ion-chevron-right"></i>',
                                previous: '<i class="ion-chevron-left"></i>'
                            },
                            processing: "Mohon tunggu, data sedang diambil..."
                        },
                        dom: '<"d-flex justify-content-between"lBf>rt<"d-flex justify-content-between"ip>',
                        buttons: [
                            'copy', 'csv', 'pdf', 'print', 'excel'
                        ],
                        columns: [{
                                data: 'nik',
                                render: function(data, type, row) {
                                    return Formatting.capitalize(data)
                                }
                            },
                            {
                                data: 'name',
                                render: function(data, type, row) {
                                    return Formatting.capitalize(data)
                                }
                            },
                            {
                                data: 'phone',
                                name: 'phone'
                            },
                            {
                                data: null,
                                render: function(data, type, row) {
                                    return Formatting.capitalize(row.address)
                                }
                            },
                        ],
                    });

                    table.buttons().container().appendTo('#export-buttons');
                </script>
            </div>
        </div>
    </div>
    <div class="modal fade" id="{{ $idModal }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content ">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Tambah Data</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body" style="overflow-y: auto;">
                    <form>
                        <div class="form-group row">
                            <label class="col-md-12 col-form-label">NIK</label>
                            <div class="col-md-12">
                                <input class="form-control" id="{{ $nikForm }}" type="number"
                                    placeholder="Masukkan NIK">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-12 col-form-label">Nama</label>
                            <div class="col-md-12">
                                <input class="form-control" id="{{ $nameForm }}" type="text"
                                    placeholder="Masukkan Nama">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-12 col-form-label">Nomor HP</label>
                            <div class="col-md-12">
                                <input class="form-control" id="{{ $phoneForm }}" type="number"
                                    placeholder="Masukkan Nomor HP">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-12 col-form-label">Alamat</label>
                            <div class="col-md-12">
                                <input class="form-control" id="{{ $addressForm }}" type="text"
                                    placeholder="Masukkan Alamat">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-dark" id="{{ $buttonSubmit }}">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("#{{ $buttonSubmit }}").on("click", function(e) {
            $.ajax({
                type: "POST",
                url: "{{ route('data-pemilih.create') }}",
                data: JSON.stringify({
                    nik: $("#{{ $nikForm }}").val(),
                    name: $("#{{ $nameForm }}").val(),
                    phone: $("#{{ $phoneForm }}").val(),
                    address: $("#{{ $addressForm }}").val(),
                }),
                contentType: "application/json",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    table.ajax.reload()
                    $('#{{ $idModal }}').modal('hide');
                    Toast.fire({
                        icon: "success",
                        title: response["message"]
                    });
                    $("#{{ $nikForm }}").val(null)
                    $("#{{ $nameForm }}").val(null)
                    $("#{{ $phoneForm }}").val(null)
                    $("#{{ $addressForm }}").val(null)
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr["responseJSON"]["message"]
                    });
                },
                complete: function(data) {}
            });
        })
    </script>
@endsection
