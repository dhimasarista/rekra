@use('App\Helpers\Formatting')

<div class="card-box mb-30">
    <div class="pd-20">
        <h4 class="text-blue h4">
            @if ($table)
                {{ Formatting::capitalize($table) }}
            @else
                {{ "Tidak Ada Data" }}
            @endif
        </h4>
    </div>
    <div class="pb-20">
        <table id="datatable-table" class="table hover stripe multiple-select-row data-table-export">
            <thead class="text-center">
                <tr>
                    <th>Nama TPS</th>
                    @foreach ($calon as $c)
                        <th>{{ Formatting::capitalize($c->calon_name) }}</th>
                    @endforeach
                    <th>Updated By</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @foreach ($data as $d)
                    <tr>
                        <td>{{ $d['tps_name'] }}</td>
                        @foreach ($d['calon_data'] as $calon)
                            <td style="width: 15%">
                                <input type="number" min="0" max="1000" class="form-control"
                                    value="{{ $calon['amount'] }}">
                            </td>
                        @endforeach
                        <td>{{ $d['updated_by'] }}</td>
                        <td>
                            <button id="submit-{{ $loop->index }}" class="btn btn-sm btn-dark m-1">Submit</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script>
        $("#datatable-table").DataTable({
            "order": []
        })
    </script>
</div>
