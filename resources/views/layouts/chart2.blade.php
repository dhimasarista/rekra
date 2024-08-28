@extends('layouts/main')
@section('body')
    @php
        $segments = request()->segments();
    @endphp
    @use('App\Helpers\Formatting')
    <script src="../admin/src/plugins/apexcharts/apexcharts.min.js"></script>
    <div class="xs-pd-20-10 pd-ltr-20 ">
        <div class="title pb-20 d-flex justify-content-between align-items-center">
            {{-- <h2 class="h2 mb-0">{{ Formatting::capitalize($segments[0]) }}</h2> --}}
            <div class="text-left">
                <a class="btn btn-sm btn-dark" href="{{ route('rekap.index', ['Type' => 'Kabkota']) }}">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
            </div>
            <div class="text-right">
                <a class="btn btn-sm btn-dark"
                    href="{{ route('rekap.list', ['Type' => request()->query('Type'), 'Id' => request()->query('Id')]) }}">
                    <i class="fa fa-list"></i> List
                </a>
            </div>
        </div>
        <div class="row mb-30">
            <div class="col-md-6 mb-20">
                <div class="bg-white pd-20 card-box mb-30">
                    <h4 class="h4 text-blue">Bar Chart</h4>
                    <div id="chart4"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="pd-20 card-box height-100-p">
                    <h4 class="h4 text-blue">Pie Chart</h4>
                    <div id="chart8"></div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Initial data for the bar chart
        var dataChart1 = [{
            data: [44, 55, 41, 64, 22, 43, 21]
        }, {
            data: [53, 32, 33, 52, 13, 44, 32]
        }];

        var options4 = {
            series: dataChart1,
            chart: {
                type: 'bar',
                height: 430,
                toolbar: {
                    show: false,
                }
            },
            grid: {
                show: false,
                padding: {
                    left: 0,
                    right: 0
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
                }
            },
            stroke: {
                show: true,
                width: 1,
                colors: ['#fff']
            },
            xaxis: {
                categories: [2014, 2015, 2016, 2017, 2018, 2019, 2020],
            },
        };

        var chart4 = new ApexCharts(document.querySelector("#chart4"), options4);
        chart4.render();

        // Initial data for the donut chart
        var dataChart2 = [44, 55, 41, 17, 15];

        var options8 = {
            series: dataChart2,
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

        var chart8 = new ApexCharts(document.querySelector("#chart8"), options8);
        chart8.render();

        // Function to generate random integer
        function getRandomInt(min, max) {
            return Math.floor(Math.random() * (max - min + 1)) + min;
        }

        // Function to update the bar chart with new random data
        function updateBarChart() {
            var newData = dataChart1.map(series => ({
                data: series.data.map(() => getRandomInt(10, 100))
            }));
            chart4.updateSeries(newData);
        }

        // Function to update the donut chart with new random data
        function updateDonutChart() {
            var newData = dataChart2.map(() => getRandomInt(10, 100));
            chart8.updateSeries(newData);
        }

        // Update charts every 5 seconds
        setInterval(() => {
            updateBarChart();
            updateDonutChart();
        }, 2000);
    </script>
@endsection
