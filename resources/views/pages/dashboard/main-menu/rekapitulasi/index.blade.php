@extends('layouts.app')

@section('title', 'Rekapitulasi')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
@endpush

@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Data @yield('title') </h1>
            </div>

            <form method="POST" autocomplete="off" enctype="multipart/form-data" id="form-process">
                @csrf
                <div class="section-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Filter @yield('title')</h4>
                                </div>

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Jenis</label>
                                                <select class="form-control select2" name="jenis" id="jenis">
                                                    <option value="1" data-start-date="{{ $startDateTemuan }}"
                                                        data-end-date="{{ $endDateTemuan }}">Temuan</option>
                                                    <option value="2" data-start-date="{{ $startDateSuratKeluar }}"
                                                        data-end-date="{{ $endDateSuratKeluar }}">Surat Keluar
                                                    </option>
                                                    <option value="3" data-start-date="{{ $startDateSuratMasuk }}"
                                                        data-end-date="{{ $endDateSuratMasuk }}">Surat Masuk
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>OPD</label>
                                                <select class="form-control select2" name="opd_id">
                                                    <option value="">Semua</option>
                                                    @foreach ($opd as $item)
                                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Dari tanggal</label>
                                                <input type="date" class="form-control" value="date" name="startDate"
                                                    id="startDate">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Sampai tanggal</label>
                                                <input type="date" class="form-control" value="date" name="endDate"
                                                    id="endDate">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group d-none" id="fg-insiden">
                                        <label class="form-label">Insiden</label>
                                        <div class="selectgroup selectgroup-pills">
                                            @foreach ($insiden as $id => $nama)
                                                <label class="selectgroup-item">
                                                    <input type="checkbox" name="insiden[]" value="{{ $id }}"
                                                        class="selectgroup-input" checked>
                                                    <span class="selectgroup-button">{{ $nama }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="form-group d-none" id="fg-jenis-surat-keluar">
                                        <label class="form-label">Jenis Surat Keluar</label>
                                        <div class="selectgroup selectgroup-pills">
                                            @foreach ($jenisSuratKeluar as $id => $nama)
                                                <label class="selectgroup-item">
                                                    <input type="checkbox" name="jenis_surat_keluar[]"
                                                        value="{{ $id }}" class="selectgroup-input" checked>
                                                    <span class="selectgroup-button">{{ $nama }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="form-group d-none" id="fg-jenis-surat-masuk">
                                        <label class="form-label">Jenis Surat Masuk</label>
                                        <div class="selectgroup selectgroup-pills">
                                            @foreach ($jenisSuratMasuk as $id => $nama)
                                                <label class="selectgroup-item">
                                                    <input type="checkbox" name="jenis_surat_masuk[]"
                                                        value="{{ $id }}" class="selectgroup-input" checked>
                                                    <span class="selectgroup-button">{{ $nama }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>

                                    <input type="hidden" value="diagram-tab" id="tab-info" name="tab_info">

                                    <div class="card-footer pt-0 text-right">
                                        <div class="d-inline">
                                            <button class="btn btn-primary" id="proses">
                                                <i class="fas fa-sync"></i> Proses
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="section-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Hasil Proses Rekapitulasi</h4>
                                </div>
                                <div class="card-body">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active tab-link" id="diagram-tab" data-toggle="tab"
                                                href="#tab-diagram" role="tab" aria-controls="tab-diagram"
                                                aria-selected="true">Diagram</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link tab-link" id="table-tab" data-toggle="tab"
                                                href="#tab-table" role="tab" aria-controls="tab-table"
                                                aria-selected="false">Tabel</a>
                                        </li>
                                    </ul>

                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="tab-diagram" role="tabpanel"
                                            aria-labelledby="diagram-tab">
                                            <div class="text-center my-5">
                                                <h5><em>Proses Data Terlebih Dahulu</em></h5>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="tab-table" role="tabpanel"
                                            aria-labelledby="table-tab">
                                            <div class="text-center my-5">
                                                <h5><em>Proses Data Terlebih Dahulu</em></h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>

    {{-- button reset selected data --}}
    <script>
        var resetStates = {
            1: false,
            2: false,
            3: false
        };

        $('#resetButton').click(function() {
            var selectedJenis = $('#jenis').val();
            if (selectedJenis == 1) {
                $('#fg-insiden input[type="checkbox"]').prop('checked', false);
                resetStates[1] = true;
            } else if (selectedJenis == 2) {
                $('#fg-jenis-surat-keluar input[type="checkbox"]').prop('checked', false);
                resetStates[2] = true;
            } else if (selectedJenis == 3) {
                $('#fg-jenis-surat-masuk input[type="checkbox"]').prop('checked', false);
                resetStates[3] = true;
            }
        });

        $('#jenis').change(function() {
            var selectedJenis = $(this).val();
            if (resetStates[selectedJenis]) {
                if (selectedJenis == 1) {
                    $('#fg-insiden input[type="checkbox"]').prop('checked', true);
                } else if (selectedJenis == 2) {
                    $('#fg-jenis-surat-keluar input[type="checkbox"]').prop('checked', true);
                } else if (selectedJenis == 3) {
                    $('#fg-jenis-surat-masuk input[type="checkbox"]').prop('checked', true);
                }
                resetStates[selectedJenis] = false;
            }
        });
    </script>

    {{-- Change Type --}}
    <script>
        $(document).ready(function() {
            const jenisSelect = $('#jenis');
            const startDateInput = $('#startDate');
            const endDateInput = $('#endDate');

            function updateDatesAndVisibility() {
                const selectedOption = jenisSelect.find('option:selected');
                startDateInput.val(selectedOption.data('start-date'));
                endDateInput.val(selectedOption.data('end-date'));

                $('#fg-insiden').addClass('d-none')
                $('#fg-jenis-surat-keluar').addClass('d-none')
                $('#fg-jenis-surat-masuk').addClass('d-none')

                if ($('#tab-info').val() == 'table-tab') {
                    if (selectedOption.val() == 1) {
                        $('#fg-insiden').removeClass('d-none')
                    } else if (selectedOption.val() == 2) {
                        $('#fg-jenis-surat-keluar').removeClass('d-none')
                    } else if (selectedOption.val() == 3) {
                        $('#fg-jenis-surat-masuk').removeClass('d-none')
                    }

                }
            }

            jenisSelect.on('change', updateDatesAndVisibility);
            updateDatesAndVisibility(); // Set initial state
        });
    </script>

    {{-- Form Submit --}}
    <script>
        $(document).ready(function() {
            $('.tab-link').click(function() {
                $('#tab-info').val($(this).attr('id'))

                if ($('#tab-info').val() == 'diagram-tab') {
                    $('#fg-insiden').addClass('d-none')
                    $('#fg-jenis-surat-keluar').addClass('d-none')
                    $('#fg-jenis-surat-masuk').addClass('d-none')
                } else {
                    const jenisSelect = $('#jenis');
                    const selectedOption = jenisSelect.find('option:selected');

                    if (selectedOption.val() == 1) {
                        $('#fg-insiden').removeClass('d-none')
                    } else if (selectedOption.val() == 2) {
                        $('#fg-jenis-surat-keluar').removeClass('d-none')
                    } else if (selectedOption.val() == 3) {
                        $('#fg-jenis-surat-masuk').removeClass('d-none')
                    }
                }
            })

            $('#jenis').change(function() {
                // Clear the table view
                $('#tab-table').empty();
                $('#tab-table').append(
                    '<div class="text-center my-5"><h5><em>Proses Data Terlebih Dahulu</em></h5></div>')
                $('#tab-diagram').empty();
                $('#tab-diagram').append(
                    '<div class="text-center my-5"><h5><em>Proses Data Terlebih Dahulu</em></h5></div>')
            });

            $('#proses').click(function() {
                const url = '{{ route('rekapitulasi.index') }}'
                $('#form-process').off('submit').on('submit', function(e) {
                    e.preventDefault();

                    $.ajax({
                        url: url,
                        type: 'GET',
                        data: $(this).serialize(),
                        success: function(response) {
                            if ($('#tab-info').val() == 'diagram-tab') {
                                $('#tab-diagram').html(response);
                                const jenisSelect = $('#jenis');
                                const selectedOption = jenisSelect.find(
                                    'option:selected');

                                if (selectedOption.val() == 1) {
                                    initializeChartsTemuan();
                                } else if (selectedOption.val() == 2) {
                                    initializeChartsSuratKeluar()
                                } else if (selectedOption.val() == 3) {
                                    initializeChartsSuratMasuk()
                                }
                            } else if ($('#tab-info').val() == 'table-tab') {
                                $('#tab-table').html(response);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr.responseText);
                        }
                    });
                });
            })

            $(document).on('click', '.export-table', function() {
                const url = '{{ route('rekapitulasi.exportRekapitulasi') }}';
                const selectedJenis = $('#jenis option:selected').text().trim();

                const fileName = `Rekapitulasi_${selectedJenis}.xlsx`;

                $('#form-process').attr('action', url);

                $('#form-process').off('submit').on('submit', function(e) {});

                $('#form-process').submit();

            });
        });
    </script>
@endpush
