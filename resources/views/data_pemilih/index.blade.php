@extends('layouts/main')
@section('body')
    @php
        $segments = request()->segments();
    @endphp
    @use('App\Helpers\Formatting')
    <div class="xs-pd-20-10 pd-ltr-20">
        <div class="title pb-20 d-flex justify-content-between align-items-center">
            <h2 class="h2 mb-0">Data Pemilih</h2>
            <div class="text-right">
                <a class="btn btn-sm btn-dark text-light m-1" data-toggle="modal" data-target="#Medium-modal">
                    <i class="fa fa-plus"></i> Tambah Data
                </a>
                <a class="btn btn-sm btn-dark text-light m-1">
                    <i class="fa fa-search"></i> Cari Data
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
                                    <th>Nomor Ponsel</th>
                                    <th>Alamat</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Hello</td>
                                    <td>{{ Formatting::capitalize('Anto Selang') }}</td>
                                    <td>Hello</td>
                                    <td>Hello</td>
                                </tr>
                                <tr>
                                    <td>Hello</td>
                                    <td>{{ Formatting::capitalize('Anto Selang') }}</td>
                                    <td>Hello</td>
                                    <td>Hello</td>
                                </tr>
                                <tr>
                                    <td>Hello</td>
                                    <td>{{ Formatting::capitalize('Anto Selang') }}</td>
                                    <td>Hello</td>
                                    <td>Hello</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <script>
                    $(document).ready(function() {
                        var table = $("#datatable-table").DataTable({
                            scrollCollapse: true,
                            autoWidth: false,
                            responsive: true,
                            columnDefs: [{
                                targets: "datatable-nosort",
                                orderable: false,
                            }],
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
                                }
                            },
                            dom: '<"d-flex justify-content-between"lBf>rt<"d-flex justify-content-between"ip>',
                            buttons: [
                                'copy', 'csv', 'pdf', 'print', 'excel'
                            ]
                        });

                        table.buttons().container().appendTo('#export-buttons');
                    });
                </script>
            </div>
            <div class="col-md-4 mb-20">

            </div>
        </div>
    </div>
    <div class="modal fade" id="Medium-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Large modal</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                    consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                    cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                    proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection
