@extends('layouts/main')
@section('body')
    @use('Ramsey\Uuid\Uuid')
    @use('App\Helpers\Formatting')
    @php
        $segments = request()->segments();
        $idSelect1 = Uuid::uuid7();
        $idSelect2 = Uuid::uuid7();
        $idContainerSelect3 = Uuid::uuid7();
        $idButtonSubmit = Uuid::uuid7();
    @endphp
    <div class="xs-pd-20-10 pd-ltr-20">
        <div class="title pb-20 d-flex justify-content-between align-items-center">
            <div class="text-left" style="width: 100%">
                <select id="{{ $idSelect1 }}" class="custom-select col-md-2 m-1">
                    <option disabled selected id="">Pilih Jenis Rekap</option>
                    <option value="saksi">Hitung Cepat Saksi</option>
                    <option value="admin">Hitung Cepat Admin</option>
                </select>
                <select id="{{ $idSelect2 }}" class="custom-select col-md-2 m-1">
                    <option disabled selected>Pilih Tingkatan</option>
                    @if (session()->get('level') !== 'kabkota')
                        <option value="Provinsi">Provinsi</option>
                    @endif
                    <option value="Kabkota">Kabkota</option>
                </select>
                <script>
                    let init = false;
                    $("#{{ $idSelect2 }}").on("change", (e) => {
                        e.preventDefault();
                        let typeQuery = $("#{{ $idSelect2 }}").val();
                        let url = `{!! route('hitung_cepat.select_tingkat', ['Type' => 'TYPE_PLACEHOLDER']) !!}`.replace("TYPE_PLACEHOLDER", typeQuery);
                        $.ajax({
                            type: "get",
                            url: url,
                            success: function(response) {
                                init = true;
                                $("#{{ $idContainerSelect3 }}").html(response);
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
                    });
                </script>
                <span id="{{ $idContainerSelect3 }}"></span>
                <button id="{{ $idButtonSubmit }}" class="btn btn-dark m-1">Submit</button>
                <script>
                    $("#{{ $idButtonSubmit }}").on("click", function(e) {
                        e.preventDefault();
                        TopLoaderService.start();
                        fetchData();
                    });
                    const fetchData = () => {
                        let typeQuickCount = $("#{{ $idSelect1 }}").val();
                        let tingkat = $("#{{ $idSelect2 }}").val();
                        let lastId = $("#{{ $idContainerSelect3 }} .custom-select:last").val();
                        let url = `{!! route('hitung_cepat.chart', [
                            'Type' => 'TYPE_PLACEHOLDER',
                            'Tingkat' => 'TINGKAT_PLACEHOLDER',
                            'Id' => 'ID_PLACEHOLDER',
                        ]) !!}`
                            .replace("TYPE_PLACEHOLDER", typeQuickCount)
                            .replace("TINGKAT_PLACEHOLDER", tingkat)
                            .replace('ID_PLACEHOLDER', lastId);

                        loadChartData(url, {
                            Id: lastId,
                            Tingkat: tingkat,
                            Type: typeQuickCount
                        });
                    }
                    socket.on('hc-admin', function(message) {
                        if (init) {
                            fetchData()
                        }
                    });
                </script>
            </div>
        </div>
        <div class="row pb-10">
            <div class="col-md-12 mb-20">
                <script src="../admin/src/plugins/apexcharts/apexcharts.min.js"></script>
                <div class="row mb-30" id="chart-container">
                    <div class="col-md-6 mb-20">
                        <div class="bg-white pd-20 card-box mb-30">
                            <h4 class="h4 text-blue">Jumlah Keseluruhan</h4>
                            <div id="chart8"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="bg-white pd-20 card-box mb-30">
                            <h4 class="h4 text-blue">Jumlah Per Daerah</h4>
                            <div id="chart4"></div>
                        </div>
                    </div>
                </div>
                <script>
                    let wilayah = null;
                    let seriesNames = null;
                    let categories = [];
                    let seriesData = [];

                    function loadChartData(url, data) {
                        $.ajax({
                            url: url,
                            method: 'GET',
                            data: data,
                            success: function(response) {
                                wilayah = response["wilayah"];
                                seriesNames = response["data"];
                                if (wilayah.kecamatan) {
                                    categories = wilayah.kecamatan.map(k => Formatting.capitalize(k.name));
                                } else if (wilayah.kabkota) {
                                    categories = wilayah.kabkota.map(k => Formatting.capitalize(k.name));
                                } else {
                                    categories = [];
                                }
                                seriesData = seriesNames.calon_total.map(calon => {
                                    return {
                                        name: `${Formatting.capitalize(calon.calon_name)} - ${Formatting.capitalize(calon.wakil_name)}`,
                                        data: categories.map(category => {
                                            let wilayahData = seriesNames.data_perwilayah.find(w =>
                                                Formatting.capitalize(w.name) === category);
                                            let calonData = wilayahData ? wilayahData.total_suara.find(c =>
                                                c.id === calon.id) : null;
                                            return calonData ? parseInt(calonData.total) : 0;
                                        })
                                    };
                                });
                                const newLabels = seriesNames.calon_total.map(calon => Formatting.capitalize(calon
                                    .calon_name));
                                chart4.updateOptions({
                                    xaxis: {
                                        categories: categories
                                    }
                                });
                                chart4.updateSeries(seriesData);
                                chart8.updateSeries(seriesNames.calon_total.map(calon => parseInt(calon.total)));
                                chart8.updateOptions({
                                    labels: newLabels,
                                });
                            },
                            error: function(xhr, status, error) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: xhr["responseJSON"]["message"]
                                });
                            },
                            complete: function(data) {
                                TopLoaderService.end();
                            }
                        });
                    }

                    function adjustChart8Height() {
                        const chart4Height = $('#chart4').outerHeight();
                        $('#chart8').css('height', chart4Height);
                    }

                    let options4 = {
                        series: [],
                        chart: {
                            type: 'bar',
                            height: 500,
                            toolbar: {
                                show: false,
                            }
                        },
                        theme: {
                            mode: 'light',
                            palette: 'palette7',
                            monochrome: {
                                enabled: false,
                                color: '#D7263D',
                                shadeTo: 'light',
                                shadeIntensity: 0.65
                            },
                        },
                        grid: {
                            show: true,
                            padding: {
                                left: 10,
                                right: 10,
                            }
                        },
                        plotOptions: {
                            bar: {
                                horizontal: true,
                                dataLabels: {
                                    position: 'top',
                                },
                            }
                        },
                        dataLabels: {
                            enabled: true,
                            offsetX: -6,
                            style: {
                                fontSize: '12px',
                                colors: ['#000']
                            },
                            name: {
                                show: true
                            },
                        },
                        stroke: {
                            show: true,
                            width: 1,
                            colors: ['#fff']
                        },
                        xaxis: {
                            categories: categories,
                        },
                    };

                    var chart4 = new ApexCharts(document.querySelector("#chart4"), options4);

                    let options8 = {
                        series: [],
                        labels: [],
                        dataLabels: {
                            enabled: true,
                        },
                        plotOptions: {
                            pie: {
                                donut: {
                                    labels: {
                                        show: true,
                                        name: {},
                                        value: {}
                                    }
                                }
                            }
                        },
                        theme: {
                            mode: 'light',
                            palette: 'palette7',
                            monochrome: {
                                enabled: false,
                                color: '#D7263D',
                                shadeTo: 'light',
                                shadeIntensity: 0.65
                            },
                        },
                        chart: {
                            type: 'donut',
                        },
                        legend: {
                            position: 'bottom',
                            fontWeight: 600,
                        },
                        responsive: [{
                            breakpoint: 480,
                            options: {
                                chart: {},
                            }
                        }]
                    };

                    var chart8 = new ApexCharts(document.querySelector("#chart8"), options8);

                    chart4.render();
                    chart8.render();

                    adjustChart8Height();
                    $(window).resize(function() {
                        adjustChart8Height();
                    });
                </script>
            </div>
        </div>
    </div>
@endsection
