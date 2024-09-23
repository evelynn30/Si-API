@extends('layouts.app')

@section('title', 'Ubah Data Insiden')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>@yield('title')</h1>
                <div class="section-header-breadcrumb">
                    <x-partials.elements.buttons.back :href="route('insiden.index')" />
                </div>
            </div>

            @include('components.partials.alerts.list-error')

            <div class="section-body">
                <form action="{{ route('insiden.update', $insiden) }}" method="POST" autocomplete="off">
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-header">
                            <h4>Form @yield('title')</h4>
                        </div>
                        <div class="card-body pb-0">
                            <x-partials.elements.form-group.input label="Nama Insiden" name="nama" id="nama"
                                :value="old('nama', $insiden->nama)" />

                            <x-partials.elements.form-group.input-textarea label="Deskripsi" name="deskripsi" id="deskripsi"
                                type="textarea" :value="old('deskripsi', $insiden->deskripsi)" />

                            <x-partials.elements.form-group.check-status label="Status" name="status" id="status"
                                :value="old('status', $insiden->status)" class="custom-switch-input" />
                        </div>
                        <div class="card-footer pt-0 text-right">
                            <x-partials.elements.buttons.back :href="route('insiden.index')" />

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
