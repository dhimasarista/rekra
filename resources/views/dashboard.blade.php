@extends('layouts/main')
@section('body')
    <div class="xs-pd-20-10 pd-ltr-20">
        <div class="title pb-20">
            <h2 class="h2 mb-0">Rekapitulasi</h2>
        </div>
        <div class="row pb-10">
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
									<label>Jenis Wilayah</label>
									<select class="custom-select2 form-control" name="state" style="width: 100%; height: 38px;">
                                        <option selected disabled>Pilih</option>
                                        <option value="AK">Provinsi</option>
                                        <option value="HI">Kab/Kota</option>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Nama Wilayah</label>
									<select class="custom-select2 form-control" name="state" style="width: 100%; height: 38px;">
                                        <option value="AK">Kota Batam</option>
                                        <option value="HI">Kab. Karimun</option>
									</select>
								</div>
							</div>
						</div>
					</form>
				</div>
				<!-- Select-2 end -->
            </div>
        </div>

        <div class="row pb-10">
            <div class="col-md-8 mb-20">
                <!-- Export Datatable start -->
				<div class="card-box mb-30">
					<div class="pd-20">
						<h4 class="text-blue h4">Provinsi</h4>
					</div>
					<div class="pb-20">
						<table id="provinsi-table" class="table hover responsive multiple-select-row data-table-export nowrap">
							<thead>
								<tr>
									<th class="table-plus datatable-nosort">Nomor</th>
									<th>Nama Calon</th>
									<th>Total</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
                                <tr>
                                    <td>0</td>
                                    <td>Dhimas-Ibna</td>
                                    <td>2,390</td>
                                    <td></td>
                                </tr>
                            </tbody>
						</table>
					</div>
				</div>
                <script>
                    $("#provinsi-table").DataTable({})
                </script>
				<!-- Export Datatable End -->
            </div>
            <div class="col-md-4 mb-20">

            </div>
        </div>
    </div>
    <script src="../admin/src/plugins/apexcharts/apexcharts.min.js"></script>
    <script src="../admin/vendors/scripts/dashboard3.js"></script>
@endsection
