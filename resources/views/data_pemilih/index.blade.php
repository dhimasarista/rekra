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
        $genderForm = 'X' . bin2hex(random_bytes(8));
        $ageForm = 'X' . bin2hex(random_bytes(8));
        $rtForm = 'X' . bin2hex(random_bytes(8));
        $rwForm = 'X' . bin2hex(random_bytes(8));
        $tpsForm = 'X' . bin2hex(random_bytes(8));
        $keldesaForm = 'X' . bin2hex(random_bytes(8));
        $kabkotaForm = 'X' . bin2hex(random_bytes(8));
        $provinsiForm = 'X' . bin2hex(random_bytes(8));
        $kecamatanForm = 'X' . bin2hex(random_bytes(8));

        $uploadDptBtn = 'X' . bin2hex(random_bytes(8));
        $uploadDptForm = 'X' . bin2hex(random_bytes(8));
    @endphp
    @use('App\Helpers\Formatting')
    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
    <div id="loadingOverlay" class="loading-overlay text-center position-fixed w-100 h-100"
        style="background: rgba(0, 0, 0, 0.7); top: 0; left: 0; z-index: 9999; display: none;">
        <div class="loading-content text-center text-white"
            style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
            <div class="spinner-border text-light" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <p class="mt-3">Loading, please wait...</p>
        </div>
    </div>
    <div class="xs-pd-20-10 pd-ltr-20">
        <div class="title pb-20 d-flex justify-content-between align-items-center">
            <h2 class="h2 mb-0">Data Pemilih</h2>
            <div class="text-right">
                <input type="file" name="pdf[]" id="{{ $uploadDptForm }}" accept="application/pdf"
                    style="display: none;" multiple required>
                <a class="btn btn-sm btn-dark text-light m-1" id="{{ $uploadDptBtn }}">
                    <i class="fa fa-cloud-upload"></i> Upload DPT (MAX 20)
                </a>

                <script>
                    $('#{{ $uploadDptBtn }}').on('click', function() {
                        $('#{{ $uploadDptForm }}').click();
                    });

                    $('#{{ $uploadDptForm }}').on('change', function(e) {
                        e.preventDefault();
                        $("#{{ $uploadDptBtn }}").attr('disabled', 'disabled');

                        let fileInput = $('#{{ $uploadDptForm }}')[0];
                        if (fileInput.files.length === 0) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'No file selected',
                                text: 'Please select a PDF file to upload.'
                            });
                            TopLoaderService.end();
                            return;
                        }

                        let formData = new FormData();
                        $.each(fileInput.files, function(index, file) {
                            formData.append('pdf[]', file);
                        });

                        $.ajax({
                            url: '{{ route('data-pemilih.pdf') }}',
                            type: 'POST',
                            data: formData,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            processData: false,
                            contentType: false,
                            beforeSend: function() {
                                $('#loadingOverlay').fadeIn();
                            },
                            success: function(response) {
                                Toast.fire({
                                    icon: "success",
                                    title: response["message"]
                                });
                                table.ajax.reload();
                                // $('#parsedData').text(JSON.stringify(response, null, 2));
                                // console.log(response);
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: xhr["responseJSON"]["message"]
                                });
                            },
                            complete: function() {
                                $('#loadingOverlay').fadeOut();
                                $("#{{ $uploadDptBtn }}").removeAttr('disabled', 'disabled');
                                $("#{{ $uploadDptForm }}").val(null);
                            }
                        });
                    });
                </script>

                <a class="btn btn-sm btn-dark text-light m-1" data-toggle="modal" data-target="#{{ $idModal }}">
                    <i class="fa fa-plus"></i> Tambah Data
                </a>
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
                                    <th>Usia</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Alamat</th>
                                    <th>TPS</th>
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
                                data: 'age',
                                render: function(data, type, row) {
                                    return data
                                }
                            },
                            {
                                data: 'gender',
                                render: function(data, type, row) {
                                    return Formatting.capitalize(data)
                                }
                            },
                            {
                                data: null,
                                render: function(data, type, row) {
                                    return Formatting.capitalize(`${row.address} RT ${row.rt} RW ${row.rw}`)
                                }
                            },
                            {
                                data: null,
                                render: function(data, type, row) {
                                    return `TPS ${row.tps} | ${row.kelurahan_desa} | ${row.kecamatan} | ${row.kabkota} | ${row.provinsi}`
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
                            <div class="col-md-6">
                                <input class="form-control" id="{{ $nikForm }}" type="number" min="0"
                                    placeholder="NIK">
                            </div>
                            <div class="col-md-6">
                                <input class="form-control" id="{{ $phoneForm }}" type="number" min="0"
                                    placeholder="Nomor HP">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <input class="form-control" id="{{ $nameForm }}" type="text"
                                    placeholder="Nama Lengkap">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <select id="{{ $genderForm }}" class="custom-select col-12">
                                    <option selected disabled>Jenis Kelamin</option>
                                    <option value="L">Laki-Laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <input class="form-control" id="{{ $ageForm }}" type="number" min="0"
                                    placeholder="Umur">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-8">
                                <input class="form-control" id="{{ $addressForm }}" type="text" placeholder="Alamat">
                            </div>
                            <div class="col-md-4">
                                <input class="form-control" id="{{ $tpsForm }}" type="number" min="0"
                                    placeholder="TPS">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <input class="form-control" id="{{ $rtForm }}" type="number" min="0"
                                    placeholder="RT">
                            </div>
                            <div class="col-md-4">
                                <input class="form-control" id="{{ $rwForm }}" type="number" min="0"
                                    placeholder="RW">
                            </div>
                            <div class="col-md-4">
                                <input class="form-control" id="{{ $keldesaForm }}" type="text"
                                    placeholder="Kelurahan/Desa">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <input class="form-control" id="{{ $kecamatanForm }}" type="text"
                                    placeholder="Kecamatan">
                            </div>
                            <div class="col-md-4">
                                <input class="form-control" id="{{ $kabkotaForm }}" type="text"
                                    placeholder="Kab/Kota">
                            </div>
                            <div class="col-md-4">
                                <input class="form-control" id="{{ $provinsiForm }}" type="text"
                                    placeholder="Provinsi">
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
                    gender: $("#{{ $genderForm }}").val(),
                    age: $("#{{ $ageForm }}").val() ?? 0,
                    tps: $("#{{ $tpsForm }}").val(),
                    rt: $("#{{ $rtForm }}").val(),
                    rw: $("#{{ $rwForm }}").val(),
                    kelurahan_desa: $("#{{ $keldesaForm }}").val(),
                    kecamatan: $("#{{ $kecamatanForm }}").val(),
                    kabkota: $("#{{ $kabkotaForm }}").val(),
                    provinsi: $("#{{ $provinsiForm }}").val(),
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
                    $("#{{ $genderForm }}").prop("selectedIndex", 0)
                    $("#{{ $ageForm }}").val(null)
                    $("#{{ $tpsForm }}").val(null)
                    $("#{{ $rtForm }}").val(null)
                    $("#{{ $rwForm }}").val(null)
                    $("#{{ $keldesaForm }}").val(null)
                    $("#{{ $kecamatanForm }}").val(null)
                    $("#{{ $kabkotaForm }}").val(null)
                    $("#{{ $provinsiForm }}").val(null)
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
