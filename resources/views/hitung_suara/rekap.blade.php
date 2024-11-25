@extends('layouts/main')
@section('body')
    @use('App\Helpers\Formatting')
    @php
        $segments = request()->segments();
        $idSelect1 = 'X' . bin2hex(random_bytes(8));
        $idContainerSelect2 = 'X' . bin2hex(random_bytes(8));
        $idButtonSubmit = 'X' . bin2hex(random_bytes(8));
    @endphp
    <div class="xs-pd-20-10 pd-ltr-20">
        <div class="title pb-20 d-flex justify-content-between align-items-center">
            <div class="text-left" style="width: 100%">
                <select id="{{ $idSelect1 }}" class="custom-select col-md-1" style="width: 12.499999995%;flex: 0 0 12.499%;max-width: 12.499%;">
                    <option disabled selected id="">Pilih Jenis Wilayah</option>
                    <option value="Provinsi">Provinsi</option>
                    <option value="Kabkota">Kabubapten/Kota</option>
                    <option value="Kecamatan">Kecamatan</option>
                    <option value="Kelurahan">Desa/Kelurahan</option>
                    <option value="TPS">TPS</option>
                </select>
                <script>
                    $("#{{ $idSelect1 }}").on("change", function (e) {
                        e.preventDefault()

                        $.ajax({
                            type: "get",
                            url: "{!! route('hitung_suara.rekap.select_tingkat', ['Select' => 'SELECT_PLACEHOLDER']) !!}".replace("SELECT_PLACEHOLDER", $(this).val()),
                            success: function (response) {
                                $("#{{ $idContainerSelect2 }}").html(response)
                                $("#{{ $idButtonSubmit }}").removeAttr("disabled")
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
                    })
                </script>
                <span id="{{ $idContainerSelect2 }}"></span>
                <button id="{{ $idButtonSubmit }}" class="btn btn-dark m-1" disabled>Tampilkan</button>
            </div>
        </div>
    </div>
@endsection
