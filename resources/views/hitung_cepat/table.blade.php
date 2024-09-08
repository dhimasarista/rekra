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
    @if ($data)
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
                        <tr id="{{ $d['id'] }}">
                            <td>{{ $d['tps_name'] }}</td>
                            @foreach ($d['calon_data'] as $calon)
                                <td style="width: 15%">
                                    <input id="{{ $calon['id'] }}" type="number" min="0" max="1000"
                                        class="form-control" value="{{ $calon['amount'] }}">
                                </td>
                            @endforeach
                            <td id="updatedBy-{{ $d['id'] }}">{{ $d['updated_by'] }}</td>
                            <td>
                                <button id="submit-{{ $d['id'] }}" onclick="submitButton('{{ $d['id'] }}')"
                                    class="btn btn-sm btn-dark m-1">Submit</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <script>
            $("#datatable-table").DataTable({
                "order": [],
                "scrollX": true,
            });
        </script>
        <script>
            const submitButton = (tpsId) => {
                let calonData = {};
                let buttonSubmit = $(`#submit-${tpsId}`);
                buttonSubmit.attr("disabled", true);
                $(`#${tpsId} input[type=number]`).each(function() {
                    calonData[$(this).attr('id')] = $(this).val();
                });

                let data = {
                    "Tps": tpsId,
                    ...calonData
                };
                let url = `{!! route('hitung_cepat.admin.post', ['Tps' => 'TPS_PLACEHOLDER']) !!}`.replace("TPS_PLACEHOLDER", tpsId);
                $.ajax({
                    type: "POST",
                    url: url,
                    data: JSON.stringify(data),
                    contentType: "application/json",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Toast.fire({
                            icon: "success",
                            title: response["message"]
                        });
                        $(`#updatedBy-${tpsId}`).html("{{ session()->get('name') }}")
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr["responseJSON"]["message"]
                        });
                    },
                    complete: function(data) {
                        buttonSubmit.removeAttr("disabled");
                    }
                });
            }
        </script>
    @endif
</div>
{{-- {{ $data }} --}}
