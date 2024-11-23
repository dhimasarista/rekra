@use('App\Helpers\Formatting')
@php
    $idDatatable = 'X' . bin2hex(random_bytes(8));
    $idModal = 'X' . bin2hex(random_bytes(8));
@endphp
<div class="card-box mb-30">
    <div class="pd-20">
        <h4 class="text-blue h4">
            Hitung Suara
        </h4>
    </div>
    <div class="pb-20">
        <table width="100%" id="{{ $idDatatable }}"
            class="table hover stripe multiple-select-row data-table-export wrap">
            <thead>
                <tr>
                    <th>Nomor TPS</th>
                    <th>Wilayah</th>
                    <th>Input</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $d)
                    <tr>
                        <td>{{ $d['name'] }}</td>
                        <td>{{ Formatting::capitalize($d['wilayah']) }}</td>
                        <td>
                            <div class="m-10">
                                @if (session()->get('level') == 'provinsi' || session()->get('level') == 'master')
                                    <a class="btn btn-sm btn-dark m-1" href="{{ $d['provinsi'] }}">
                                        <i class="fa fa-plus"></i> Provinsi
                                    </a>
                                @endif
                                <a class="btn btn-sm btn-dark m-1" data-toggle="modal"
                                    data-target="#{{ $idModal }}" href="{{ $d['kabkota'] }}">
                                    <i class="fa fa-plus"></i> Kab/Kota
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script>
        $("#{{ $idDatatable }}").DataTable({
            "order": [],
            "scrollX": true,

        });
    </script>
</div>
<div class="modal fade bs-example-modal-lg" id="{{ $idModal }}" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
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
