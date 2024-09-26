<div class="form-group row">
    <div class="col-md-12 col-sm-12">
        <div class="title">
            <h4>{{ $tps->name }}</h4>
        </div>
        <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">{{ $tps->kabkota_name }}</a></li>
                <li class="breadcrumb-item" aria-current="page">{{ $tps->kecamatan_name }}</li>
                <li class="breadcrumb-item" aria-current="page">{{ $tps->kelurahan_name }}</li>
            </ol>
        </nav>
    </div>
    <label class="col-sm-12 col-md-4">1. Nuryanto - Hardi</label>
    <div class="col-sm-12 col-md-12">
        <input class="form-control" type="number" min="0" placeholder="Masukkan Suara">
    </div>
</div>
