<div class="card-box mb-30">
    <div class="pd-20">
        <h4 class="text-blue h4">Hello</h4>
    </div>
    <div class="pb-20">
        <table id="datatable-table" class="table hover stripe multiple-select-row data-table-export wrap">
            <thead>
                <tr>
                    <th>Hello</th>
                    <th>Hello</th>
                    <th>Hello</th>
                </tr>
            </thead>
            <tbody>
                {{-- <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> --}}
            </tbody>
        </table>
    </div>
    <script>
        $("#datatable-table").DataTable({
            "order": []
        })
    </script>
</div>
