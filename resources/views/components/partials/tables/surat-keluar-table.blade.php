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

    {{-- masih error --}}
    @foreach ($data as $item)
        @php
            $no = $loop->iteration;
            $r = rand(180, 255); // Rentang nilai Red (kalem)
            $g = rand(180, 255); // Rentang nilai Green (kalem)
            $b = rand(180, 255); // Rentang nilai Blue (kalem)

            // Mengonversi nilai RGB menjadi format hex
            $randomColor = sprintf('#%02x%02x%02x', $r, $g, $b);

        @endphp
        @if ($item->jenis_surat_keluar_id == 1)
            @foreach ($item->suratKeluarTemuan as $item2)
                @if (!$opdReq || ($item2->temuan && $item2->temuan->opd_id == $opdReq))
                    <tr class="font-weight-bold" style="background-color: {{ $randomColor }}">
                        <td class="text-center">{{ $no }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                        <td>{{ $item->nomor }}</td>
                        <td>{{ $item2->temuan->opd->nama }}</td>
                        <td>{{ $item->sifatSurat->nama }}</td>
                        <td>{{ $item->perihalSurat->nama }}</td>
                        <td>{{ $item->jenisSuratKeluar->nama }}</td>
                    </tr>
                @endif
            @endforeach
        @else
            @foreach ($item->suratKeluarOpd as $item2)
                @if (!$opdReq || $item2->opd_id == $opdReq)
                    <tr class="font-weight-bold" style="background-color: {{ $randomColor }}">
                        <td class="text-center">{{ $no }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                        <td>{{ $item->nomor }}</td>
                        <td>{{ $item2->opd->nama }}</td>
                        <td>{{ $item->sifatSurat->nama }}</td>
                        <td>{{ $item->perihalSurat->nama }}</td>
                        <td>{{ $item->jenisSuratKeluar->nama }}</td>
                    </tr>
                @endif
            @endforeach
        @endif
    @endforeach

</table>
