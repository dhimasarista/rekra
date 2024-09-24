@extends('layouts/main')
@section('body')
    @php
        $segments = request()->segments();
    @endphp
    @use('App\Helpers\Formatting')
    <div class="xs-pd-20-10 pd-ltr-20">
        <div class="title pb-20 d-flex justify-content-between align-items-center">
            <h2 class="h2 mb-0">{{ Formatting::capitalize($segments[0]) }}</h2>
            <div class="text-right">
                <a class="btn btn-sm btn-dark m-1" href="{{ route('user.form') }}">
                    <i class="fa fa-plus"></i> Tambah User
                </a>
                <a class="btn btn-sm btn-dark m-1" href="{{ route('user.login') }}">
                    <i class="fa fa-history"></i> Login History
                </a>
            </div>
        </div>
        <div class="row pb-10">
            <div class="col-md-12 mb-20">
                <!-- Export Datatable start -->
                <div class="card-box mb-30">
                    <div class="pd-20">
                        <h4 class="text-primary h4">Daftar User</h4>
                    </div>
                    <div class="pb-20">
                        <table width="100%" id="datatable-table"
                            class="table hover stripe multiple-select-row data-table-export wrap">
                            <thead>
                                <tr>
                                    <th class="table-plus datatable-nosort">Nama</th>
                                    <th>Username</th>
                                    <th>Hak Akses</th>
                                    <th>Tingkat Akses</th>
                                    <th>Aktif</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $counter = 1;
                                @endphp
                                {{-- @dd($data) --}}
                                @foreach ($users as $u)
                                    <tr>
                                        <td>{{ Formatting::capitalize($u->name) }}</td>
                                        <td>{{ $u->username }}</td>
                                        @if ($u->code == 1)
                                            <td>Indonesia</td>
                                        @endif
                                        @foreach ($provinsi as $p)
                                            @if ($p->id == $u->code)
                                                <td>{{ Formatting::capitalize($p->name) }}</td>
                                            @endif
                                        @endforeach
                                        @foreach ($kabkota as $k)
                                            @if ($k->id == $u->code)
                                                <td>{{ Formatting::capitalize($k->name) }}</td>
                                            @endif
                                        @endforeach
                                        <td>{{ Formatting::capitalize($u->level) }}</td>
                                        <td>
                                            <input id="input_isactive_{{ $u->id }}" onchange="updateIsActive(this)"
                                                data-user-id="{{ $u->id }}" type="checkbox" class="switch-btn"
                                                data-size="small" data-color="#0059b2" data-secondary-color="#28a745"
                                                {{ $u->is_active ? 'checked' : '' }} />
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle"
                                                    href="#" role="button" data-toggle="dropdown">
                                                    <i class="dw dw-more"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                    <a class="dropdown-item" href="#"><i class="dw dw-eye"></i>
                                                        Lihat</a>
                                                    <a class="dropdown-item"
                                                        href="{{ route('user.form', ['Id' => $u->id]) }}"><i
                                                            class="dw dw-edit2"></i>
                                                        Edit</a>
                                                    <a class="dropdown-item" onclick="buttonDelete('{{ $u->id }}')"
                                                        href="#"><i class="dw dw-delete-3"></i>
                                                        Hapus</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <script>
                            const buttonDelete = (id) => {
                                Swal.fire({
                                    title: "Data tidak bisa dikembalikan",
                                    text: "kami menyarankan anda untuk menonaktifkan saja user, bukan dihapus. Apakah tetap ingin dihapus?",
                                    icon: "warning",
                                    showCancelButton: true,
                                    confirmButtonColor: "#3085d6",
                                    cancelButtonColor: "#d33",
                                    confirmButtonText: "Yes!"
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        TopLoaderService.start()
                                        $.ajax({
                                            type: "DELETE",
                                            url: `{{ route('user.destroy', ':id') }}`.replace(':id', id),
                                            dataType: "json",
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            },
                                            success: function(response) {
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: 'Success',
                                                    text: response.message
                                                }).then(() => {
                                                    window.location.replace("/user");
                                                });
                                            },
                                            error: function(xhr, status, error) {
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'Error',
                                                    text: error
                                                });
                                            },
                                            complete: data => {
                                                TopLoaderService.end()
                                            }
                                        });
                                    }
                                });
                            }
                        </script>
                    </div>
                </div>
                <script>
                    $("#datatable-table").DataTable({
                    })
                </script>
                <!-- Export Datatable End -->
            </div>
            <div class="col-md-4 mb-20">

            </div>
        </div>
    </div>
    <script src="../admin/src/plugins/apexcharts/apexcharts.min.js"></script>
    <script src="../admin/vendors/scripts/dashboard3.js"></script>
    <script>
        function updateIsActive(element) {
            const isActive = element.checked;
            const dataUser = element.getAttribute("data-user-id");

            TopLoaderService.start()
            $.ajax({
                url: `/user/status?Id=${dataUser}`,
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                },
                processData: false,
                contentType: false,
                success: function(response) {
                    Toast.fire({
                        icon: "success",
                        title: response.message
                    });
                },
                error: function(xhr, status, error) {
                    element.checked = !isActive;
                    const data = xhr.responseJSON;
                    let message = ErrorResponse(data)
                    Toast.fire({
                        icon: "warning",
                        title: message
                    });
                },
                complete: function(data) {
                    TopLoaderService.end()
                }
            });
        }
    </script>
@endsection
