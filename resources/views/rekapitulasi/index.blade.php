@extends('layouts/main')
@section('body')
    <div class="xs-pd-20-10 pd-ltr-20">
        <div class="title pb-20">
        </div>
        <!-- Striped table start -->
        <div class="pd-20 card-box mb-30">
            <div class="clearfix mb-20">
                <div class="pull-left">
                    <h2 class="h2 mb-0">Rekapitulasi</h2>
                </div>
                <div class="pull-right">
                </div>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Akses</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $data = [
                            [
                                'id' => 1,
                                'nama' => 'Kabkota',
                                'route' => route('rekap.index', ['Type' => 'Kabkota']),
                            ]
                        ];
                        if (request()->session()->get("level") !== "kabkota") {
                            array_push($data, [
                                'id' => 2,
                                'nama' => 'Provinsi',
                                'route' => route('rekap.index', ['Type' => 'Provinsi']),
                            ]);
                        }
                    @endphp
                    @foreach ($data as $d)
                    <tr>
                        <th scope="row">{{ $d['id'] }}</th>
                        <td>{{ $d['nama'] }}</td>
                        <td><a href="{{ $d['route'] }}" class="badge badge-dark text-light">Buka</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endsection
