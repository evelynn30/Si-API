@extends('layouts.app')

@section('title', 'Data Sifat Surat')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>@yield('title')</h1>
                <div class="section-header-breadcrumb">
                    <x-partials.elements.buttons.add :href="route('sifat_surat.create')" />
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
                                    <th>Sifat Surat</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                                @foreach ($sifatSurat as $item)
                                    <tr>
                                        <td class="text-center">{{ $sifatSurat->firstItem() + $loop->index }}</td>
                                        <td style="width: 60%">{{ $item->nama }}</td>
                                        <td class="text-center">
                                            <x-partials.elements.status.tables.icon :status="$item->status" />
                                        </td>
                                        <td class="text-center">
                                            <div class="group d-flex align-items-center justify-content-center"
                                                style="gap: 5px;">
                                                <x-partials.elements.buttons.tables.info :href="route('sifat_surat.show', $item->id)" />
                                                <x-partials.elements.buttons.tables.update :href="route('sifat_surat.edit', $item->id)" />
                                                <x-partials.elements.buttons.tables.destroy :id="$item->id"
                                                    :nama="$item->nama" :href="route('sifat_surat.destroy', $item->id)" />
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <x-partials.elements.pagination :paginator="$sifatSurat" />
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@include('components.partials.pushs.scripts.delete')
