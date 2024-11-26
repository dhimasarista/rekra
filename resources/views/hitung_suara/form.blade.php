{{-- @dd($data) --}}
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
    <h4 class="modal-title" id="myLargeModalLabel">{{ $data['tps_name'] }}</h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
    <form>
        <div class="row">
            <div class="container container-calon">
                <div class="row" id="{{ $idForm1 }}">
                    @foreach ($data['calon'] as $calon)
                        <div class="col-md form-group">
                            <label>{{ Formatting::capitalize($calon['calon_name'] . ' - ' . $calon['wakil_name']) }}</label>
                            <input id="{{ $calon['id'] }}" placeholder="Wajib Diisi"
                                value="{{ $calon['jumlah_suara'] }}" type="number" class="form-control">
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Pengguna Hak Pilih DPT</label>
                    <input id="{{ $idForm2 }}" placeholder="Wajib Diisi" value="{{ $jumlahSuara['dpt'] ?? null }}"
                        type="number" min="0" class="form-control">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Pengguna Hak Pilih DPTB</label>
                    <input id="{{ $idForm3 }}" placeholder="Wajib Diisi" value="{{ $jumlahSuara['dptb'] ?? null }}"
                        type="number" min="0" class="form-control">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Pengguna Hak Pilih DPTK</label>
                    <input id="{{ $idForm4 }}" placeholder="Wajib Diisi" value="{{ $jumlahSuara['dptk'] ?? null }}"
                        type="number" min="0" class="form-control">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Surat Suara Diterima</label>
                    <input id="{{ $idForm5 }}" placeholder="Wajib Diisi"
                        value="{{ $jumlahSuara['surat_suara_diterima'] ?? null }}" type="number" min="0"
                        class="form-control">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Surat Suara Digunakan</label>
                    <input id="{{ $idForm6 }}" placeholder="Wajib Diisi"
                        value="{{ $jumlahSuara['surat_suara_digunakan'] ?? null }}" type="number" min="0"
                        class="form-control">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Suara Tdk Digunakan</label>
                    <input id="{{ $idForm7 }}" placeholder="Wajib Diisi"
                        value="{{ $jumlahSuara['surat_suara_tidak_digunakan'] ?? null }}" type="number" min="0"
                        class="form-control">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Surat Suara Rusak</label>
                    <input id="{{ $idForm8 }}" placeholder="Wajib Diisi"
                        value="{{ $jumlahSuara['surat_suara_rusak'] ?? null }}" type="number" min="0"
                        class="form-control">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Total Suara Sah</label>
                    <input id="{{ $idForm9 }}" placeholder="Wajib Diisi"
                        value="{{ $jumlahSuara['total_suara_sah'] ?? null }}" type="number" min="0"
                        class="form-control">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Total Suara Tidak Sah</label>
                    <input id="{{ $idForm10 }}" placeholder="Wajib Diisi"
                        value="{{ $jumlahSuara['total_suara_tidak_sah'] ?? null }}" type="number" min="0"
                        class="form-control">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Total Suara Sah & Tidak Sah</label>
                    <input id="{{ $idForm11 }}" placeholder="Wajib Diisi"
                        value="{{ $jumlahSuara['total_sah_tidak_sah'] ?? null }}" type="number" min="0"
                        class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Catatan (Tidak Wajib)</label>
                    <textarea placeholder="Contoh: Terjadi kecurangan..." id="{{ $idForm12 }}" class="form-control">{{ $jumlahSuara['note'] ?? null }}</textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Upload File (Image/PDF)</label>
                    <input type="file" id="{{ $idForm13 }}" accept="image/*,application/pdf"
                        class="form-control-file form-control height-auto">
                    <img id="preview" style="max-width: 200px; display: block; margin-top: 10px;">
                </div>
            </div>
        </div>
    </form>
    <script>
        document.getElementById("preview").src = null;
        document.getElementById("preview").src = "{{ $jumlahSuara['c_hasil'] ?? null }}";
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
    $("#{{ $idSubmit }}").on("click", function(e) {
        $(this).attr("disabled", true);
        e.preventDefault();

        const id = $("#{{ $idForm1 }}").val();
        let formData = {
            calon: [],
            dpt: $('#{{ $idForm2 }}').val(),
            dptb: $('#{{ $idForm3 }}').val(),
            dptk: $('#{{ $idForm4 }}').val(),
            surat_suara_diterima: $('#{{ $idForm5 }}').val(),
            surat_suara_digunakan: $('#{{ $idForm6 }}').val(),
            surat_suara_tidak_digunakan: $('#{{ $idForm7 }}').val(),
            surat_suara_rusak: $('#{{ $idForm8 }}').val(),
            total_suara_sah: $('#{{ $idForm9 }}').val(),
            total_suara_tidak_sah: $('#{{ $idForm10 }}').val(),
            total_sah_tidak_sah: $('#{{ $idForm11 }}').val(),
            note: $('#{{ $idForm12 }}').val(),
            c_hasil: "",
        };
        // Menyusun data calon
        $('.container-calon input').each(function() {
            const id = $(this).attr('id');
            const value = $(this).val();

            // Push objek ke dalam array 'calon'
            formData.calon.push({
                id: id,
                value: value
            });
        });

        // Menampilkan SweetAlert loading
        Swal.fire({
            title: 'Upload File',
            text: 'Tunggu Sebentar Guys!',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Jika ada file di upload form
        let fileUpload = $('#{{ $idForm13 }}')[0].files[0];
        if (fileUpload) {
            let formDataFile = new FormData();
            formDataFile.append('file', fileUpload);

            // Upload file terlebih dahulu
            $.ajax({
                url:  `{!! route('hitung_suara.file', ['Tps' => 'TPS_PLACEHOLDER', "Type" => "TYPE_PLACEHOLDER"]) !!}`.replace("TPS_PLACEHOLDER", "{!! $data["tps_id"] !!}").replace("TYPE_PLACEHOLDER", "{{ $data['type'] }}"),
                type: "POST",
                data: formDataFile,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    formData["c_hasil"] = response.file_url;

                    // Kirim data ke endpoint hitung suara
                    submitData(formData);
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr["responseJSON"]["message"]
                    });
                    $("#{{ $idSubmit }}").removeAttr("disabled");
                },
                complete: function(data){
                    $(this).removeAttr("disabled");
                }
            });
        } else {
            // Jika tidak ada file, langsung kirim data
            submitData(formData);
        }
    });

    function submitData(formData) {
        $.ajax({
            url: `{!! route('hitung_suara.store', ['Tps' => 'TPS_PLACEHOLDER']) !!}`.replace("TPS_PLACEHOLDER", "{!! $data["tps_id"] !!}"),
            type: "POST",
            data: formData,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                Toast.fire({
                    icon: "success",
                    title: response["message"]
                });
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: xhr["responseJSON"]["message"]
                });
            },
            complete: function() {
                $(`#${$(".modal").attr("id")}`).modal("hide");
                $("#{{ $idSubmit }}").removeAttr("disabled");
            }
        });
    }
</script>

