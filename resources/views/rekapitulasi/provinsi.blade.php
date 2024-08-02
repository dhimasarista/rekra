@extends('layouts/main')
@section('body')
    <div class="xs-pd-20-10 pd-ltr-20">
        <div class="title pb-20">
            <h2 class="h2 mb-0">Rekapitulasi Provinsi</h2>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="pd-20 card-box mb-30">
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-blue h4">Wilayah Rekapitulasi</h4>
                            <p class="mb-30"></p>
                        </div>
                    </div>
                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Negara</label>
                                    <select id="select-nama-negara" class="custom-select2 form-control" name="state"
                                        style="width: 100%; height: 38px;" disabled>
                                        <option>Pilih</option>
                                        <option value="1" selected>Indonesia</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Provinsi</label>
                                    <select id="select-nama-provinsi" class="custom-select2 form-control" name="state"
                                        style="width: 100%; height: 38px;">
                                        <option selected disabled>Pilih</option>
                                        @foreach ($provinsi as $p)
                                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row text-right">
                            <label class="col-sm-12 col-md-2 col-form-label"></label>
                            <div id="container-button-submit-form" class="col-sm-12 col-md-10">
                                <button id="button-submit-provinsi" type="button"
                                    class="btn btn-dark btn-sm scroll-click">submit</button>
                                <script>
                                    $("#button-submit-provinsi").on("click", e => {
                                        window.location.href =
                                            `{{ route('rekap.list', ['Type' => 'Provinsi']) }}&Id=${$("#select-nama-provinsi").val()}`
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
