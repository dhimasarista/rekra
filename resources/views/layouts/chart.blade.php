@extends('layouts/main')
@section('body')
    @php
        $segments = request()->segments();
    @endphp
    @use('App\Helpers\Formatting')
    <script src="../admin/src/plugins/apexcharts/apexcharts.min.js"></script>
    <div class="xs-pd-20-10 pd-ltr-20 ">
        <div class="title pb-20 d-flex justify-content-between align-items-center">
            <h2 class="h2 mb-0">{{ Formatting::capitalize($segments[0]) }}</h2>
            <div class="text-right">
                <a class="btn btn-sm btn-dark" href="{{ url()->previous() }}">
                    <i class="fa fa-list"></i> List
                </a>
            </div>
        </div>
        <div class="row mb-30">
            <div class="col-md-6 mb-20">
                <div class="pd-20 card-box height-100-p ">
                    <h4 class="h4 text-blue">Pie Chart</h4>
                    <div id="chart8"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="bg-white pd-20 card-box height-100-p mb-30">
                    <h4 class="h4 text-blue">Bar Chart</h4>
                    <div id="chart4"></div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let kecamatan = @json($kecamatan);
            let seriesNames = @json($seriesNames);

            let categories = Object.keys(kecamatan);

            let seriesData = seriesNames.map(seriesName => ({
                name: seriesName,
                data: categories.map(category => kecamatan[category][seriesName])
            }));

            let options4 = {
                series: seriesData,
                chart: {
                    type: 'bar',
                    height: 430,
                    toolbar: {
                        show: false,
                    }
                },
                grid: {
                    show: true,
                    padding: {
                        left: 10,
                        right: 10
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
                        colors: ['#fff']
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

            let chart4 = new ApexCharts(document.querySelector("#chart4"), options4);
            chart4.render();

            let options8 = {
                series: seriesData.map(series => series.data.reduce((a, b) => a + b, 0)),
                labels: seriesNames,
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
                chart: {
                    type: 'donut',
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };

            let chart8 = new ApexCharts(document.querySelector("#chart8"), options8);
            chart8.render();
        });
    </script>
@endsection
