@use('App\Helpers\Formatting')
<div class="form-group row">
    <div class="col-md-12 col-sm-12">
        <div class="title">
            <h4>{{ $tps->name }}</h4>
        </div>
        <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb">
                <li class="breadcrumb-item" aria-current="page">{{ Formatting::capitalize($tps->kelurahan_name) }}</li>
                <li class="breadcrumb-item" aria-current="page">{{ Formatting::capitalize($tps->kecamatan_name) }}</li>
                <li class="breadcrumb-item">{{ Formatting::capitalize($tps->kabkota_name) }}</li>
            </ol>
        </nav>
    </div>
    @if ($data)
        @foreach ($data as $d)
            @php
                $calon = Formatting::capitalize($d->calon->calon_name." - ".$d->calon->wakil_name)
            @endphp
            <div class="mb-2 col-md-12">
                <label class="col-sm-12 col-md-12">{{ $calon }}</label>
                <div class="col-sm-12 col-md-12">
                    <input data-id="{{ $d->id }}" class="form-control" type="number" min="0" value="{{ $d->amount ?? 0 }}" placeholder="Masukkan Suara">
                </div>
            </div>
        @endforeach
    @endif
</div>
