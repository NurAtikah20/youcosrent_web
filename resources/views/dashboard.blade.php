@extends('tes')
@section('content')
    <style>
        @import url(https://fonts.googleapis.com/css?family=Roboto);

        body {
            font-family: Roboto, sans-serif;
        }

        #chart {
            max-width: 650px;
            margin: 35px auto;
        }
    </style>
    <div class="row" style="display: inline-block;">
        <div class="tile_count col-lg-12">
            <div class="col-md- col-sm-4   tile_stats_count">
                <span class="count_top"><i class="fa fa-user"></i> Total Pelanggan</span>
                <div class="count">{{ $pelanggan }}</div>
               
            </div>
            <div class="col-md-3 col-sm- tile_stats_count">
                <span class="count_top">Transaksi Melebihi batas pengembalian</span>
                <div class="count">{{ $melebihi_waktu }}</div>
                
            </div>
            <div class="col-md-3 col-sm-  tile_stats_count">
                <span class="count_top"><i class="fa fa-user"></i> Total Pendapatan</span>
                <div class="count green">{{ number_format($pendapatan_hariini) }}</div>
                <span class="count_bottom">Hari ini</span>
            </div>
            <div class="col-md-3 col-sm-  tile_stats_count">
                <span class="count_top"><i class="fa fa-user"></i> Total Pengeluaran</span>
                <div class="count red">{{ number_format($pengeluaran) }}</div>
                <span class="count_bottom">hari ini</span>
            </div>
            
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
        <div id="chart">
        </div>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        // Data dari controller
        var totalHargaBulanan = @json($totalHargaBulanan);
        var totalPengeluaranBulanan = @json($totalPengeluaranBulanan);

        // Mengolah data untuk chart
        var categories = totalHargaBulanan.map(item => item.bulan);
        var seriesDataPendapatan = totalHargaBulanan.map(item => item.total_harga);
        var seriesDataPengeluaran = totalPengeluaranBulanan.map(item => item.total_nominal);

        var options = {
            chart: {
                height: 350,
                type: "line",
                stacked: false
            },
            dataLabels: {
                enabled: false
            },
            colors: ["#247BA0", "#FF1654"], // Biru untuk Pendapatan, Merah untuk Pengeluaran
            series: [{
                name: "Pendapatan Bulanan",
                data: seriesDataPendapatan
            }, {
                name: "Pengeluaran Bulanan",
                data: seriesDataPengeluaran
            }],
            stroke: {
                width: [4, 4]
            },
            plotOptions: {
                bar: {
                    columnWidth: "20%"
                }
            },
            xaxis: {
                categories: categories
            },
            yaxis: [{
                axisTicks: {
                    show: true
                },
                axisBorder: {
                    show: true,
                    color: "#247BA0" // Biru untuk Pendapatan
                },
                labels: {
                    style: {
                        colors: "#247BA0" // Biru untuk Pendapatan
                    }
                },
                title: {
                    text: "Pendapatan Bulanan",
                    style: {
                        color: "#247BA0" // Biru untuk Pendapatan
                    }
                }
            },{
                opposite: true,
                axisTicks: {
                    show: true
                },
                axisBorder: {
                    show: true,
                    color: "#FF1654" // Merah untuk Pengeluaran
                },
                labels: {
                    style: {
                        colors: "#FF1654" // Merah untuk Pengeluaran
                    }
                },
                title: {
                    text: "Pengeluaran Bulanan",
                    style: {
                        color: "#FF1654" // Merah untuk Pengeluaran
                    }
                }
            }],
            tooltip: {
                shared: false,
                intersect: true,
                x: {
                    show: false
                }
            },
            legend: {
                horizontalAlign: "left",
                offsetX: 40
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    </script>
@endsection
