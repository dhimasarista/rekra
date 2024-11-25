@use('App\Helpers\Formatting')
@php
    $idSelect1 = 'X' . bin2hex(random_bytes(8));
    $idSelect2 = 'X' . bin2hex(random_bytes(8));
    $idSelect3 = 'X' . bin2hex(random_bytes(8));
    $idSelect4 = 'X' . bin2hex(random_bytes(8));
    $idSelect5 = 'X' . bin2hex(random_bytes(8));
    $idButtonSubmit = 'X' . bin2hex(random_bytes(8));
@endphp
@if ($jenisWilayah == 'Provinsi')
    <select id="{{ $idSelect1 }}" class="custom-select col-md-2 m-1">
        <option disabled selected id="">Pilih Provinsi</option>
        @foreach ($data as $provinsi)
            <option value="{{ $provinsi->id }}">{{ Formatting::capitalize($provinsi->name) }}</option>
        @endforeach
    </select>
@elseif ($jenisWilayah == 'Kabkota')
    <select id="{{ $idSelect1 }}" class="custom-select col-md-2 m-1">
        <option disabled selected id="">Pilih Provinsi</option>
        @foreach ($data as $provinsi)
            <option value="{{ $provinsi->id }}">{{ Formatting::capitalize($provinsi->name) }}</option>
        @endforeach
    </select>
    <select id="{{ $idSelect2 }}" class="custom-select col-md-2 m-1" disabled></select>
@elseif ($jenisWilayah == 'Kecamatan')
    <select id="{{ $idSelect1 }}" class="custom-select col-md-2 m-1">
        <option disabled selected id="">Pilih Provinsi</option>
        @foreach ($data as $provinsi)
            <option value="{{ $provinsi->id }}">{{ Formatting::capitalize($provinsi->name) }}</option>
        @endforeach
    </select>
    <select id="{{ $idSelect2 }}" class="custom-select col-md-2 m-1" disabled>
    </select>
    <select id="{{ $idSelect3 }}" class="custom-select col-md-2 m-1" disabled>
    </select>
@elseif ($jenisWilayah == 'Kelurahan')
<select id="{{ $idSelect1 }}" class="custom-select col-md-2 m-1">
        <option disabled selected id="">Pilih Provinsi</option>
        @foreach ($data as $provinsi)
            <option value="{{ $provinsi->id }}">{{ Formatting::capitalize($provinsi->name) }}</option>
        @endforeach
    </select>
    <select id="{{ $idSelect2 }}" class="custom-select col-md-2 m-1" disabled></select>
    <select id="{{ $idSelect3 }}" class="custom-select col-md-2 m-1" disabled></select>
    <select id="{{ $idSelect4 }}" class="custom-select col-md-2 m-1" disabled></select>
@elseif ($jenisWilayah == 'TPS')
    <select id="{{ $idSelect1 }}" class="custom-select col-md-1 m-1"
        style="width: 12.499999995%;flex: 0 0 12.499%;max-width: 12.499%;">
        <option disabled selected id="">Pilih Provinsi</option>
        @foreach ($data as $provinsi)
            <option value="{{ $provinsi->id }}">{{ Formatting::capitalize($provinsi->name) }}</option>
        @endforeach
    </select>
    <select id="{{ $idSelect2 }}" class="custom-select col-md-2 m-1" disabled></select>
    <select id="{{ $idSelect3 }}" class="custom-select col-md-2 m-1" disabled></select>
    <select id="{{ $idSelect4 }}" class="custom-select col-md-2 m-1" disabled></select>
    <select id="{{ $idSelect5 }}" class="custom-select col-md-1 m-1" disabled></select>
@endif
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
                siblingSelect.append('<option>Pilih kecamatan</option>');
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
    $("#{{ $idSelect4 }}").on("change", function(e) {
        let selectedValue = $(this).val();
        let url = `{!! route('wilayah.find', ['Type' => 'TPS', 'Id' => 'ID_PLACEHOLDER']) !!}`.replace(
            'ID_PLACEHOLDER', selectedValue);
        $.ajax({
            type: "get",
            url: url,
            success: function(response) {
                const siblingSelect = $("#{{ $idSelect5 }}");
                siblingSelect.empty();
                siblingSelect.append('<option>Pilih TPS</option>');
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
