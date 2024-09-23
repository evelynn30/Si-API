@extends('layouts.app')

@section('title', 'Surat Keluar')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Detail Data @yield('title')</h1>
                <div class="section-header-breadcrumb">
                    <x-partials.elements.buttons.back :href="url()->previous()" />
                </div>
            </div>
            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <h4>Form Detail Data @yield('title')</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <x-partials.elements.list-group.item label="Tanggal" :value="Carbon\Carbon::createFromFormat('Y-m-d', $suratKeluar->tanggal)->format('d-m-Y')" />
                            <x-partials.elements.list-group.item label="Nomor Surat" :value="$suratKeluar->nomor" />
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <span>Jenis Surat:</span>
                                    <div class="text-bold font-weight-bold text-right">
                                        <span>{{ $suratKeluar->jenisSuratKeluar->nama }}</span>
                                        @if ($suratKeluar->jenisSuratKeluar->id == 1 && $suratKeluar->suratKeluarTemuan->isNotEmpty())
                                            @foreach ($suratKeluar->suratKeluarTemuan as $skTemuan)
                                                <div class="mb-2">
                                                    <span class="badge badge-primary ml-1 text-right">
                                                        @php
                                                            $opd = $skTemuan->temuan->opd->nama;
                                                            $tanggal = Carbon\Carbon::parse(
                                                                $skTemuan->temuan->tanggal,
                                                            )->format('d-m-Y');
                                                            $temuanItem = $skTemuan->temuan->temuanInsiden
                                                                ->pluck('insiden.nama')
                                                                ->implode(', ');
                                                        @endphp
                                                        {!! $tanggal . ' - ' . $opd . ' <span class="font-weight-bold d-block mt-1"><em>' . $temuanItem . '</em></span>' !!}
                                                    </span>
                                                </div>
                                            @endforeach
                                        @elseif($suratKeluar->jenisSuratKeluar->id != 1 && $suratKeluar->suratKeluarOpd->isNotEmpty())
                                            @foreach ($suratKeluar->suratKeluarOpd as $skOpd)
                                                <div class="mb-2">
                                                    <span class="badge badge-primary ml-1 text-right">
                                                        @php
                                                            $opd = $skOpd->opd->nama;

                                                        @endphp
                                                        {!! $opd !!}
                                                    </span>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </li>
                            <x-partials.elements.list-group.item label="Sifat Surat" :value="$suratKeluar->sifatSurat->nama" />
                            <x-partials.elements.list-group.item label="Perihal Surat" :value="$suratKeluar->perihalSurat->nama" />
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                File:
                                <span class="text-bold font-weight-bold">
                                    <a class="btn btn-xs btn-primary"
                                        href="{{ Storage::url('uploads/documents/surat-keluar/' . $suratKeluar->file) }}"
                                        target="_blank"><i class="fas fa-lg fa-file-pdf"></i></a>
                                </span>
                            </li>
                        </ul>
                    </div>
                    <div class="card-footer pt-0 text-right">
                        <x-partials.elements.buttons.back :href="route('surat_keluar.index')" />
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
