@use('App\Helpers\Formatting')
<div class="card-box mb-30">
    <div class="pd-20">
        <h4 class="text-blue h4">
            List
        </h4>
    </div>
    <div class="pb-20">
        <table width="100%" id="datatable-table"
            class="table hover stripe multiple-select-row data-table-export wrap">
            <thead class="text-center">
                <tr>
                    <th>Gubernur</th>
                    <th>Wakil Gubernur</th>
                    <th>Total</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @foreach ($data as $calon)
                <tr>
                    <td>{{ Formatting::capitalize($calon->calon_name) }}</td>
                    <td>{{ Formatting::capitalize($calon->wakil_name) }}</td>
                    <td>{{ $calon->total }}</td>
                    <td>Lihat</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
    $("#datatable-table").DataTable({
        "order": [],
        "scrollX": true,
    });
</script>
