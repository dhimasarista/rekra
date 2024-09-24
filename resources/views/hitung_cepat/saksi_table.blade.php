@use('App\Helpers\Formatting')
<div class="card-box mb-30">
    <div class="pd-20">
        <h4 class="text-blue h4">
            @if ($table)
                {{ Formatting::capitalize($table) }}
            @else
                {{ 'Tidak Ada Data' }}
            @endif
        </h4>
    </div>
    <div class="pb-20">
        <table width="100%" id="datatable-table" class="table hover stripe multiple-select-row data-table-export wrap">
            <thead class="text-center">
                <tr>
                    <th>Nama TPS</th>
                    <th>NIK</th>
                    <th>Status Input</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @for ($i = 0; $i < 20; $i++)
                    <tr id="{{ $i }}">
                        <td>{{ $i + 1 }}</td>
                        <td class="d-flex justify-content-start">
                            <input id="1" type="number" min="0" max="1000" class="form-control"
                                value="1404100105020001">
                        </td>
                        <td>
                            <input type="checkbox" checked>
                        </td>
                        <td>
                            <button id="submit-123" class="btn btn-sm btn-dark m-1">Perbarui</button>
                            <button id="submit-123" class="btn btn-sm btn-dark m-1" data-toggle="modal"
                                data-target="#Medium-modal">Edit</button>
                        </td>
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>
    <script>
        $("#datatable-table").DataTable({
            "order": [],
            "scrollX": true,
        });
    </script>
    <div class="modal fade" id="Medium-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Edit Saksi TPS</h4>
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
