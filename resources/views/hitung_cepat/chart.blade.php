<script src="../admin/src/plugins/apexcharts/apexcharts.min.js"></script>
<div class="row mb-30">
    <div class="col-md-6 mb-20">
        <div class="bg-white pd-20 card-box  mb-30">
            <h4 class="h4 text-blue">Jumlah Keseluruhan</h4>
            <div id="chart8"></div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="bg-white pd-20 card-box  mb-30">
            <h4 class="h4 text-blue">Jumlah Per Daerah</h4>
            <div id="chart4"></div>
        </div>
    </div>
</div>
<script>
    function adjustChart8Height() {
        // Ambil tinggi dari #chart4
        const chart4Height = $('#chart4').outerHeight();

        // Set tinggi #chart8 sama dengan #chart4
        $('#chart8').css('height', chart4Height);
    }
    // Mengambil data dari server yang sudah dikirim ke tampilan
    let wilayah = @json($wilayah); // Data wilayah yang berisi kecamatan atau kabkota
    let seriesNames = @json($data); // Data yang berisi total suara dan informasi calon

    // Menentukan kategori berdasarkan jenis wilayah
    let categories;
    if (wilayah.kecamatan) {
        // Jika data wilayah berisi kecamatan
        categories = wilayah.kecamatan.map(k => Formatting.capitalize(k.name));
    } else if (wilayah.kabkota) {
        // Jika data wilayah berisi kabkota
        categories = wilayah.kabkota.map(k => Formatting.capitalize(k.name));
    } else {
        // Jika tidak ada data kategori
        categories = [];
    }

    // Membuat data untuk masing-masing kandidat pada setiap kategori
    let seriesData = seriesNames.calon_total.map(calon => {
        return {
            name: `${Formatting.capitalize(calon.calon_name)} - ${Formatting.capitalize(calon.wakil_name)}`,
            data: categories.map(category => {
                // Mencocokkan kategori dengan data wilayah
                let wilayahData = seriesNames.data_perwilayah.find(w => Formatting
                    .capitalize(w.name) === category);
                let calonData = wilayahData ? wilayahData.total_suara.find(c => c.id ===
                    calon.id) : null;
                return calonData ? parseInt(calonData.total) : 0;
            })
        };
    });

    // Opsi konfigurasi untuk grafik bar
    let options4 = {
        series: seriesData,
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

    // Membuat dan merender grafik bar menggunakan ApexCharts
    let chart4 = new ApexCharts(document.querySelector("#chart4"), options4);
    chart4.render();

    // Opsi konfigurasi untuk grafik donut
    let options8 = {
        series: seriesNames.calon_total.map(calon => parseInt(calon.total)),
        labels: seriesNames.calon_total.map((calon, index) => Formatting.capitalize(
            `${index+1} - ${calon.calon_name}`)),
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
            // fontSize: '24px',
            fontWeight: 600,
        },
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    // width: 200
                },
            }
        }]
    };

    // Membuat dan merender grafik donut menggunakan ApexCharts
    let chart8 = new ApexCharts(document.querySelector("#chart8"), options8);
    chart8.render();

    adjustChart8Height();
    // Opsi: Jika Anda ingin memantau perubahan tinggi #chart4 secara dinamis
    $(window).resize(function() {
        adjustChart8Height();
    });
</script>
