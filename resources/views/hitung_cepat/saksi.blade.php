@extends('layouts/main')
@section('body')
    @use('Ramsey\Uuid\Uuid')
    @use('App\Helpers\Formatting')
    @php
        $segments = request()->segments();
        $idSelect1 = Uuid::uuid7();
        $idSelect2 = Uuid::uuid7();
        $idSelect3 = Uuid::uuid7();
        $idSelect4 = Uuid::uuid7();
        $idButtonSubmit = Uuid::uuid7();
    @endphp
    {{-- @dd($idSelect1) --}}
    <div class="xs-pd-20-10 pd-ltr-20">
        <div class="title pb-20 d-flex justify-content-between align-items-center">
            {{-- <h2 class="h2 mb-0">{{ Formatting::capitalize($segments[0]) }}</h2> --}}
            <div class="text-left" style="width: 100%">
                <select id="{{ $idSelect1 }}" class="custom-select col-md-2 m-1">
                    <option disabled selected id="">Pilih Provinsi</option>
                    @foreach ($provinsi as $p)
                        <option value="{{ $p->id }}">{{ Formatting::capitalize($p->name) }}</option>
                    @endforeach
                </select>
                <script>
                    $("#{{ $idSelect1 }}").on("change", function(e) {
                        let selectedValue = $(this).val();
                        let url = `{!! route('wilayah.find', ['Type' => 'Kabkota', 'Id' => 'ID_PLACEHOLDER']) !!}`.replace(
                            'ID_PLACEHOLDER', selectedValue);
                        $.ajax({
                            type: "get",
                            url: url,
                            success: function(response) {
                                const siblingSelect = $("#{{ $idSelect2 }}");
                                siblingSelect.empty();
                                siblingSelect.append('<option>Pilih Kabkota</option>');
                                response["data"].forEach(val => {
                                    let dataId = $(
                                        "#{{ $form['fetch_data']['sibling_form_id'] ?? 'siblingSelect' }}"
                                    ).attr("data-id");
                                    if (parseInt(dataId) == val.id) {
                                        option =
                                            `<option value="${val.id}" selected>${Formatting.capitalize(val.name)}</option>`
                                    } else {
                                        option =
                                            `<option value="${val.id}">${Formatting.capitalize(val.name)}</option>`
                                    }
                                    siblingSelect.append(option);
                                });
                                siblingSelect.removeAttr("disabled");
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
                <select id="{{ $idSelect2 }}" class="custom-select col-md-2 m-1" disabled>
                    <option disabled selected></option>
                </select>
                <script>
                    $("#{{ $idSelect2 }}").on("change", function(e) {
                        let selectedValue = $(this).val();
                        let url = `{!! route('wilayah.find', ['Type' => 'Kecamatan', 'Id' => 'ID_PLACEHOLDER']) !!}`.replace(
                            'ID_PLACEHOLDER', selectedValue);
                        $.ajax({
                            type: "get",
                            url: url,
                            success: function(response) {
                                const siblingSelect = $("#{{ $idSelect3 }}");
                                siblingSelect.empty();
                                siblingSelect.append('<option>Pilih Kecamatan</option>');
                                response["data"].forEach(val => {
                                    let dataId = $(
                                        "#{{ $form['fetch_data']['sibling_form_id'] ?? 'siblingSelect' }}"
                                    ).attr("data-id");
                                    if (parseInt(dataId) == val.id) {
                                        option =
                                            `<option value="${val.id}" selected>${Formatting.capitalize(val.name)}</option>`
                                    } else {
                                        option =
                                            `<option value="${val.id}">${Formatting.capitalize(val.name)}</option>`
                                    }
                                    siblingSelect.append(option);
                                });
                                siblingSelect.removeAttr("disabled");
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
                <select id="{{ $idSelect3 }}" class="custom-select col-md-2 m-1" disabled>
                    <option disabled selected></option>
                </select>
                <script>
                    $("#{{ $idSelect3 }}").on("change", function(e) {
                        let selectedValue = $(this).val();
                        let url = `{!! route('wilayah.find', ['Type' => 'Kelurahan', 'Id' => 'ID_PLACEHOLDER']) !!}`.replace(
                            'ID_PLACEHOLDER', selectedValue);
                        $.ajax({
                            type: "get",
                            url: url,
                            success: function(response) {
                                const siblingSelect = $("#{{ $idSelect4 }}");
                                siblingSelect.empty();
                                siblingSelect.append('<option>Pilih Kelurahan</option>');
                                response["data"].forEach(val => {
                                    let dataId = $(
                                        "#{{ $form['fetch_data']['sibling_form_id'] ?? 'siblingSelect' }}"
                                    ).attr("data-id");
                                    if (parseInt(dataId) == val.id) {
                                        option =
                                            `<option value="${val.id}" selected>${Formatting.capitalize(val.name)}</option>`
                                    } else {
                                        option =
                                            `<option value="${val.id}">${Formatting.capitalize(val.name)}</option>`
                                    }
                                    siblingSelect.append(option);
                                });
                                siblingSelect.removeAttr("disabled");
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
                <select id="{{ $idSelect4 }}" class="custom-select col-md-2 m-1" disabled>
                    <option disabled selected></option>
                </select>
                <script>
                    $("#{{ $idSelect4 }}").on("change", function(e) {
                        $("#{{ $idButtonSubmit }}").removeAttr("disabled")
                    })
                </script>
                <button id="{{ $idButtonSubmit }}" class="btn btn-dark m-1" disabled>Input</button>
                <script>
                    $("#{{ $idButtonSubmit }}").on("click", (e) => {
                        e.preventDefault();
                        TopLoaderService.start()
                        let idQuery = $("#{{ $idSelect4 }} ").val();
                        let typeQuery = "Kelurahan";
                        let url = `{!! $urlSubmit !!}`.replace("TYPE_PLACEHOLDER", typeQuery).replace(
                            'ID_PLACEHOLDER', idQuery);
                        $.ajax({
                            type: "get",
                            url: url,
                            success: function(response) {
                                $("#table-card").html(response)
                            },
                            error: function(xhr, status, error) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: xhr["responseJSON"]["message"]
                                });
                            },
                            complete: function(data) {
                                TopLoaderService.end()
                            }
                        });
                    })
                </script>
            </div>
            <div class="text-right">
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
                                    <p>Pilih Provinsi > Pilih KabKota > Pilih Kecamatan > Pilih Kelurahan > Submit</p>
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
@endsection