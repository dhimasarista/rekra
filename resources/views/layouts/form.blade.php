@extends('layouts/main')
@section('body')
    @php
        $segments = request()->segments();
    @endphp
    @use('App\Helpers\Formatting')
    <div class="xs-pd-20-10 pd-ltr-20">
        <div class="title pb-20 d-flex justify-content-between align-items-center">
            <h2 class="h2 mb-0">{{ Formatting::capitalize($segments[0]) }}</h2>
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
                            <h4 class="text-blue h4">{{ $config['name'] ?? '' }}</h4>
                            <p class="mb-30"></p>
                        </div>
                    </div>
                    @if ($config)
                        <form>
                            <div class="row">
                                @if ($config['form'])
                                    @foreach ($config['form'] as $index => $form)
                                        <div class="col-md-6">
                                            @if ($form['type'] == 'select')
                                                <div class="form-group">
                                                    <label>{{ $form['name'] }}</label>
                                                    <select data-id="{{ $form['data']['value'] ?? null }}"
                                                        id="{{ $form['id'] }}" class="custom-select2 form-control"
                                                        name="state" style="width: 100%; height: 38px;"
                                                        {{ $form['is_disabled'] ? 'disabled' : '' }}>
                                                        @foreach ($form['options'] as $value)
                                                            <option value="{{ $value['id'] }}"
                                                                {{ ($form['data']['value'] ?? null) == $value['id'] || $value['is_selected'] ? 'selected' : '' }}>
                                                                {{ Formatting::capitalize($value['name']) }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            @elseif ($form['type'] == 'notification')
                                                <div class="alert alert-success" role="alert">
                                                    {{ $form['name'] }}
                                                </div>
                                            @elseif ($form['type'] == 'text')
                                                <div class="form-group">
                                                    <label>{{ $form['name'] }}</label>
                                                    <input id="{{ $form['id'] }}"
                                                        placeholder="{{ $form['data']['placeholder'] ?? null }}"
                                                        value="{{ $form['data']['value'] ?? null }}" type="text"
                                                        class="form-control">
                                                </div>
                                            @elseif ($form['type'] == 'number')
                                                <div class="form-group">
                                                    <label>{{ $form['name'] }}</label>
                                                    <input id="{{ $form['id'] }}"
                                                        placeholder="{{ $form['data']['placeholder'] ?? null }}"
                                                        value="{{ $form['data']['value'] ?? null }}" type="number"
                                                        min="0" class="form-control">
                                                </div>
                                            @elseif ($form['type'] == 'dynamic-input')
                                                <div id="{{ $form['container']['id'] }}">
                                                    <div class="form-group">
                                                        <label for="{{ $form['id'] }}">{{ $form['name'] }}
                                                            @if ($form['button']['show'])
                                                                <a href="javascript:;"
                                                                    id="{{ $form['button']['id'] }}">{{ $form['button']['name'] }}</a>
                                                            @endif
                                                        </label>
                                                        <input type="text" class="form-control" name="fields[]"
                                                            id="{{ $form['id'] }}"
                                                            value="{{ $form['data']['value'] ?? null }}"
                                                            placeholder="{{ $form['data']['placeholder'] ?? null }}">
                                                    </div>
                                                </div>
                                                @if ($form['button']['show'])
                                                    <script>
                                                        $('#{{ $form['button']['id'] }}').click(function() {
                                                            let fieldCount = $('#{{ $form['container']['id'] }} .form-group').length + 1;
                                                            let formGroup = `
                                                            <div class="form-group">
                                                                <input type="text" name="fields[]" class="form-control" id="dynamicField${fieldCount}">
                                                            </div>`;
                                                            $('#{{ $form['container']['id'] }}').append(formGroup);
                                                        });
                                                    </script>
                                                @endif
                                            @endif
                                            @if ($form['for_submit'])
                                                <script>
                                                    let idForm = "{{ $form['id'] }}"; // for submit
                                                </script>
                                            @endif
                                            @if ($form['fetch_data']['is_fetching'])
                                                <script>
                                                    window['{{ $form['id'] }}'] = function() {
                                                        let value = $("#{{ $form['id'] }}").val();
                                                        if (value) {
                                                            $.ajax({
                                                                type: "GET",
                                                                contentType: "application/json",
                                                                dataType: "json",
                                                                url: `{!! url($form['fetch_data']['route']) !!}${value}`,
                                                                success: function(response) {
                                                                    const siblingSelect = $("#{{ $form['fetch_data']['sibling_form_id'] }}");
                                                                    siblingSelect.empty();
                                                                    siblingSelect.append('<option>Pilih</option>');
                                                                    response["{{ $form['fetch_data']['response'] }}"].forEach(val => {
                                                                        let dataId = $("#{{ $form['fetch_data']['sibling_form_id'] }}").attr(
                                                                            "data-id");
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
                                                                }
                                                            });
                                                        }
                                                    }
                                                    $("#{{ $form['id'] }}").on("change", window['{{ $form['id'] }}']);
                                                    // Call the function on page load
                                                    window['{{ $form['id'] }}']();
                                                </script>
                                            @endif
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="form-group row text-right">
                                <label class="col-sm-12 col-md-2 col-form-label"></label>
                                <div id="container-button-submit-form" class="col-sm-12 col-md-10">
                                    <button id="{{ $config['submit']['id'] }}" type="button"
                                        class="btn btn-dark btn-sm scroll-click">submit</button>
                                </div>
                            </div>
                            @if ($config['submit']['type'] == 'redirect')
                                <script>
                                    $("#{{ $config['submit']['id'] }}").on("click", function(e) {
                                        window.location.href = `{{ $config['submit']['route'] }}&Id=${$(`#${idForm}`).val()}`
                                    });
                                </script>
                            @elseif ($config['submit']['type'] == 'input')
                                <script>
                                    $("#{{ $config['submit']['id'] }}").on("click", e => {
                                        const data = @json($config['submit']['form_data']);
                                        let formData = {};
                                        data.forEach((item) => {
                                            if (item.type == "array") {
                                                formData[item.name] = [];
                                                $(`#${item.id} input[name="fields[]"]`).each(function() {
                                                    formData[item.name].push($(this).val());
                                                });
                                            } else {
                                                formData[item.name] = $(`#${item.id}`).val()
                                            }
                                        });
                                        TopLoaderService.start()
                                        $.ajax({
                                            url: `{!! url($config['submit']['route']) !!}`,
                                            type: "{{ $config['submit']['method'] }}",
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
                                                    window.location.replace("{{ $config['submit']['redirect'] }}");
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
                            @endif
                        </form>
                    @endif
                    @empty($config)
                        <h1 class="text-center mb-30">Tidak Ada Data</h1>
                    @endempty
                </div>
                <!-- 2 end -->
            </div>
        </div>
    </div>
@endsection
