@extends('layouts/main')
@section('body')
    @use('App\Helpers\Formatting')
    <div class="xs-pd-20-10 pd-ltr-20">
        <div class="title pb-20 d-flex justify-content-between align-items-center">
            <h2 class="h2 mb-0">{{ $user ? 'Update : ' . Formatting::capitalize($user->name) : ' Create New user' }}</h2>
            <div class="text-right">
                <a class="btn btn-sm btn-dark" href="{{ route('user.index') }}">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="pd-20 card-box mb-30">
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-blue h4">Form</h4>
                            <p class="mb-30"></p>
                        </div>
                    </div>
                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input id="user-name" value="{{ $user ? "$user->name" : '' }}" type="text"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Username</label>
                                    <input id="user-username" value="{{ $user ? "$user->username" : '' }}" type="text"
                                        class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Password</label>
                                    <input id="user-password"
                                        placeholder="{{ $user ? 'Kosongkan jika tidak ingin diganti' : '' }}" type="text"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Hak Akses</label>
                                    <select id="select-hak-akses" class="custom-select2 form-control" name="state"
                                        style="width: 100%; height: 38px;">
                                        <option selected disabled>Pilih</option>
                                        @foreach ($kabkota as $k)
                                            <option
                                            @if ($user)
                                                {{ $user->code == $k->id ? "selected": "" }}
                                            @endif
                                            value="{{ $k->id }}">{{ Formatting::capitalize($k->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row text-right">
                            <label class="col-sm-12 col-md-2 col-form-label"></label>
                            <div id="container-button-submit-form" class="col-sm-12 col-md-10">
                                <button id="submit-form-user" type="button"
                                    class="btn btn-dark btn-sm scroll-click">submit</button>
                                <script>
                                    $("#submit-form-user").on("click", e => {
                                        const id = @json(request()->query('Id'));
                                        var formData = {
                                            name: $('#user-name').val(), // Adjust according to the selected company id
                                            username: $('#user-username').val(),
                                            password: $('#user-password').val(),
                                            code: $("#select-hak-akses").val(),
                                        };
                                        TopLoaderService.start()
                                        $.ajax({
                                            url: id ? `/user?Id=${id}` : "/user",
                                            type: "POST",
                                            data: formData,
                                            dataType: 'json',
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
                                                    text: xhr.responseJSON.message ?? error
                                                });
                                            },
                                            complete: data => {
                                                TopLoaderService.end()
                                            }
                                        });
                                    })
                                </script>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- Select-2 end -->
            </div>
        </div>
    </div>
@endsection
