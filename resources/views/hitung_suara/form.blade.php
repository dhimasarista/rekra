<form>
    <div class="row">
        <div class="container">
            <div class="row">
                <div class="col-md form-group">
                    <label>Ansar Ahmad - Nyanyang Haris</label>
                    <input id="col1" placeholder="Wajib Diisi" value="0" type="text" class="form-control">
                </div>
                <div class="col-md form-group">
                    <label>Muhammad Rudi - Aunur Rafiq</label>
                    <input id="col2" placeholder="Wajib Diisi" value="0" type="text" class="form-control">
                </div>
                <div class="col-md form-group">
                    <label>Nama Paslon 3</label>
                    <input id="col3" placeholder="Wajib Diisi" value="0" type="text" class="form-control">
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Pengguna Hak Pilih DPT</label>
                <input id="Xded9076fc681c9ec" placeholder="Wajib Diisi" value="" type="number" min="0"
                    class="form-control">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Pengguna Hak Pilih DPTB</label>
                <input id="X1288e5351043c881" placeholder="Wajib Diisi" value="" type="number" min="0"
                    class="form-control">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Pengguna Hak Pilih DPTK</label>
                <input id="Xcaad5f1bd25a8b4b" placeholder="Wajib Diisi" value="" type="number" min="0"
                    class="form-control">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Surat Suara Diterima</label>
                <input id="Xb6bf73b740957387" placeholder="Wajib Diisi" value="" type="number" min="0"
                    class="form-control">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Surat Suara Digunakan</label>
                <input id="Xdbb48f88ac579298" placeholder="Wajib Diisi" value="" type="number" min="0"
                    class="form-control">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Suara Tdk Digunakan</label>
                <input id="X80bd67f485dfc0e8" placeholder="Wajib Diisi" value="" type="number" min="0"
                    class="form-control">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Surat Suara Rusak</label>
                <input id="X6f96be18245ab20d" placeholder="Wajib Diisi" value="" type="number" min="0"
                    class="form-control">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Total Suara Sah</label>
                <input id="X2cd9c4dd9f804a43" placeholder="Wajib Diisi" value="" type="number" min="0"
                    class="form-control">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Total Suara Tidak Sah</label>
                <input id="Xfb060e54b12cc30c" placeholder="Wajib Diisi" value="" type="number" min="0"
                    class="form-control">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Total Suara Sah &amp; Tidak Sah</label>
                <input id="Xf694806b0bfe8092" placeholder="Wajib Diisi" value="" type="number" min="0"
                    class="form-control">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Catatan (Tidak Wajib)</label>
                <textarea placeholder="Contoh: Terjadi kecurangan..." id="X22bda670d7ba7231" class="form-control"></textarea>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Upload File C-Hasil</label>
                <input type="file" id="fileInput" accept="image/*,application/pdf"
                    class="form-control-file form-control height-auto">
                <img id="preview" style="max-width: 200px; display: block; margin-top: 10px;">
            </div>
        </div>
    </div>
</form>
<script>
    document.getElementById("fileInput").addEventListener("change", function(event) {
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
