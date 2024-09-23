@extends('layouts.app')

@section('title', 'Surat Masuk')

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
                        <h4>Form Detail Data @yield('title')</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <x-partials.elements.list-group.item label="Tanggal" :value="Carbon\Carbon::createFromFormat('Y-m-d', $suratMasuk->tanggal)->format('d-m-Y')" />
                            <x-partials.elements.list-group.item label="Nomor Surat" :value="$suratMasuk->nomor" />
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <span>Jenis Surat:</span>
                                    <div class="text-bold font-weight-bold text-right">
                                        <span>{{ $suratMasuk->jenisSuratMasuk->nama }}</span>
                                        @if ($suratMasuk->jenisSuratMasuk->id == 1 && $suratMasuk->suratMasukTerkaitKeluar->isNotEmpty())
                                            @foreach ($suratMasuk->suratMasukTerkaitKeluar as $skTerkaitKeluar)
                                                <div class="mb-2">
                                                    <span class="badge badge-primary ml-1 text-right">
                                                        @php
                                                            $tanggal = Carbon\Carbon::parse(
                                                                $skTerkaitKeluar->suratKeluar->tanggal,
                                                            )->format('d-m-Y');
                                                            $nomor = $skTerkaitKeluar->suratKeluar->nomor;
                                                            $jenisSurat =
                                                                $skTerkaitKeluar->suratKeluar->jenisSuratKeluar->nama;
                                                            $perihalSurat =
                                                                $skTerkaitKeluar->suratKeluar->perihalSurat->nama;
                                                        @endphp
                                                        {{ $tanggal }} - {{ $nomor }} | {{ $jenisSurat }} |
                                                        {{ $perihalSurat }}
                                                    </span>
                                                </div>
                                            @endforeach
                                        @elseif($suratMasuk->jenisSuratMasuk->id != 1 && $suratMasuk->suratMasukOpd->isNotEmpty())
                                            @foreach ($suratMasuk->suratMasukOpd as $skOpd)
                                                <div class="mb-2">
                                                    <span class="badge badge-primary ml-1 text-right">
                                                        {{ $skOpd->opd->nama }}
                                                    </span>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </li>
                            <x-partials.elements.list-group.item label="Sifat Surat" :value="$suratMasuk->sifatSurat->nama" />
                            <x-partials.elements.list-group.item label="Perihal Surat" :value="$suratMasuk->perihalSurat->nama" />
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                File:
                                <span class="text-bold font-weight-bold">
                                    <a class="btn btn-xs btn-primary"
                                        href="{{ Storage::url('uploads/documents/surat-masuk/' . $suratMasuk->file) }}"
                                        target="_blank"><i class="fas fa-lg fa-file-pdf"></i></a>
                                </span>
                            </li>
                        </ul>
                    </div>
                    <div class="card-footer pt-0 text-right">
                        <x-partials.elements.buttons.back :href="route('surat_masuk.index')" />
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
