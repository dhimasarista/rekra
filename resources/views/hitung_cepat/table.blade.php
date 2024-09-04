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
        <table id="datatable-table" class="table hover stripe multiple-select-row data-table-export wrap">
            <thead class="text-center">
                <tr>
                    <th>Nama TPS</th>
                    @if ($calon)
                        @foreach ($calon as $c)
                            <th>{{ Formatting::capitalize($c->calon_name) }}</th>
                        @endforeach
                    @endif
                    <th>Updated By</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="text-center">
                {{-- <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> --}}
                @if ($data)
                    @foreach ($data as $d)
                        <tr>
                            <td>{{ $d->name }}</td>
                            @if ($calon)
                                @foreach ($calon as $c)
                                    <th><input type="number" max="1000" class="form-control"></th>
                                @endforeach
                            @endif
                            <td></td>
                            <td>
                                <button id="#" class="btn btn-sm btn-dark m-1">Submit</button>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
    <script>
        $("#datatable-table").DataTable({
            "order": []
        })
    </script>
</div>
{{ $calon }}
