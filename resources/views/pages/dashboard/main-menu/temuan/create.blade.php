@extends('layouts.app')

@section('title', 'Tambah Data Temuan')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>@yield('title')</h1>
                <div class="section-header-breadcrumb">
                    <x-partials.elements.buttons.back :href="route('temuan.index')" />
                </div>
            </div>

            @include('components.partials.alerts.list-error')

            <div class="section-body">
                <form action="{{ route('temuan.store') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h4>Form @yield('title')</h4>
                        </div>
                        <div class="card-body pb-0">
                            <div class="row">
                                <div class="col-md-4">
                                    <x-partials.elements.form-group.input label="Tanggal Temuan" type="datetime-local"
                                        name="tanggal" id="tanggal" :value="old('tanggal')" />
                                </div>
                                <div class="col-md-8">
                                    <x-partials.elements.form-group.select label="Instansi/OPD" name="opd"
                                        placeholder="Pilih Instansi/OPD" :options="$opd" :value="old('opd')" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <x-partials.elements.form-group.select label="Penemu" name="penemu"
                                        placeholder="Pilih Penemu" :options="$penemu" :value="old('penemu')" />
                                </div>
                                <div class="col-md-8">
                                    <x-partials.elements.form-group.input label="URL Sistem Elektronik" name="url"
                                        id="url" :value="old('url')" />
                                </div>
                            </div>
                            <x-partials.elements.form-group.select-multiple label="Insiden" name="insiden"
                                placeholder="Pilih Insiden" :options="$insiden" :value="old('insiden')" />
                            <x-partials.elements.form-group.select-group label="Status" name="status" id="status"
                                :options="[
                                    0 => [
                                        'value' => 0,
                                        'label' => 'Baru Ditemukan',
                                    ],
                                    1 => [
                                        'value' => 1,
                                        'label' => 'Menunggu Tanggapan',
                                    ],
                                    2 => [
                                        'value' => 2,
                                        'label' => 'Dalam Penanganan',
                                    ],
                                    3 => [
                                        'value' => 3,
                                        'label' => 'Selesai',
                                    ],
                                ]" />

                            <x-partials.elements.form-group.upload-image label="Gambar" name="gambar"
                                placeholder="PILIH GAMBAR" :value="old('image')" />

                            <div class="card-footer pt-0 text-right">
                                <x-partials.elements.buttons.back :href="route('temuan.index')" />
                                <x-partials.elements.buttons.submit />
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/upload-preview/upload-preview.js') }}"></script>
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $.uploadPreview({
                input_field: "#image-upload",
                preview_box: "#image-preview",
                label_field: "#image label",
                label_default: "PILIH GAMBAR",
                label_selected: "Ganti Gambar"
            });
        });
    </script>
    <!-- Page Specific JS File -->
@endpush
