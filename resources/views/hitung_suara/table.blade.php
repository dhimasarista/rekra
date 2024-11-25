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
                                    <a class="btn btn-sm btn-dark m-1" href="#"
                                        onclick="showModalForm('{{ $d['id'] }}', 'Provinsi')">
                                        <i class="fa fa-plus"></i> Provinsi
                                    </a>
                                @endif
                                <a class="btn btn-sm btn-dark m-1" href="#"
                                    onclick="showModalForm('{{ $d['id'] }}', 'Kabkota')">
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

        </div>
    </div>
</div>
<script>
    function showModalForm(tps, type) {
        $.ajax({
            type: "get",
            url: '{!! route('hitung_suara.form', ['Tps' => 'TPS_PLACEHOLDER', 'Type' => 'TYPE_PLACEHOLDER']) !!}'
                .replace("TPS_PLACEHOLDER", tps).replace("TYPE_PLACEHOLDER", type),
            success: function(response) {
                $("#{{ $idModal }}").modal('show');
                // $("#{{ $idModal }}").attr('data-tps', id);
                $("#{{ $idModal }} .modal-content").html(response);
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
</script>
