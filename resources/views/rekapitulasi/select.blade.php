@extends('layouts/main')
@section('body')
    @php
        $segments = request()->segments();
    @endphp
    @use('App\Helpers\Formatting')
    <div class="xs-pd-20-10 pd-ltr-20">
        <div class="title pb-20">
            <h2 class="h2 mb-0">{{ Formatting::capitalize($segments[0]) }}</h2>
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
                                @foreach ($config['form'] as $index => $form)
                                    <div class="col-md-6">
                                        @if ($form['type'] == 'select')
                                            <div class="form-group">
                                                <label>{{ $form['name'] }}</label>
                                                <select id="{{ $form['id'] }}" class="custom-select2 form-control"
                                                    name="state" style="width: 100%; height: 38px;"
                                                    {{ $form['is_disabled'] ? 'disabled' : '' }}>
                                                    @foreach ($form['options'] as $value)
                                                        <option value="{{ $value['id'] }}"
                                                            {{ $value['is_selected'] ? 'selected' : '' }}>
                                                            {{ Formatting::capitalize($value['name']) }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @elseif ($form['type'] == 'text')
                                            <div class="form-group">
                                                <label>Username</label>
                                                <input id="{{ $form['id'] }}" value="{{ $form['name'] ?? '' }}"
                                                    type="text" class="form-control">
                                            </div>
                                        @endif

                                        @if ($form['for_submit'])
                                            <script>
                                                let idForm = "{{ $form['id'] }}"; // for submit
                                            </script>
                                        @endif
                                        @if ($form['fetch_data']['is_fetching'] == 'true')
                                            <script>
                                                $("#{{ $form['id'] }}").on("change", function(e) {
                                                    let value = $(this).val();
                                                    $.ajax({
                                                        type: "GET",
                                                        contentType: "application/json",
                                                        dataType: "json",
                                                        url: `{{ url($form['fetch_data']['route']) }}${value}`,
                                                        success: function(response) {
                                                            const siblingSelect = $("#{{ $form['fetch_data']['sibling_form_id'] }}");
                                                            siblingSelect.empty();
                                                            siblingSelect.append('<option>Pilih</option>');
                                                            response["{{ $form['fetch_data']['type'] }}"].forEach(val => {
                                                                siblingSelect.append(
                                                                    `<option value="${val.id}">${Formatting.capitalize(val.name)}</option>`
                                                                );
                                                            });
                                                            siblingSelect.removeAttr("disabled");
                                                        }
                                                    });
                                                });
                                            </script>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            <div class="form-group row text-right">
                                <label class="col-sm-12 col-md-2 col-form-label"></label>
                                <div id="container-button-submit-form" class="col-sm-12 col-md-10">
                                    <button id="{{ $config['submit']['id'] }}" type="button"
                                        class="btn btn-dark btn-sm scroll-click">submit</button>
                                    <script>
                                        $("#{{ $config['submit']['id'] }}").on("click", function(e) {
                                            window.location.href = `{{ $config['submit']['route'] }}&Id=${$(`#${idForm}`).val()}`
                                        });
                                    </script>
                                </div>
                            </div>
                        </form>
                    @endif
                    @empty($config)
                        <h1 class="text-center mb-20">Tidak Ada Data</h1>
                    @endempty
                </div>
                <!-- 2 end -->
            </div>
        </div>
    </div>
@endsection
