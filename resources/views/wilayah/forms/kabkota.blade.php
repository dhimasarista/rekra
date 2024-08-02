@extends('layouts/main')
@section('body')
    <div class="xs-pd-20-10 pd-ltr-20">
        <div class="title pb-20 d-flex justify-content-between align-items-center">
            <h2 class="h2 mb-0">Calon</h2>
            <div class="text-right">
                <a class="btn btn-sm btn-dark" href="{{ route('wilayah.index') }}">
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
                                    <label>ID<span class="text-danger">*</span></label>
                                    <input id="kabkota-id" value="{{ $data ? "$data->id" : '' }}" type="text"
                                        class="form-control" placeholder="Wajib diisi" @required(true)>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Kabupaten/Kota<span class="text-danger">*</span></label>
                                    <input id="kabkota-name" value="{{ $data ? "$data->name" : '' }}" type="text"
                                        class="form-control" placeholder="Wajib diisi" @required(true)>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Jenis Wilayah<span class="text-danger">*</span></label>
                                    <select id="select-provinsi" class="custom-select2 form-control" name="state"
                                        style="width: 100%; height: 38px;">
                                        <option {{ $data ? '' : 'selected' }} disabled>Pilih</option>
                                        @foreach ($dataWilayah as $dw)
                                            <option {{ isset($data) && $data->provinsi_id == $dw->id ? 'selected' : '' }}
                                                value="{{ $dw->id }}">{{ $dw->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="row">
                            <div class="col-md-6">
                                <span class="text-danger"><i>*Required</i></span>
                            </div>
                        </div> --}}
                        <div class="form-group row text-right">
                            <label class="col-sm-12 col-md-2 col-form-label"></label>
                            <div id="container-button-submit-form" class="col-sm-12 col-md-10">
                                <button id="submit-form-kabkota" type="button"
                                    class="btn btn-dark btn-sm scroll-click">submit</button>
                                <script>
                                    $("#submit-form-kabkota").on("click", e => {
                                        const id = @json(request()->query('Id'));
                                        var formData = {
                                            id: $('#kabkota-id').val(), // Adjust according to the selected company id
                                            name: $('#kabkota-name').val(),
                                            provinsi_id: $('#select-provinsi').val(),
                                        };
                                        TopLoaderService.start()
                                        $.ajax({
                                            url: {{ route('wilayah.post', ['Id' => request()->query('Id'), 'Type' => 'Kabkota']) }},
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
                                                    window.location.replace("{{ route('wilayah.index', []) }}");
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
