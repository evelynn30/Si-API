@extends('layouts.app')

@section('title', 'Surat Keluar')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Data @yield('title')</h1>
                <div class="section-header-breadcrumb">
                    <x-partials.elements.buttons.add :href="route('surat_keluar.create')" />
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
                                @foreach ($suratKeluar as $item)
                                    <tr>
                                        <td class="text-center">{{ $suratKeluar->firstItem() + $loop->index }}</td>
                                        <td>{{ Carbon\Carbon::createFromFormat('Y-m-d', $item->tanggal)->format('d-m-Y') }}
                                            <br><span class="font-weight-bold d-block mt-1"> {{ $item->nomor }} </span>
                                        </td>
                                        <td>{{ $item->sifatSurat->nama }}<br><span
                                                class="font-weight-bold d-block mt-1">{{ $item->perihalSurat->nama }}</span>
                                        </td>
                                        <td>
                                            <span>{{ $item->jenisSuratKeluar->nama }}</span>
                                            <br>
                                            @if ($item->jenis_surat_keluar_id == 1)
                                                <ol class="pl-3">
                                                    @foreach ($item->suratKeluarTemuan as $item2)
                                                        <li><span
                                                                class="font-weight-bold d-block mt-1">{{ $item2->temuan->opd->nama }}
                                                                <br></span>
                                                            {{ $item2->temuan->tanggal }}
                                                            <ul class="pl-3">
                                                                @foreach ($item2->temuan->temuanInsiden as $item3)
                                                                    <li><em>{{ $item3->insiden->nama }}</em></li>
                                                                @endforeach
                                                            </ul>
                                                            <div>
                                                                <a class="btn btn-sm btn-primary"
                                                                    href="{{ route('temuan.show', $item2->temuan_id) }}"
                                                                    target="_blank">
                                                                    <i class="fa fa-eye"></i> Lihat
                                                                </a>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ol>
                                            @else
                                                <ol class="pl-3">
                                                    @foreach ($item->suratKeluarOpd as $item2)
                                                        <li><span
                                                                class="font-weight-bold d-block mt-1">{{ $item2->opd->nama }}
                                                                <br></span>
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
                                                        href="{{ Storage::url('uploads/documents/surat-keluar/' . $item->file) }}"
                                                        target="_blank"><i class="fas fa-file-pdf"></i></a>
                                                </div>
                                                <x-partials.elements.buttons.tables.info :href="route('surat_keluar.show', $item->id)" />
                                                <x-partials.elements.buttons.tables.update :href="route('surat_keluar.edit', $item->id)" />
                                                <x-partials.elements.buttons.tables.destroy :id="$item->id"
                                                    :nama="'nomor ' . $loop->iteration" :href="route('surat_keluar.destroy', $item->id)" />
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <x-partials.elements.pagination :paginator="$suratKeluar" />
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@include('components.partials.pushs.scripts.delete')
