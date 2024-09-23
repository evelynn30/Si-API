@extends('layouts.app')

@section('title', 'Surat Keluar')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Ubah Data @yield('title')</h1>
                <div class="section-header-breadcrumb">
                    <x-partials.elements.buttons.back :href="route('surat_keluar.index')" />
                </div>
            </div>

            @include('components.partials.alerts.list-error')

            <div class="section-body">
                <form action="{{ route('surat_keluar.update', $suratKeluar->id) }}" method="POST" autocomplete="off"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-header">
                            <h4>Form Ubah Data @yield('title')</h4>
                        </div>
                        <div class="card-body pb-0">
                            <div class="row">
                                <div class="col-md-12">
                                    <x-partials.elements.form-group.select-group label="Jenis Surat"
                                        name="jenis_surat_keluar" id="jenis-surat" :options="$jenisSuratKeluar" :value="old('jenis_surat_keluar', $suratKeluar->jenis_surat_keluar_id)" />
                                </div>
                                <div class="col-md-12 {!! old('jenis_surat_keluar', $suratKeluar->jenis_surat_keluar) != 1 ? 'd-none' : '' !!}" id="col-data-temuan">
                                    <x-partials.elements.form-group.select-multiple label="Data Temuan" name="data_temuan"
                                        placeholder="Pilih Data Temuan" :options="$temuan" :value="old('data_temuan', $selectedTemuan)" />
                                </div>
                                <div class="col-md-12 {!! old('opd', 1) == 1 ? 'd-none' : '' !!}" id="col-opd">
                                    <x-partials.elements.form-group.select-multiple label="OPD" name="opd"
                                        placeholder="Pilih OPD" :options="$opd" :value="old('opd', $selectedOpd)" />
                                </div>
                                <div class="col-md-6">
                                    <x-partials.elements.form-group.input label="Tanggal" type="date" name="tanggal"
                                        id="tanggal" :value="old('tanggal', $suratKeluar->tanggal)" />
                                </div>
                                <div class="col-md-6">
                                    <x-partials.elements.form-group.input label="Nomor Surat" name="nomor" id="nomor"
                                        :value="old('nomor', $suratKeluar->nomor)" />
                                </div>
                                <div class="col-md-6">
                                    <x-partials.elements.form-group.select label="Sifat Surat" name="sifat_surat"
                                        placeholder="Pilih Sifat Surat" :options="$sifatSurat" :value="old('sifat_surat', $suratKeluar->sifat_surat_id)" />
                                </div>
                                <div class="col-md-6">
                                    <x-partials.elements.form-group.select label="Perihal Surat" name="perihal_surat"
                                        placeholder="Pilih Perihal Surat" :options="$perihalSurat" :value="old('perihal_surat', $suratKeluar->perihal_surat_id)" />
                                </div>
                            </div>
                            <x-partials.elements.form-group.upload-file label="File Surat (sudah ttd/tte)" name="file"
                                id="file" placeholder="Upload File" :value="$suratKeluar->file"
                                path="uploads/documents/surat-keluar/" />
                        </div>
                        <div class="card-footer pt-0 text-right">
                            <x-partials.elements.buttons.back :href="route('surat_keluar.index')" />
                            <x-partials.elements.buttons.submit />
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/bs-custom-file-input.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            const initialSelectedValue = $('input[name="jenis_surat_keluar"]:checked').val();
            if (initialSelectedValue == 1) {
                $('#col-data-temuan').removeClass('d-none');
                $('#col-opd').addClass('d-none');
            } else {
                $('#col-data-temuan').addClass('d-none');
                $('#col-opd').removeClass('d-none');
            }

            $('input[name="jenis_surat_keluar"]').on('click', function() {
                const selectedValue = $(this).val();
                if (selectedValue == 1) {
                    $('#col-data-temuan').removeClass('d-none');
                    $('#col-opd').addClass('d-none');
                } else {
                    $('#col-data-temuan').addClass('d-none');
                    $('#col-opd').removeClass('d-none');
                }
            });
        });

        $(document).ready(function() {
            bsCustomFileInput.init()
        })
    </script>
    <!-- Page Specific JS File -->
@endpush
