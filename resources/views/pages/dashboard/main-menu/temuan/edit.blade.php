@extends('layouts.app')

@section('title', 'Ubah Data Temuan')

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
                <form action="{{ route('temuan.update', $temuan->id) }}" method="POST" autocomplete="off"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-header">
                            <h4>Form @yield('title')</h4>
                        </div>
                        <div class="card-body pb-0">
                            <div class="row">
                                <div class="col-md-4">
                                    <x-partials.elements.form-group.input label="Tanggal Temuan" type="datetime-local"
                                        name="tanggal" id="tanggal" :value="old('tanggal', $temuan->tanggal)" />
                                </div>
                                <div class="col-md-8">
                                    <x-partials.elements.form-group.select label="Instansi/OPD" name="opd"
                                        placeholder="Pilih Instansi/OPD" :options="$opd" :value="old('opd', $temuan->opd_id)" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <x-partials.elements.form-group.select label="Penemu" name="penemu"
                                        placeholder="Pilih Penemu" :options="$penemu" :value="old('penemu', $temuan->penemu_id)" />
                                </div>
                                <div class="col-md-8">
                                    <x-partials.elements.form-group.input label="URL Sistem Elektronik" name="url"
                                        id="url" :value="old('url', $temuan->url)" />
                                </div>
                            </div>
                            <x-partials.elements.form-group.select-multiple label="Insiden" name="insiden"
                                placeholder="Pilih Insiden" :options="$insiden" :value="old('insiden', $selectedInsiden)" />
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
                                ]" :value="old('status', $temuan->status)" />

                            <x-partials.elements.form-group.upload-image label="Gambar" name="gambar"
                                classFormGroup="d-none" placeholder="PILIH GAMBAR" :value="old('gambar', $temuan->gambar)" />
                            <div class="row">
                                <div class="col-md-4">
                                    <article class="article article-style-b">
                                        <div class="article-header">
                                            <div class="article-image"
                                                data-background="{{ Storage::url('uploads/images/temuan/' . $temuan->gambar) }}">
                                            </div>
                                        </div>
                                        <div class="article-details p-0">
                                            <div class="article-cta">
                                                <button type="button" class="btn btn-primary btn-block"
                                                    id="ubahgambar">Ubah Gambar</button>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer pt-0 text-right">
                            <x-partials.elements.buttons.back :href="route('temuan.index')" />
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

        //d-none image
        document.addEventListener('DOMContentLoaded', function() {
            const showImageUploadBtn = document.getElementById('ubahgambar');
            const formGroupImage = document.getElementById('form-group-image');
            const currentImageArticle = document.querySelector('.article.article-style-b');

            showImageUploadBtn.addEventListener('click', function() {
                formGroupImage.classList.remove('d-none');
                this.classList.add('d-none');
                currentImageArticle.classList.add('d-none');
            });
        });
    </script>



    <!-- Page Specific JS File -->
@endpush
