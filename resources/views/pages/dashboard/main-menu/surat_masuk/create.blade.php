@extends('layouts.app')

@section('title', 'Surat Masuk')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Data @yield('title')</h1>
                <div class="section-header-breadcrumb">
                    <x-partials.elements.buttons.back :href="route('surat_masuk.index')" />
                </div>
            </div>

            @include('components.partials.alerts.list-error')

            <div class="section-body">
                <form action="{{ route('surat_masuk.store') }}" method="POST" autocomplete="off"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h4>Form Tambah Data @yield('title')</h4>
                        </div>
                        <div class="card-body pb-0">
                            <div class="row">
                                <div class="col-md-12">
                                    <x-partials.elements.form-group.select-group label="Jenis Surat"
                                        name="jenis_surat_masuk" id="jenis-surat" :options="$jenisSuratMasuk" :value="old('jenis_surat_masuk', 1)" />
                                </div>
                                <div class="col-md-12 {!! old('jenis_surat_masuk', 1) != 1 ? 'd-none' : '' !!}" id="col-data-surat-keluar">
                                    <x-partials.elements.form-group.select-multiple label="Data Surat Keluar"
                                        name="data_surat_keluar" placeholder="Pilih Data Surat Keluar" :options="$suratKeluar"
                                        :value="old('data_surat_keluar')" />
                                </div>
                                <div class="col-md-12 {!! old('opd', 1) == 1 ? 'd-none' : '' !!}" id="col-opd">
                                    <x-partials.elements.form-group.select-multiple label="OPD" name="opd"
                                        placeholder="Pilih OPD" :options="$opd" :value="old('opd')" />
                                </div>
                                <div class="col-md-6">
                                    <x-partials.elements.form-group.input label="Tanggal" type="date" name="tanggal"
                                        id="tanggal" :value="old('tanggal')" />
                                </div>
                                <div class="col-md-6">
                                    <x-partials.elements.form-group.input label="Nomor Surat" name="nomor" id="nomor"
                                        :value="old('nomor')" />
                                </div>
                                <div class="col-md-6">
                                    <x-partials.elements.form-group.select label="Sifat Surat" name="sifat_surat"
                                        placeholder="Pilih Sifat Surat" :options="$sifatSurat" :value="old('sifat_surat')" />
                                </div>
                                <div class="col-md-6">
                                    <x-partials.elements.form-group.select label="Perihal Surat" name="perihal_surat"
                                        placeholder="Pilih Perihal Surat" :options="$perihalSurat" :value="old('perihal_surat')" />
                                </div>
                            </div>
                            <x-partials.elements.form-group.upload-file label="File Surat (sudah ttd/tte)" name="file"
                                id="file" placeholder="Upload File" />
                        </div>
                        <div class="card-footer pt-0 text-right">
                            <x-partials.elements.buttons.back :href="route('surat_masuk.index')" />
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
            const initialSelectedValue = $('input[name="jenis_surat_masuk"]:checked').val();
            if (initialSelectedValue == 1) {
                $('#col-data-surat-keluar').removeClass('d-none');
                $('#col-opd').addClass('d-none');
            } else {
                $('#col-data-surat-keluar').addClass('d-none');
                $('#col-opd').removeClass('d-none');
            }

            $('input[name="jenis_surat_masuk"]').on('click', function() {
                const selectedValue = $(this).val();
                if (selectedValue == 1) {
                    $('#col-data-surat-keluar').removeClass('d-none');
                    $('#col-opd').addClass('d-none');
                } else {
                    $('#col-data-surat-keluar').addClass('d-none');
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
