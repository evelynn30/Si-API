@extends('layouts.app')

@section('title', 'Tambah Data Sifat Surat')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>@yield('title')</h1>
                <div class="section-header-breadcrumb">
                    <x-partials.elements.buttons.back :href="route('sifat_surat.index')" />
                </div>
            </div>

            @include('components.partials.alerts.list-error')

            <div class="section-body">
                <form action="{{ route('sifat_surat.store') }}" method="POST" autocomplete="off">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h4>Form @yield('title')</h4>
                        </div>
                        <div class="card-body pb-0">
                            <div class="row">
                                <div class="col-md-6">
                                    <x-partials.elements.form-group.input label="Sifat Surat" name="nama" id="nama"
                                        :value="old('nama')" />
                                </div>
                                <div class="col-md-6">
                                    <x-partials.elements.form-group.check-status label="Status" name="status"
                                        id="status" :value="old('status')" class="custom-switch-input" checked=1 />
                                </div>
                            </div>
                        </div>
                        <div class="card-footer pt-0 text-right">
                            <x-partials.elements.buttons.back :href="route('sifat_surat.index')" />
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

    <!-- Page Specific JS File -->
@endpush
