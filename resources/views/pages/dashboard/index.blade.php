@extends('layouts.app')

@section('title', 'Dashboard')

@push('style')
    <!-- CSS Libraries -->
    {{-- <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/owl.carousel/dist/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/owl.carousel/dist/assets/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/flag-icon-css/css/flag-icon.min.css') }}"> --}}
@endpush

@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Dashboard</h1>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-search"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Temuan</h4>
                            </div>
                            <div class="card-body">
                                {{ $temuanCount }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="fas fa-shield-virus"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Insiden</h4>
                            </div>
                            <div class="card-body">
                                {{ $insidenCount }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="far fa-building"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total OPD</h4>
                            </div>
                            <div class="card-body">
                                {{ $opdCount }}
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-circle"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Online Users</h4>
                            </div>
                            <div class="card-body">
                                47
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>

            <div class="row">
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Jumlah Insiden</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="jumlah-jenis-insiden"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Status Temuan</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="status-temuan"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Jumlah OPD Terdampak Per-Bulan</h4>
                        </div>
                        <div class="card-body">
                            <div class="chartjs-size-monitor">
                                <div class="chartjs-size-monitor-expand">
                                    <div class=""></div>
                                </div>
                                <div class="chartjs-size-monitor-shrink">
                                    <div class=""></div>
                                </div>
                            </div>
                            <canvas id="jumlah-insiden-terdampak" height="350"
                                style="display: block; height: 299px; width: 350px;" width="1138"
                                class="chartjs-render-monitor"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section-body">
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
    <script>
        var jit = document.getElementById("jumlah-insiden-terdampak").getContext("2d");
        var myChart = new Chart(jit, {
            type: "line",
            data: {
                labels: {!! json_encode($chartJumlahTerdampak['tanggal']) !!},
                datasets: [{
                    label: "Jumlah",
                    data: {!! json_encode($chartJumlahTerdampak['jumlah_insiden']) !!},
                    borderWidth: 2,
                    backgroundColor: "rgba(63,82,227,.8)",
                    borderWidth: 0,
                    borderColor: "transparent",
                    pointBorderWidth: 0,
                    pointRadius: 3.5,
                    pointBackgroundColor: "transparent",
                    pointHoverBackgroundColor: "rgba(63,82,227,.8)",
                }, ],
            },
            options: {
                legend: {
                    display: false,
                },
                scales: {
                    yAxes: [{
                        gridLines: {
                            // display: false,
                            drawBorder: false,
                            color: "#f2f2f2",
                        },
                        ticks: {
                            beginAtZero: true,
                            stepSize: 1,
                        },
                    }, ],
                    xAxes: [{
                        gridLines: {
                            display: false,
                            tickMarkLength: 15,
                        },
                    }, ],
                },
            },
        });

        var ctx = document.getElementById("jumlah-jenis-insiden").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: {!! json_encode($chartJumlahInsiden['jumlah']) !!},
                    backgroundColor: [
                        '#191d21',
                        '#63ed7a',
                        '#ffa426',
                        '#fc544b',
                        '#6777ef',
                        '#f0f0f0',
                        '#ff9a9e',
                        '#a6c0fe',
                        '#a8c0ff',
                        '#d9a7c7'
                    ],
                    label: 'Dataset 1'
                }],
                labels: {!! json_encode($chartJumlahInsiden['insiden']) !!},
            },
            options: {
                responsive: true,
                legend: {
                    position: 'bottom',
                },
            }
        });

        var ctx = document.getElementById("status-temuan").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                datasets: [{
                    data: {!! json_encode($chartJumlahStatusTemuan['jumlah']) !!},
                    backgroundColor: [
                        '#4db7f7',
                        '#fc534a',
                        '#ffc200',
                        '#49c361',
                    ],
                    label: 'Dataset 1'
                }],
                labels: {!! json_encode($chartJumlahStatusTemuan['status']) !!},
            },
            options: {
                responsive: true,
                legend: {
                    position: 'bottom',
                },
            }
        });
    </script>
@endpush
