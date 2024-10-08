@use('App\Helpers\Formatting')
<div class="form-group row">
    <div class="col-md-12 col-sm-12">
        <div class="title" style="padding-bottom: 20px">
            <h4>{{ $tps->name }}</h4>
            <h5>{{ Formatting::capitalize("$tps->kelurahan_name - $tps->kecamatan_name - $tps->kabkota_name") }}</h5>
        </div>
    </div>
    @if ($data)
        @foreach ($data as $d)
            @php
                $calon = Formatting::capitalize($d->calon->calon_name." - ".$d->calon->wakil_name)
            @endphp
            <div class="mb-2 col-md-12">
                <label class="col-sm-12 col-md-12">{{ $calon }}</label>
                <div class="col-sm-12 col-md-12">
                    <input data-id="{{ $d->id }}" data-calon="{{ $d->calon_id }}" class="form-control" type="number" min="0" value="{{ $d->amount ?? 0 }}" placeholder="Masukkan Suara">
                </div>
            </div>
        @endforeach
    @endif
</div>
