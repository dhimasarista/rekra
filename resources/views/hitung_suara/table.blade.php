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
            <thead>
                <tr>
                    <th>Nomor TPS</th>
                    <th>Wilayah</th>
                    <th>Input</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>TPS 1</td>
                    <td> Teluk Tering, Batam Kota, Kota Batam</td>
                    <td>
                        <div class="m-10">
                            {{-- @if (session()->get('level') == 'provinsi' || session()->get('level') == 'master') --}}
                            <a class="btn btn-sm btn-dark m-1" href="#">
                                <i class="fa fa-plus"></i> Provinsi
                            </a>
                            {{-- @endif --}}
                            <a class="btn btn-sm btn-dark m-1" href="#">
                                <i class="fa fa-plus"></i> Kab/Kota
                            </a>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <script>
        $("#datatable-table").DataTable({
            "order": [],
            "scrollX": true,

        });
    </script>
</div>
