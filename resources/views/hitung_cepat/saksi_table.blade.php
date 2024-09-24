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
            <table width="100%" id="datatable-table"
                class="table hover stripe multiple-select-row data-table-export wrap">
                <thead class="text-center">
                    <tr>
                        <th>Nama TPS</th>
                        <th>NIK</th>
                        <th>Updated By</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @for ($i = 0; $i < 20; $i++)
                    <tr id="{{ $i }}">
                        <td>{{ $i+1 }}</td>
                        <td class="d-flex justify-content-start">
                            <input id="1" type="number" min="0" max="1000"
                                class="form-control" value="1404100105020001">
                            <button id="submit-123" class="btn btn-sm btn-dark m-1">Submit</button>
                        </td>
                        <td id="updatedBy-123">Humans</td>
                        <td>
                            <button id="submit-123" class="btn btn-sm btn-dark m-1">Edit</button>
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
</div>
