@extends('layouts/main')
@section('body')
    <div class="xs-pd-20-10 pd-ltr-20">
        <div class="title pb-20">
            <h2 class="h2 mb-0">Rekapitulasi</h2>
        </div>
        {{-- <div class="row pb-10">
            <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
                <div class="card-box height-100-p widget-style3">
                    <div class="d-flex flex-wrap">
                        <div class="widget-data">
                            <div class="weight-700 font-24 text-dark">1</div>
                            <div class="font-14 text-secondary weight-500">
                                Items
                            </div>
                        </div>
                        <div class="widget-icon">
                            <div class="icon" data-color="#00eccf">
                                <i class="icon-copy bi bi-archive"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
                <div class="card-box height-100-p widget-style3">
                    <div class="d-flex flex-wrap">
                        <div class="widget-data">
                            <div class="weight-700 font-24 text-dark">1</div>
                            <div class="font-14 text-secondary weight-500">
                                Success Orders
                            </div>
                        </div>
                        <div class="widget-icon">
                            <div class="icon" data-color="#ff5b5b">
                                <span class="icon-copy bi bi-view-list"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
                <div class="card-box height-100-p widget-style3">
                    <div class="d-flex flex-wrap">
                        <div class="widget-data">
                            <div class="weight-700 font-24 text-dark">1</div>
                            <div class="font-14 text-secondary weight-500">
                                Fail Orders
                            </div>
                        </div>
                        <div class="widget-icon">
                            <div class="icon">
                                <i class="icon-copy bi bi-arrow-left-square" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
                <div class="card-box height-100-p widget-style3">
                    <div class="d-flex flex-wrap">
                        <div class="widget-data">
                            <div class="weight-700 font-24 text-dark">1</div>
                            <div class="font-14 text-secondary weight-500">Users</div>
                        </div>
                        <div class="widget-icon">
                            <div class="icon" data-color="#09cc06">
                                <i class="icon-copy bi bi-people" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
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
									<label>Jenis Wilayah</label>
									<select id="select-jenis-wilayah" class="custom-select2 form-control" name="state" style="width: 100%; height: 38px;">
                                        <option selected disabled>Pilih</option>
                                        <option value="provinsi">Provinsi</option>
                                        <option value="kabkota">Kab/Kota</option>
									</select>
                                    <script>
                                        let value
                                        $("#select-jenis-wilayah").on("change", e => {
                                            value = $("#select-jenis-wilayah").val()
                                            const url = `/rekapitulasi?Jenis=${$("#select-jenis-wilayah").val()}`
                                            $.ajax({
                                                type: "GET",
                                                contentType: "application/json",
                                                dataType: "json",
                                                url: url,
                                                // data: "data",
                                                success: function (response) {
                                                    const namaWilayah = $("#select-nama-wilayah")
                                                    namaWilayah.empty();
                                                    namaWilayah.append('<option>Pilih</option>');
                                                    response["data"].forEach(x => {
                                                        namaWilayah.append(`<option value="${x.id}">${Formatting.capitalize(x.name)}</option>`);
                                                    });
                                                    namaWilayah.removeAttr("disabled");
                                                }
                                            });
                                        });
                                    </script>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Nama Wilayah</label>
									<select disabled id="select-nama-wilayah" class="custom-select2 form-control" name="state" style="width: 100%; height: 38px;">
									</select>
								</div>
							</div>
						</div>
                        <div class="form-group row text-right">
                            <label class="col-sm-12 col-md-2 col-form-label"></label>
                            <div id="container-button-submit-form" class="col-sm-12 col-md-10">
                                <button id="button-submit-rekap-type" type="button" class="btn btn-dark btn-sm scroll-click">submit</button>
                                <script>
                                    $("#button-submit-rekap-type").on("click", e => {
                                        window.location.replace("/rekapitulasi/list?Id=2171");
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
