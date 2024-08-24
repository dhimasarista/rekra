@extends('layouts/main')
@section('body')
    @php
        // Mendapatkan segment URL untuk digunakan sebagai judul halaman
        $segments = request()->segments();
    @endphp

    @use('App\Helpers\Formatting')
    <div class="xs-pd-20-10 pd-ltr-20">
        <div class="title pb-20 d-flex justify-content-between align-items-center">
            <h2 class="h2 mb-0">{{ Formatting::capitalize($segments[0] ?? 'Default Title') }}</h2>
            <div class="text-right">
                @if ($config["button_helper"]["enable"]  ?? false)
                    @foreach ($config["button_helper"]["button_list"] as $button)
                    <a class="btn btn-sm btn-dark m-1" href="{{ $button["route"] }}">
                        <i class="{{ $button["icon"] }}"></i> {{ $button["name"] }}
                    </a>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="pd-20 card-box mb-30">
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-blue h4">{{ $config['name'] ?? 'Form Title' }}</h4>
                            <p class="mb-30"></p>
                        </div>
                    </div>
                    @if ($config ?? false)
                        <form>
                            <div class="row">
                                @if ($config['form'] ?? false)
                                    @foreach ($config['form'] as $index => $form)
                                        <div class="col-md-6">
                                            @if ($form['type'] == 'select')
                                                <div class="form-group">
                                                    <label>{{ $form['name'] ?? 'Select Field' }}</label>
                                                    <select data-id="{{ $form['data']['value'] ?? null }}"
                                                        id="{{ $form['id'] ?? 'selectField' }}" class="custom-select2 form-control"
                                                        name="state" style="width: 100%; height: 38px;"
                                                        {{ $form['is_disabled'] ? 'disabled' : '' }}>
                                                        @foreach ($form['options'] as $value)
                                                            <option value="{{ $value['id'] }}"
                                                                {{ ($form['data']['value'] ?? null) == $value['id'] || ($value['is_selected'] ?? false) ? 'selected' : '' }}>
                                                                {{ Formatting::capitalize($value['name']) }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            @elseif ($form['type'] == 'notification')
                                                <div class="alert alert-success" role="alert">
                                                    {!! $form['name'] ?? 'Notification Message' !!}
                                                </div>
                                            @elseif ($form['type'] == 'text')
                                                <div class="form-group">
                                                    <label>{{ $form['name'] ?? 'Text Field' }}</label>
                                                    <input id="{{ $form['id'] ?? 'textField' }}"
                                                        placeholder="{{ $form['data']['placeholder'] ?? 'Enter text' }}"
                                                        value="{{ $form['data']['value'] ?? null }}" type="text"
                                                        class="form-control">
                                                </div>
                                            @elseif ($form['type'] == 'number')
                                                <div class="form-group">
                                                    <label>{{ $form['name'] ?? 'Number Field' }}</label>
                                                    <input id="{{ $form['id'] ?? 'numberField' }}"
                                                        placeholder="{{ $form['data']['placeholder'] ?? 'Enter number' }}"
                                                        value="{{ $form['data']['value'] ?? null }}" type="number"
                                                        min="0" class="form-control">
                                                </div>
                                            @elseif ($form['type'] == 'textarea')
                                                <div class="form-group">
                                                    <label>{{ $form['name'] ?? 'Text Area' }}</label>
                                                    <textarea placeholder="{{ $form['data']['placeholder'] ?? null }}" id="{{ $form['id'] ?? '0' }}" class="form-control">{{ $form['data']['value'] ?? null }}</textarea>
                                                </div>
                                            @elseif ($form['type'] == 'dynamic-input')
                                                <div id="{{ $form['container']['id'] ?? 'dynamicContainer' }}">
                                                    <div class="form-group">
                                                        <label for="{{ $form['id'] ?? 'dynamicField' }}">{{ $form['name'] ?? 'Dynamic Field' }}
                                                            @if ($form['button']['show'] ?? false)
                                                                <a href="javascript:;"
                                                                    id="{{ $form['button']['id'] ?? 'addDynamicFieldButton' }}">{{ $form['button']['name'] ?? 'Add More' }}</a>
                                                            @endif
                                                        </label>
                                                        <input type="text" class="form-control" name="fields[]"
                                                            id="{{ $form['id'] ?? 'dynamicField' }}"
                                                            value="{{ $form['data']['value'] ?? null }}"
                                                            placeholder="{{ $form['data']['placeholder'] ?? 'Enter value' }}">
                                                    </div>
                                                </div>
                                                @if ($form['button']['show'] ?? false)
                                                    <script>
                                                        $('#{{ $form['button']['id'] ?? 'addDynamicFieldButton' }}').click(function() {
                                                            let fieldCount = $('#{{ $form['container']['id'] ?? 'dynamicContainer' }} .form-group').length + 1;
                                                            let formGroup = `
                                                            <div class="form-group">
                                                                <input type="text" name="fields[]" class="form-control" id="dynamicField${fieldCount}">
                                                            </div>`;
                                                            $('#{{ $form['container']['id'] ?? 'dynamicContainer' }}').append(formGroup);
                                                        });
                                                    </script>
                                                @endif
                                            @endif
                                            @if ($form['for_submit'] ?? false)
                                                <script>
                                                    let idForm = "{{ $form['id'] ?? 'formField' }}"; // ID yang digunakan untuk submit
                                                </script>
                                            @endif
                                            @if ($form['fetch_data']['is_fetching'] ?? false)
                                                <script>
                                                    window['{{ $form['id'] ?? 'fetchFunction' }}'] = function() {
                                                        let value = $("#{{ $form['id'] ?? 'selectField' }}").val();
                                                        if (value) {
                                                            $.ajax({
                                                                type: "GET",
                                                                contentType: "application/json",
                                                                dataType: "json",
                                                                url: `{!! url($form['fetch_data']['route'] ?? '/fetch-data') !!}${value}`,
                                                                success: function(response) {
                                                                    const siblingSelect = $("#{{ $form['fetch_data']['sibling_form_id'] ?? 'siblingSelect' }}");
                                                                    siblingSelect.empty();
                                                                    siblingSelect.append('<option>Pilih</option>');
                                                                    response["{{ $form['fetch_data']['response'] ?? 'data' }}"].forEach(val => {
                                                                        let dataId = $("#{{ $form['fetch_data']['sibling_form_id'] ?? 'siblingSelect' }}").attr("data-id");
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
                                                    $("#{{ $form['id'] ?? 'selectField' }}").on("change", window['{{ $form['id'] ?? 'fetchFunction' }}']);
                                                    // Panggil fungsi saat halaman dimuat
                                                    window['{{ $form['id'] ?? 'fetchFunction' }}']();
                                                </script>
                                            @endif
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="form-group row text-right">
                                <label class="col-sm-12 col-md-2 col-form-label"></label>
                                <div id="container-button-submit-form" class="col-sm-12 col-md-10">
                                    <button id="{{ $config['submit']['id'] ?? 'submitForm' }}" type="button"
                                        class="btn btn-dark btn-sm scroll-click">{{ $config['submit']['name'] ?? 'submit' }}</button>
                                </div>
                            </div>
                            @if (($config['submit']['type'] ?? '') == 'redirect')
                                <script>
                                    $("#{{ $config['submit']['id'] ?? 'submitForm' }}").on("click", function(e) {
                                        window.location.href = `{{ $config['submit']['route'] ?? '/redirect-url' }}&Id=${$(`#${idForm}`).val()}`
                                    });
                                </script>
                            @elseif (($config['submit']['type'] ?? '') == 'input')
                                <script>
                                    $("#{{ $config['submit']['id'] ?? 'submitForm' }}").on("click", e => {
                                        const data = @json($config['submit']['form_data'] ?? []);
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
                                            url: `{!! url($config['submit']['route'] ?? '/submit-url') !!}`,
                                            type: "{{ $config['submit']['method'] ?? 'POST' }}",
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
                                                    window.location.replace("{!! $config['submit']['redirect'] ?? '/redirect-url' !!}");
                                                });
                                            },
                                            error: function(xhr, status, error) {
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'Error',
                                                    text: 'An error occurred while processing your request.'
                                                });
                                            },
                                            complete: function() {
                                                TopLoaderService.stop();
                                            }
                                        });
                                    });
                                </script>
                            @endif
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
