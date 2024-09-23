<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-8 col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4>Jumlah Surat Masuk dari setiap OPD</h4>
                </div>
                <div class="card-body">
                    @foreach ($opd as $item)
                        <div class="mb-4">
                            <div class="text-small font-weight-bold text-muted float-right">
                                {{ $item->totalJumlah }}
                            </div>
                            <div class="font-weight-bold mb-1">{{ $item->nama }}</div>
                            <div class="progress" data-height="4" style="height: 4px;">
                                <div class="progress-bar" role="progressbar" data-width="80%" aria-valuenow=""
                                    aria-valuemin="" aria-valuemax="{{ $opd->first()->totalJumlah }}"
                                    style="width:  {{ ($item->totalJumlah / $opd->first()->totalJumlah) * 100 }}%;">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4 col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h4>Jenis Surat Masuk</h4>
                </div>
                <div class="card-body">
                    <canvas id="jenis-surat-masuk"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- diagram --}}
<script>
    function initializeChartsSuratMasuk() {
        "use strict";
        var ctx = document.getElementById("jenis-surat-masuk").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: {!! json_encode($chartJenisSuratMasuk['jumlah']) !!},
                    backgroundColor: [
                        '#ffa426',
                        '#6777ef',
                        '#63ed7a',
                        '#a6c0fe',
                        '#a8c0ff',
                        '#ff9a9e',
                        '#f0f0f0',
                        '#fc544b',
                        '#d9a7c7'
                    ],
                    label: 'Dataset 1'
                }],
                labels: {!! json_encode($chartJenisSuratMasuk['jenis']) !!},
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
