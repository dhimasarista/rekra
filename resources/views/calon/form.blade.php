@extends('layouts/main')
@section('body')
    <div class="xs-pd-20-10 pd-ltr-20">
        <div class="title pb-20 d-flex justify-content-between align-items-center">
            <h2 class="h2 mb-0">Calon</h2>
            <div class="text-right">
                <a class="btn btn-sm btn-dark" href="{{ url()->previous() }}">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="pd-20 card-box mb-30">
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-blue h4">Form</h4>
                            <p class="mb-30"></p>
                        </div>
                    </div>
                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Calon</label>
                                    <input id="nama-calon" value="{{ $calon ? "$calon->calon_name" : '' }}" type="text"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Pasangan</label>
                                    <input id="nama-pasangan" value="{{ $calon ? "$calon->wakil_name" : '' }}"
                                        type="text" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Jenis Wilayah</label>
                                    <select id="select-jenis-wilayah" class="custom-select2 form-control" name="state"
                                        style="width: 100%; height: 38px;">
                                        <option {{ $calon ? '' : 'selected' }} disabled>Pilih</option>
                                        <option {{ isset($calon) && $calon->level == 'provinsi' ? 'selected' : '' }}
                                            value="Provinsi">Provinsi</option>
                                        <option {{ isset($calon) && $calon->level == 'kabkota' ? 'selected' : '' }}
                                            value="Kabkota">Kab/Kota</option>
                                    </select>
                                    <script>
                                        const selectJenisWilayah = () => {
                                            let value = @json($calon ? $calon->code : null);
                                            const url = `/wilayah-pemilihan/list?Type=${$("#select-jenis-wilayah").val()}`
                                            $.ajax({
                                                type: "GET",
                                                contentType: "application/json",
                                                dataType: "json",
                                                url: url,
                                                // data: "data",
                                                success: function(response) {
                                                    if (response.data) {
                                                        const namaWilayah = $("#select-nama-wilayah")
                                                        namaWilayah.empty();
                                                        namaWilayah.append('<option>Pilih</option>');
                                                        response["data"].forEach(x => {
                                                            const selectedOpt = x.id === value ? "selected" : "";
                                                            namaWilayah.append(
                                                                `<option ${selectedOpt} value="${x.id}">${Formatting.capitalize(x.name)}</option>`
                                                            );
                                                        });
                                                        namaWilayah.removeAttr("disabled");
                                                    }
                                                }
                                            });
                                        }
                                        selectJenisWilayah()
                                        $("#select-jenis-wilayah").on("change", e => {
                                            selectJenisWilayah()
                                        });
                                    </script>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Wilayah</label>
                                    <select disabled id="select-nama-wilayah" class="custom-select2 form-control"
                                        name="state" style="width: 100%; height: 38px;">
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row text-right">
                            <label class="col-sm-12 col-md-2 col-form-label"></label>
                            <div id="container-button-submit-form" class="col-sm-12 col-md-10">
                                <button id="submit-form-calon" type="button"
                                    class="btn btn-dark btn-sm scroll-click">submit</button>
                                <script>
                                    $("#submit-form-calon").on("click", e => {
                                        const id = @json(request()->query('Id'));
                                        var formData = {
                                            calon_name: $('#nama-calon').val(), // Adjust according to the selected company id
                                            wakil_name: $('#nama-pasangan').val(),
                                            level: $('#select-jenis-wilayah').val(),
                                            code: $("#select-nama-wilayah").val(),
                                        };
                                        TopLoaderService.start()
                                        $.ajax({
                                            url: id ? `/calon?Id=${id}` : "/calon",
                                            type: "POST",
                                            data: formData,
                                            dataType: 'json',
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            },
                                            success: function(response) {
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: 'Success',
                                                    text: response.message
                                                }).then(() => {
                                                    window.location.replace("/calon");
                                                });
                                            },
                                            error: function(xhr, status, error) {
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'Error',
                                                    text: xhr.responseJSON.message ?? error
                                                });
                                            },
                                            complete: data => {
                                                TopLoaderService.end()
                                            }
                                        });
                                    })
                                </script>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- Select-2 end -->
            </div>
        </div>
    </div>
@endsection
