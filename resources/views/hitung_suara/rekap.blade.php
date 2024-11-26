@extends('layouts/main')
@section('body')
    @use('App\Helpers\Formatting')
    @php
        $segments = request()->segments();
        $idSelect1 = 'X' . bin2hex(random_bytes(8));
        $idContainerSelect = 'X' . bin2hex(random_bytes(8));
        $idButtonSubmit = 'X' . bin2hex(random_bytes(8));
    @endphp
    <div class="xs-pd-20-10 pd-ltr-20">
        <div class="title pb-20 d-flex justify-content-between align-items-center">
            <div class="text-left" style="width: 100%">
                <select id="{{ $idSelect1 }}" class="custom-select col-md-1"
                    style="width: 12.499999995%;flex: 0 0 12.499%;max-width: 12.499%;">
                    <option disabled selected id="">Pilih Jenis Wilayah</option>
                    <option value="Provinsi">Provinsi</option>
                    <option value="Kabkota">Kabubapten/Kota</option>
                    <option value="Kecamatan">Kecamatan</option>
                    <option value="Kelurahan">Desa/Kelurahan</option>
                    <option value="TPS">TPS</option>
                </select>
                <script>
                    $("#{{ $idSelect1 }}").on("change", function(e) {
                        e.preventDefault()

                        $.ajax({
                            type: "get",
                            url: "{!! route('hitung_suara.rekap.select_tingkat', ['Select' => 'SELECT_PLACEHOLDER']) !!}".replace("SELECT_PLACEHOLDER", $(this).val()),
                            success: function(response) {
                                $("#{{ $idContainerSelect }}").html(response)
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
                <span id="{{ $idContainerSelect }}"></span>
                <button id="{{ $idButtonSubmit }}" class="btn btn-dark m-1" disabled>Tampilkan</button>
            </div>
        </div>
        @php
            $target = 'X' . bin2hex(random_bytes(8));
        @endphp
        <div id="{{ $target }}">
            <div class="image-container">
                <img id="myImage" src="https://i.pinimg.com/originals/ea/db/74/eadb74787dda41cc6333341e55293432.gif"
                    alt="Image">
            </div>
            <style>
                .image-container {
                    position: relative;
                    overflow: hidden;
                    /* Membatasi area yang terlihat */
                    width: 100%;
                    /* Menggunakan lebar penuh */
                    aspect-ratio: 16 / 9;
                    /* Menjaga rasio aspek */
                    /* Latar belakang untuk transparansi */
                }

                #myImage {
                    position: absolute;
                    top: -40%;
                    /* Crop 10% bagian atas */
                    bottom: -40%;
                    /* Crop 10% bagian bawah */
                    left: 0;
                    right: 0;
                    width: 100%;
                    /* Memastikan gambar sesuai lebar kontainer */
                    object-fit: cover;
                    /* Menghindari distorsi */
                }
            </style>
        </div>
        <script>
            $("#{{ $idButtonSubmit }}").on("click", function(e) {
                e.preventDefault();
                // TopLoaderService.start();
                let typeRekap = $("#{{ $idSelect1 }}").val();
                let tingkat = $("#{{ $idContainerSelect }} .custom-select:first").val();
                let lastId = $("#{{ $idContainerSelect }} .custom-select:last").val();
                let url = `{!! route('hitung_suara.rekap_list', [
                    'Type' => 'TYPE_PLACEHOLDER',
                    'Tingkat' => 'TINGKAT_PLACEHOLDER',
                    'Id' => 'ID_PLACEHOLDER',
                ]) !!}`
                    .replace("TYPE_PLACEHOLDER", typeRekap)
                    .replace("TINGKAT_PLACEHOLDER", tingkat)
                    .replace('ID_PLACEHOLDER', lastId);
                $.ajax({
                    type: "get",
                    url: url,
                    success: function(response) {
                        $("#{{ $target }}").html(response)
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

            });
        </script>
    </div>
@endsection
