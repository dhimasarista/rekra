@use('Ramsey\Uuid\Uuid')
@use('App\Helpers\Formatting')
@php
    $segments = request()->segments();
    $idSelect1 = Uuid::uuid7();
    $idSelect2 = Uuid::uuid7();
@endphp
<select id="{{ $idSelect1 }}" class="custom-select col-md-2 m-1">
    <option disabled selected>Pilih Provinsi</option>
    @if ($provinsi)
        @foreach ($provinsi as $p)
            <option value="{{ $p->id }}">{{ Formatting::capitalize($p->name) }}</option>
        @endforeach
    @endif
</select>
@if ($type === "Kabkota" || $type === "kabkota")
<select id="{{ $idSelect2 }}" class="custom-select col-md-2 m-1">
    <option disabled selected>Pilih Kabkota</option>
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
                siblingSelect.append('<option disabled selected>Pilih Kabkota</option>');
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
@endif
