@extends('layouts/main')
@section('body')
    @use('Ramsey\Uuid\Uuid')
    @php
        $segments = request()->segments();
        $idSelect1 = Uuid::uuid7();
        $idButtonSubmit = Uuid::uuid7();
    @endphp
    {{-- @dd($idSelect1) --}}
    <div class="xs-pd-20-10 pd-ltr-20">
        <div class="title pb-20 d-flex justify-content-between align-items-center">
            {{-- <h2 class="h2 mb-0">{{ Formatting::capitalize($segments[0]) }}</h2> --}}
            <div class="text-left" style="width: 100%">
                <select id="{{ $idSelect1 }}" class="custom-select col-md-2 m-1">
                    <option disabled selected id="">Choose...</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
                <script>
                    $("#{{ $idSelect1 }}").on("change", (e) => {

                    })
                </script>
                <select class="custom-select col-md-2 m-1">
                    <option disabled selected id="">Choose...</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
                <select class="custom-select col-md-2 m-1">
                    <option disabled selected id="">Choose...</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
                <select class="custom-select col-md-2 m-1">
                    <option disabled selected id="">Choose...</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
                <a id="{{ $idButtonSubmit }}" class="btn btn-dark m-1" href="#">
                    Submit
                </a>
                <script>
                    $("#{{ $idButtonSubmit }}").on("click", (e) => {
                        e.preventDefault();
                        TopLoaderService.start()
                        $.ajax({
                            type: "get",
                            url: "{{ route('hitung_cepat.admin.list') }}",
                            success: function (response) {
                                console.log(response);
                                $("#table-card").html(response)
                            },
                            error: function(xhr, status, error) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: xhr["responseJSON"]["message"]
                                });
                            },
                            complete: function (data){
                                console.log(data);
                                TopLoaderService.end()
                            }
                        });
                    })
                </script>
            </div>
            <div class="text-right">
                {{-- <a class="btn btn-sm btn-dark m-1" href="{{ route('wilayah.form', ['Type' => 'Kabkota']) }}">
                    <i class="fa fa-plus"></i> KabKota
                </a>
                <a class="btn btn-sm btn-dark m-1" href="{{ route('wilayah.form', ['Type' => 'Kecamatan']) }}">
                    <i class="fa fa-plus"></i> Kecamatan
                </a>
                <a class="btn btn-sm btn-dark m-1" href="{{ route('wilayah.form', ['Type' => 'Kelurahan']) }}">
                    <i class="fa fa-plus"></i> Kelurahan
                </a> --}}
            </div>
        </div>
        <div class="row pb-10">
            <div class="col-md-12 mb-20">
                <!-- Export Datatable start -->
                <div id="table-card">
                    <div class="card-box mb-30">
                        <div class="error-page d-flex align-items-center flex-wrap justify-content-center pd-20">
                            <div class="pd-10">
                                <div class="error-page-wrap text-center">
                                    <h2>Belum Ada Data</h2>
                                    <h3>Pilih Data Terlebih Dahulu</h3>
                                    <p>Pilih Tingkat (Provinsi/Kabkota) > Pilih KabKota > Pilih Kecamatan > Pilih Kelurahan > Submit</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Export Datatable End -->
            </div>
            <div class="col-md-4 mb-20">

            </div>
        </div>
    </div>
    <script src="../admin/src/plugins/apexcharts/apexcharts.min.js"></script>
    <script src="../admin/vendors/scripts/dashboard3.js"></script>
@endsection
