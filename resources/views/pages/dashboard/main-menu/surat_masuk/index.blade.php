@extends('layouts.app')

@section('title', 'Surat Masuk')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Data @yield('title')</h1>
                <div class="section-header-breadcrumb">
                    <x-partials.elements.buttons.add :href="route('surat_masuk.create')" />
                </div>
            </div>

            @include('components.partials.alerts.session')
            @include('components.partials.confirms.delete')

            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <h4>Tabel Data @yield('title')</h4>
                        <div class="card-header-action">
                            @include('components.partials.elements.search')
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table-striped table-md table">
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Tanggal &<br>Nomor Surat</th>
                                    <th>Sifat &<br>Perihal Surat</th>
                                    <th>Jenis Surat & OPD</th>
                                    <th>Aksi</th>
                                </tr>
                                @foreach ($suratMasuk as $item)
                                    <tr>
                                        <td class="text-center">{{ $suratMasuk->firstItem() + $loop->index }}</td>
                                        <td>{{ Carbon\Carbon::createFromFormat('Y-m-d', $item->tanggal)->format('d-m-Y') }}
                                            <br><span class="font-weight-bold d-block mt-1"> {{ $item->nomor }} </span>
                                        </td>
                                        <td>{{ $item->sifatSurat->nama }}<br><span
                                                class="font-weight-bold d-block mt-1">{{ $item->perihalSurat->nama }}</span>
                                        </td>
                                        <td>
                                            <span>{{ $item->jenisSuratMasuk->nama }}</span>
                                            <br>
                                            @if ($item->jenis_surat_masuk_id == 1)
                                                <ol class="pl-3">
                                                    @foreach ($item->suratMasukTerkaitKeluar as $item2)
                                                        <li>
                                                            <span
                                                                class="font-weight-bold d-block mt-1">{{ $item2->suratKeluar->nomor }}</span>
                                                            {{ Carbon\Carbon::parse($item2->suratKeluar->tanggal)->format('d-m-Y') }}
                                                            <div>{{ $item2->suratKeluar->jenisSuratKeluar->nama }}</div>
                                                            <ul class="pl-3">
                                                                @if ($item2->suratKeluar->jenis_surat_keluar_id == 1)
                                                                    @foreach ($item2->suratKeluar->suratKeluarTemuan as $item3)
                                                                        <li>
                                                                            <span>{{ $item3->temuan->opd->nama }}</span>
                                                                        </li>
                                                                    @endforeach
                                                                @else
                                                                    @foreach ($item2->suratKeluar->suratKeluarOpd as $item3)
                                                                        <li>{{ $item3->opd->nama }}</li>
                                                                    @endforeach
                                                                @endif
                                                            </ul>
                                                            <div>
                                                                <a class="btn btn-sm btn-primary"
                                                                    href="{{ route('surat_keluar.show', $item2->surat_keluar_id) }}"
                                                                    target="_blank">
                                                                    <i class="fa fa-eye"></i> Lihat
                                                                </a>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ol>
                                            @else
                                                <ol class="pl-3">
                                                    @foreach ($item->suratMasukOpd as $item3)
                                                        <li><span
                                                                class="font-weight-bold d-block mt-1">{{ $item3->opd->nama }}</span>
                                                        </li>
                                                    @endforeach
                                                </ol>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="group d-flex align-items-center justify-content-center"
                                                style="gap: 5px;">
                                                <div class="d-inline">
                                                    <a class="btn btn-sm btn-primary"
                                                        href="{{ Storage::url('uploads/documents/surat-masuk/' . $item->file) }}"
                                                        target="_blank"><i class="fas fa-file-pdf"></i></a>
                                                </div>
                                                <x-partials.elements.buttons.tables.info :href="route('surat_masuk.show', $item->id)" />
                                                <x-partials.elements.buttons.tables.update :href="route('surat_masuk.edit', $item->id)" />
                                                <x-partials.elements.buttons.tables.destroy :id="$item->id"
                                                    :nama="'nomor ' . $loop->iteration" :href="route('surat_masuk.destroy', $item->id)" />
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <x-partials.elements.pagination :paginator="$suratMasuk" />
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@include('components.partials.pushs.scripts.delete')
