{{-- @dd($jumlahSuara) --}}
@use('App\Helpers\Formatting')
@php
    $idForm1 = 'X' . bin2hex(random_bytes(8));
    $idForm2 = 'X' . bin2hex(random_bytes(8));
    $idForm3 = 'X' . bin2hex(random_bytes(8));
    $idForm4 = 'X' . bin2hex(random_bytes(8));
    $idForm5 = 'X' . bin2hex(random_bytes(8));
    $idForm6 = 'X' . bin2hex(random_bytes(8));
    $idForm7 = 'X' . bin2hex(random_bytes(8));
    $idForm8 = 'X' . bin2hex(random_bytes(8));
    $idForm9 = 'X' . bin2hex(random_bytes(8));
    $idForm10 = 'X' . bin2hex(random_bytes(8));
    $idForm11 = 'X' . bin2hex(random_bytes(8));
    $idForm12 = 'X' . bin2hex(random_bytes(8));
    $idForm13 = 'X' . bin2hex(random_bytes(8));
    $idSubmit = 'X' . bin2hex(random_bytes(8));
@endphp
<div class="modal-header">
    <h4 class="modal-title" id="myLargeModalLabel">{{ $data["tps_name"]  }}</h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
    <form>
        <div class="row">
            <div class="container">
                <div class="row" id="{{ $idForm1 }}">
                    @foreach ($data["calon"] as $calon)
                    <div class="col-md form-group">
                        <label>{{ Formatting::capitalize($calon['calon_name']." - ".$calon["wakil_name"]) }}</label>
                        <input id="{{ $calon["id"] }}" placeholder="Wajib Diisi" value="{{ $calon["jumlah_suara"] }}" type="number" class="form-control">
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Pengguna Hak Pilih DPT</label>
                    <input id="{{ $idForm2 }}" placeholder="Wajib Diisi" value="" type="number" min="0"
                        class="form-control">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Pengguna Hak Pilih DPTB</label>
                    <input id="{{ $idForm3 }}" placeholder="Wajib Diisi" value="" type="number" min="0"
                        class="form-control">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Pengguna Hak Pilih DPTK</label>
                    <input id="{{ $idForm4 }}" placeholder="Wajib Diisi" value="" type="number" min="0"
                        class="form-control">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Surat Suara Diterima</label>
                    <input id="{{ $idForm5 }}" placeholder="Wajib Diisi" value="" type="number" min="0"
                        class="form-control">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Surat Suara Digunakan</label>
                    <input id="{{ $idForm6 }}" placeholder="Wajib Diisi" value="" type="number" min="0"
                        class="form-control">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Suara Tdk Digunakan</label>
                    <input id="{{ $idForm7 }}" placeholder="Wajib Diisi" value="" type="number" min="0"
                        class="form-control">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Surat Suara Rusak</label>
                    <input id="{{ $idForm8 }}" placeholder="Wajib Diisi" value="" type="number" min="0"
                        class="form-control">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Total Suara Sah</label>
                    <input id="{{ $idForm9 }}" placeholder="Wajib Diisi" value="" type="number" min="0"
                        class="form-control">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Total Suara Tidak Sah</label>
                    <input id="{{ $idForm10 }}" placeholder="Wajib Diisi" value="" type="number" min="0"
                        class="form-control">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Total Suara Sah &amp; Tidak Sah</label>
                    <input id="{{ $idForm11 }}" placeholder="Wajib Diisi" value="" type="number" min="0"
                        class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Catatan (Tidak Wajib)</label>
                    <textarea placeholder="Contoh: Terjadi kecurangan..." id="{{ $idForm12 }}" class="form-control"></textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Upload File C-Hasil</label>
                    <input type="file" id="{{ $idForm13 }}" accept="image/*,application/pdf"
                        class="form-control-file form-control height-auto">
                    <img id="preview" style="max-width: 200px; display: block; margin-top: 10px;">
                </div>
            </div>
        </div>
    </form>
    <script>
        document.getElementById("{{ $idForm13 }}").addEventListener("change", function(event) {
            const file = event.target.files[0]
            const reader = new FileReader()
            if (file) {
                reader.onload = function(e) {
                    document.getElementById("preview").src = e.target.result
                }
                reader.readAsDataURL(file)
            } else {
                preview.src = ""
            }
        })
    </script>

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
    <button type="button" id="{{ $idSubmit }}" class="btn btn-dark">Simpan</button>
</div>
<script>
    $("#{{ $idSubmit }}").on("click", function (e) {
        e.preventDefault();
        $(`#${$(".modal").attr("id")}`).modal("hide")
    })
</script>