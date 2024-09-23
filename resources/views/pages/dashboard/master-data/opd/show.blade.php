@extends('layouts.app')

@section('title', 'Detail Data OPD')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>@yield('title')</h1>
                <div class="section-header-breadcrumb">
                    <x-partials.elements.buttons.back :href="url()->previous()" />
                </div>
            </div>
            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <h4>Form @yield('title')</h4>
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            <x-partials.elements.list-group.item label="Nama OPD" :value="$opd->nama" />
                            <x-partials.elements.list-group.item label="Alamat" :value="$opd->alamat" />
                            <x-partials.elements.list-group.item label="Nama Narahubung" :value="$opd->narahubung" />
                            <x-partials.elements.list-group.item label="Nomor Telepon" :value="$opd->no_telp" />
                            <x-partials.elements.list-group.item-badge label="Status" :value="$opd->status" trueText="Aktif"
                                falseText="Tidak Aktif" />
                        </div>
                    </div>
                    <div class="card-footer pt-0 text-right">
                        <x-partials.elements.buttons.back :href="url()->previous()" />
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->

    <!-- Page Specific JS File -->
@endpush
