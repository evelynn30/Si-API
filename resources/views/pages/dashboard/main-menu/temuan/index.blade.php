@extends('layouts.app')

@section('title', 'Data Temuan')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>@yield('title')</h1>
                <div class="section-header-breadcrumb">
                    <x-partials.elements.buttons.add :href="route('temuan.create')" />
                </div>
            </div>

            @include('components.partials.alerts.session')

            @include('components.partials.confirms.delete')

            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <h4>Tabel @yield('title')</h4>
                        <div class="card-header-action">
                            @include('components.partials.elements.search')
                        </div>
                    </div>

                    <div class="card-body">
                        <x-partials.elements.buttons.tables.filter-status-temuan :allCount="$allCount" :baruCount="$baruCount"
                            :menungguCount="$menungguCount" :penangananCount="$penangananCount" :selesaiCount="$selesaiCount" />
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table-striped table-md table">
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Instansi/OPD & Tanggal</th>
                                    <th>Penemu <br>& <br>Insiden</th>
                                    <th>Status <br>&<br>URL OPD</th>
                                    <th>Surat Penyampaian</th>
                                    <th>Surat Balasan</th>
                                    <th>Aksi</th>
                                </tr>
                                @foreach ($temuan as $item)
                                    <tr>
                                        <td class="text-center">{{ $temuan->firstItem() + $loop->index }}</td>
                                        <td><span class="font-weight-bold d-block mb-1">{{ $item->opd->nama }} <br></span>
                                            {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->tanggal)->format('d-m-Y H:i') }}

                                        </td>
                                        <td><span class="font-weight-bold d-block mt-1">{{ $item->penemu->nama }}
                                                <br></span>
                                            @if ($item->temuanInsiden->count() > 1)
                                                <ol class="pl-3">
                                                    @foreach ($item->temuanInsiden as $insiden)
                                                        <li>{{ $insiden->insiden->nama }}</li>
                                                    @endforeach
                                                </ol>
                                            @else
                                                {{ $item->temuanInsiden->first()->insiden->nama }}
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($item->status == 0)
                                                <span class="badge badge-info">Baru Ditemukan</span>
                                            @elseif ($item->status == 1)
                                                <span class="badge badge-danger">Menunggu Tanggapan</span>
                                            @elseif ($item->status == 2)
                                                <span class="badge badge-warning">Dalam Penanganan</span>
                                            @elseif ($item->status == 3)
                                                <span class="badge badge-success">Selesai</span>
                                            @endif
                                            <br>
                                            <a href="{{ $item->url }}" target="_blank"
                                                class="btn btn-sm btn-primary mt-1" style="white-space: nowrap">
                                                <i class="fa-solid fa-globe"></i> Kunjungi</a>
                                        </td>

                                        <td>
                                            <ol class="pl-3">
                                                @if ($item->suratKeluarTemuan->count() > 1)
                                                    @forelse ($item->suratKeluarTemuan as $item2)
                                                        <li>
                                                            <div>
                                                                <span class="font-weight-bold">
                                                                    {{ $item2->suratKeluar->nomor }}
                                                                </span>
                                                            </div>
                                                            <div>
                                                                {{ \Carbon\Carbon::createFromFormat('Y-m-d', $item2->suratKeluar->tanggal)->format('d-m-Y') }}
                                                            </div>
                                                            <div>
                                                                <a class="btn btn-sm btn-primary mb-2"
                                                                    href="{{ route('surat_keluar.show', $item2->surat_keluar_id) }}"
                                                                    target="_blank">
                                                                    <i class="fa fa-eye"></i> Lihat
                                                                </a>
                                                            </div>
                                                        </li>
                                                    @empty
                                                        <li class="text-center">
                                                            <span class="badge badge-secondary">Belum ada</span>
                                                        </li>
                                                    @endforelse
                                                @else
                                                    @forelse ($item->suratKeluarTemuan as $item2)
                                                        <div>
                                                            <span
                                                                class="font-weight-bold">{{ $item2->suratKeluar->nomor }}</span>
                                                        </div>
                                                        <div>
                                                            {{ \Carbon\Carbon::createFromFormat('Y-m-d', $item2->suratKeluar->tanggal)->format('d-m-Y') }}
                                                        </div>
                                                        <div>
                                                            <a class="btn btn-sm btn-primary mb-2"
                                                                href="{{ route('surat_keluar.show', $item2->surat_keluar_id) }}"
                                                                target="_blank">
                                                                <i class="fa fa-eye"></i> Lihat
                                                            </a>
                                                        </div>
                                                    @empty
                                                        <span class="badge badge-secondary">Belum ada</span>
                                                    @endforelse
                                                @endif
                                            </ol>
                                        </td>

                                        <td>
                                            @if ($item->suratKeluarTemuan->count())
                                                <ol class="pl-3">
                                                    @forelse ($item->suratKeluarTemuan as $item2)
                                                        @if ($item2->balasanSuratKeluar->count())
                                                            @if ($item2->balasanSuratKeluar->count() == 1)
                                                                @if ($item->suratKeluarTemuan->count() > 1)
                                                                    <li>
                                                                        <span class="font-weight-bold">
                                                                            {{ $item2->suratKeluar->nomor }}
                                                                        </span>
                                                                        <div>
                                                                            {{ Carbon\Carbon::createFromFormat('Y-m-d', $item2->suratKeluar->tanggal)->format('d-m-Y') }}
                                                                        </div>
                                                                    </li>
                                                                @endif
                                                                <div>
                                                                    <span class="font-weight-bold">
                                                                        {{ $item2->balasanSuratKeluar->first()->suratMasuk->nomor }}
                                                                    </span>
                                                                    <div>
                                                                        {{ Carbon\Carbon::createFromFormat('Y-m-d', $item2->suratKeluar->tanggal)->format('d-m-Y') }}
                                                                    </div>
                                                                    <a href="{{ route('surat_masuk.show', $item2->balasanSuratKeluar->first()->surat_masuk_id) }}"
                                                                        class="btn btn-sm btn-primary" target="_blank">
                                                                        <i class="fa fa-eye"></i> Lihat
                                                                    </a>
                                                                </div>
                                                            @elseif($item2->balasanSuratKeluar->count() > 1)
                                                                <li>
                                                                    <span class="font-weight-bold">
                                                                        {{ $item2->suratKeluar->nomor }}
                                                                    </span>
                                                                    <div>
                                                                        {{ Carbon\Carbon::createFromFormat('Y-m-d', $item2->suratKeluar->tanggal)->format('d-m-Y') }}
                                                                    </div>
                                                                </li>
                                                                <ul class="pl-3">
                                                                    @foreach ($item2->balasanSuratKeluar as $item3)
                                                                        <li>
                                                                            <span class="font-weight-bold">
                                                                                {{ $item3->suratMasuk->nomor }}
                                                                            </span>
                                                                            <div>
                                                                                {{ Carbon\Carbon::createFromFormat('Y-m-d', $item3->suratKeluar->tanggal)->format('d-m-Y') }}
                                                                            </div>
                                                                            <a href="{{ route('surat_masuk.show', $item3->surat_masuk_id) }}"
                                                                                class="btn btn-sm btn-primary mb-2"
                                                                                target="_blank">
                                                                                <i class="fa fa-eye"></i> Lihat
                                                                            </a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            @endif
                                                        @else
                                                            @if ($item2->balasanSuratKeluar->count() == 0 && $item->suratKeluarTemuan->count() == 1)
                                                                <span class="badge badge-secondary">Belum ada</span>
                                                            @endif
                                                        @endif
                                                    @empty
                                                        <li class="text-center">
                                                            <span class="badge badge-secondary">Belum ada</span>
                                                        </li>
                                                    @endforelse
                                                </ol>
                                            @else
                                                <span class="badge badge-secondary">Belum ada</span>
                                            @endif
                                        </td>

                                        <td class="text-center">
                                            <div class="group d-flex align-items-center justify-content-center"
                                                style="gap: 5px;">
                                                <x-partials.elements.buttons.tables.image :id="$item->id"
                                                    :gambar="$item->gambar" />
                                                <x-partials.elements.buttons.tables.info :href="route('temuan.show', $item->id)" />
                                                <x-partials.elements.buttons.tables.update :href="route('temuan.edit', $item->id)" />
                                                <x-partials.elements.buttons.tables.destroy :id="$item->id"
                                                    :nama="'nomor ' . $loop->iteration" :href="route('temuan.destroy', $item->id)" />
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <x-partials.elements.pagination :paginator="$temuan" />
                    </div>
                </div>
            </div>
        </section>
    </div>

    <x-partials.modal id="imageModal" title="Gambar">
        <!-- Images will be injected here -->
    </x-partials.modal>

    <x-partials.modal id="insidenModal" title="Daftar Insiden">
        <!-- Insiden data will be injected here -->
    </x-partials.modal>

@endsection

@include('components.partials.pushs.scripts.modal-image')
@include('components.partials.pushs.scripts.modal-insiden')
@include('components.partials.pushs.scripts.delete')
