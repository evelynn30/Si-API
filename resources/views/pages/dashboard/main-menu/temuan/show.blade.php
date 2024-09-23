@extends('layouts.app')

@section('title', 'Detail Data Temuan')

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
                        <ul class="list-group">
                            <x-partials.elements.list-group.item label="Tanggal" :value="Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $temuan->tanggal)->format(
                                'd-m-Y H:i',
                            )" />
                            <x-partials.elements.list-group.item label="Instansi/OPD" :value="$temuan->opd->nama" />
                            <x-partials.elements.list-group.item label="Penemu" :value="$temuan->penemu->nama" />
                            <x-partials.elements.list-group.item label="URL" :value="$temuan->url" />
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <span>Insiden:</span>
                                    <div class="text-right">
                                        @foreach ($temuan->temuanInsiden->chunk(3) as $chunk)
                                            <div class="mb-2">
                                                @foreach ($chunk as $insiden)
                                                    <span
                                                        class="badge badge-primary mr-1">{{ $insiden->insiden->nama }}</span>
                                                @endforeach
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item ">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>Image:</span>
                                    <div>
                                        @if ($temuan->gambar)
                                            <img src="{{ Storage::url('uploads/images/temuan/' . $temuan->gambar) }}"
                                                alt="Temuan Image" class="img-fluid" style="max-width: 200px;">
                                        @else
                                            <span class="text-muted">
                                                Tidak ada gambar yang tersedia</span>
                                        @endif
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Status:
                                @if ($temuan->status == 0)
                                    <span class="badge badge-info">Baru Ditemukan</span>
                                @elseif ($temuan->status == 1)
                                    <span class="badge badge-danger">Menunggu Tanggapan</span>
                                @elseif ($temuan->status == 2)
                                    <span class="badge badge-warning">Dalam Penanganan</span>
                                @elseif ($temuan->status == 3)
                                    <span class="badge badge-success">Selesai</span>
                                @endif
                            </li>
                        </ul>
                    </div>
                    <div class="card-footer pt-0 text-right">
                        <x-partials.elements.buttons.back :href="route('temuan.index')" />
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
