<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Jumlah Insiden Per-OPD</h4>
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
                    <canvas id="jumlah-insiden-opd" height="400" style="display: block; height: 400px; width: 784px;"
                        width="1568" class="chartjs-render-monitor"></canvas>
                </div>
            </div>
        </div>
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

</div>


{{-- diagram --}}
<script>
    function initializeChartsTemuan() {
        "use strict";
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

        var jio = document.getElementById("jumlah-insiden-opd").getContext('2d');
        var myChart = new Chart(jio, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartJumlahInsidenOPD['nama_opd']) !!},
                datasets: [{
                    label: 'Jumlah Temuan (Berapa Kali Terkena)',
                    data: {!! json_encode($chartJumlahInsidenOPD['jumlah_temuan']) !!},
                    borderWidth: 2,
                    backgroundColor: 'rgba(254,86,83,.7)',
                    borderColor: 'rgba(254,86,83,.7)',
                    borderWidth: 2.5,
                    pointBackgroundColor: '#ffffff',
                    pointRadius: 4
                }, {
                    label: 'Jumlah Insiden',
                    data: {!! json_encode($chartJumlahInsidenOPD['jumlah_insiden']) !!},
                    borderWidth: 2,
                    backgroundColor: 'rgba(63,82,227,.8)',
                    borderColor: 'transparent',
                    borderWidth: 0,
                    pointBackgroundColor: '#999',
                    pointRadius: 4
                }]
            },
            options: {
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        gridLines: {
                            drawBorder: false,
                            color: '#f2f2f2',
                        },
                        ticks: {
                            beginAtZero: true,
                            stepSize: 1
                        }
                    }],
                    xAxes: [{
                        gridLines: {
                            display: false
                        }
                    }]
                },
            }
        });


        // Daftar warna yang sudah didefinisikan
        const predefinedColors = [
            '#191d21',
            '#63ed7a',
            '#ffa426',
            '#fc544b',
            '#6777ef',
            '#f0f0f0', // Tambahkan lebih banyak warna jika diperlukan
            '#ff9a9e',
            '#a6c0fe',
            '#a8c0ff',
            '#d9a7c7'
        ];

        // Fungsi untuk memilih warna acak dari daftar
        function getRandomPredefinedColor() {
            return predefinedColors[Math.floor(Math.random() * predefinedColors.length)];
        }

        // Menghasilkan array warna acak berdasarkan jumlah data insiden
        let backgroundColors = [];
        let totalInsiden = {!! json_encode(count($chartJumlahInsiden['insiden'])) !!};

        for (let i = 0; i < totalInsiden; i++) {
            backgroundColors.push(getRandomPredefinedColor());
        }

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
    }
</script>
