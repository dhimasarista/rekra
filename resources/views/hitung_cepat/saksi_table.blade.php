@use('App\Helpers\Formatting')
@use('Ramsey\Uuid\Uuid')
@php
    $editSaksiModal = Uuid::uuid7();
    $modalBodyEditSaksi = Uuid::uuid7();
    $submitEditSaksi = Uuid::uuid7();
@endphp
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
                    <th>Nomor Induk Kependudukan (NIK)</th>
                    <th>Status Input</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @if ($data)
                    @foreach ($data as $d)
                        <tr id="{{ $d["id"] }}">
                            <td>{{ $d["tps_name"] }}</td>
                            <td class="d-flex justify-content-center">
                                <input id="form-{{ $d["id"] }}" type="number" min="0" class="form-control w-50"
                                    value="{{ $d["nik"] }}">
                                <button id="submit-123" class="btn btn-sm btn-dark m-1" onclick='storeNIK("{{ $d["id"] }}")'>Perbarui</button>
                            </td>
                            <td>
                                <input type="checkbox" {{ $d["input_status"] ? "checked" : "" }} onclick="updateStatusInputSuara(this, '{{ $d['id'] }}')">
                            </td>
                            <td>
                                <button id="submit-123" class="btn btn-sm btn-dark m-1" onclick="showEditSaksiModal('{{ $d['id'] }}')">Edit</button>
                            </td>
                        </tr>
                    @endforeach
                @endif
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
        function showEditSaksiModal(id) {
            $.ajax({
                type: "get",
                url: '{{ route("hitung_cepat.saksi.edit.list", ["Id" => "ID_PLACEHOLDER"]) }}'.replace("ID_PLACEHOLDER", id),
                success: function(response) {
                    $("#{{ $editSaksiModal }}").modal('show');
                    $("#{{ $editSaksiModal }}").attr('data-tps',id);
                    $("#{{ $editSaksiModal }} .modal-dialog .modal-body p").html(response);
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr["responseJSON"]["message"]
                    });
                },
                complete: function(data) {}
            });
        }
        function updateStatusInputSuara(e, id) {
            const isChecked = e.checked;

            $.ajax({
                type: "get",
                url: '{{ route("hitung_cepat.saksi.status", ["Tps" => "ID_PLACEHOLDER"]) }}'.replace("ID_PLACEHOLDER", id),
                success: function(response) {
                    Toast.fire({
                        icon: "success",
                        title: response["message"]
                    });
                },
                error: function(xhr, status, error) {
                    e.checked = !isChecked;
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr["responseJSON"]["message"]
                    });
                },
                complete: function(data) {}
            });
        }

        function storeNIK(id) {
            TopLoaderService.start();
            const nik = $(`#form-${id}`).val();
            const url = "{{ route('hitung_cepat.saksi.nik') }}";
            $.ajax({
                type: "POST",
                data: {
                    "nik": nik,
                    "tps_id": id,
                },
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                success: function (response) {
                    Toast.fire({
                        icon: "success",
                        title: response["message"]
                    });
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr["responseJSON"]["message"]
                    });
                },
                complete: function(data) {
                    TopLoaderService.end();
                }
            });
        }
    </script>
    <div class="modal fade" id="{{ $editSaksiModal }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Edit Saksi TPS</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div id="{{ $modalBodyEditSaksi }}" class="modal-body">
                    <p></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-dark" id="{{$submitEditSaksi}}">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("#{{ $submitEditSaksi }}").on("click", function(e){
            let data = [];
            $("#{{ $modalBodyEditSaksi }} p input").each(function(){
                let value = $(this).val()
                data.push({
                    id: $(this).attr("data-calon"),
                    value: value
                });
            });
            TopLoaderService.start();
            const url = "{{ route('hitung_cepat.saksi.edit.post', ['Tps' => 'TPS_PLACEHOLDER']) }}".replace("TPS_PLACEHOLDER", $("#{{ $editSaksiModal }}").attr('data-tps'))
            $.ajax({
                type: "POST",
                data: {
                    data
                },
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                success: function (response) {
                    Toast.fire({
                        icon: "success",
                        title: response["message"]
                    });
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr["responseJSON"]["message"]
                    });
                },
                complete: function(data) {
                    $('#{{ $editSaksiModal }}').modal('hide');
                    TopLoaderService.end();
                }
            });
        });
    </script>
