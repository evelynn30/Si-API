<table class="table-md table">
    <thead class="thead-dark">
        <tr class="text-center" style="background-color: ">
            <th>No</th>
            <th>Tanggal</th>
            <th>Nomor Surat</th>
            <th>OPD</th>
            <th>Sifat Surat</th>
            <th>Perihal Surat</th>
            <th>Jenis Surat</th>
        </tr>
    </thead>
    @foreach ($data as $item)
        @php
            $no = $loop->iteration;
            $randomColor = sprintf('#%02x%02x%02x', rand(180, 255), rand(180, 255), rand(180, 255));
        @endphp

        @if ($item->jenis_surat_masuk_id == 1)
            @foreach ($item->suratMasukTerkaitKeluar as $item2)
                @foreach ($item2->suratKeluar->suratKeluarTemuan as $item3)
                    @if (!$opdReq || ($item3->temuan && $item3->temuan->opd_id == $opdReq))
                        <tr class="font-weight-bold" style="background-color: {{ $randomColor }};">
                            <td class="text-center">{{ $no }}</td>
                            <td>{{ Carbon\Carbon::createFromFormat('Y-m-d', $item->tanggal)->format('d-m-Y') }}</td>
                            <td>{{ $item->nomor }}</td>
                            <td>{{ $item3->temuan->opd->nama }} </td>
                            <td>{{ $item->sifatSurat->nama }}</td>
                            <td>{{ $item->perihalSurat->nama }}</td>
                            <td>{{ $item->jenisSuratMasuk->nama }}</td>
                        </tr>
                    @endif
                @endforeach
                @foreach ($item2->suratKeluar->suratKeluarOpd as $item3)
                    @if (!$opdReq || $item3->opd_id == $opdReq)
                        <tr class="font-weight-bold" style="background-color: {{ $randomColor }};">
                            <td class="text-center">{{ $no }}</td>
                            <td>{{ Carbon\Carbon::createFromFormat('Y-m-d', $item->tanggal)->format('d-m-Y') }}</td>
                            <td>{{ $item->nomor }}</td>
                            <td> {{ $item3->opd->nama }}</td>
                            <td>{{ $item->sifatSurat->nama }}</td>
                            <td>{{ $item->perihalSurat->nama }}</td>
                            <td>{{ $item->jenisSuratMasuk->nama }}</td>
                        </tr>
                    @endif
                @endforeach
            @endforeach
        @else
            @foreach ($item->suratMasukOpd as $item2)
                @if (!$opdReq || $item2->opd_id == $opdReq)
                    <tr class="font-weight-bold" style="background-color: {{ $randomColor }};">
                        <td class="text-center">{{ $no }}</td>
                        <td>{{ Carbon\Carbon::createFromFormat('Y-m-d', $item->tanggal)->format('d-m-Y') }}</td>
                        <td>{{ $item->nomor }}</td>
                        <td>{{ $item2->opd->nama }}</td>
                        <td>{{ $item->sifatSurat->nama }}</td>
                        <td>{{ $item->perihalSurat->nama }}</td>
                        <td>{{ $item->jenisSuratMasuk->nama }}</td>
                    </tr>
                @endif
            @endforeach
        @endif
    @endforeach


</table>
