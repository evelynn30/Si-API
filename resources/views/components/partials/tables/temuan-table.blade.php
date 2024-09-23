<table class="table-md table">
    <thead class="thead-dark">
        <tr class="text-center" style="background-color: ">
            <th>No</th>
            <th>Tanggal</th>
            <th>Instansi/OPD</th>
            <th>Insiden</th>
            <th>Penemu</th>
            <th>Status</th>
        </tr>
    </thead>
    @foreach ($data as $item)
        @php
            $no = $loop->iteration;
            $r = rand(180, 255); // Rentang nilai Red (kalem)
            $g = rand(180, 255); // Rentang nilai Green (kalem)
            $b = rand(180, 255); // Rentang nilai Blue (kalem)

            // Mengonversi nilai RGB menjadi format hex
            $randomColor = sprintf('#%02x%02x%02x', $r, $g, $b);

        @endphp
        @foreach ($item->temuanInsiden as $item2)
            {{-- make color random tr --}}

            <tr class="font-weight-bold" style="background-color: {{ $randomColor }}">
                <td class="text-center">{{ $no }}</td>
                <td>
                    {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->tanggal)->format('d-m-Y H:i') }}
                </td>
                <td><span class="d-block mb-1">{{ $item->opd->nama }} <br></span>
                </td>
                <td>
                    {{ $item2->insiden->nama }}
                </td>
                <td>{{ $item->penemu->nama }}
                </td>
                <td>
                    @if ($item->status === 0)
                        <span class="badge badge-info">Baru Ditemukan</span>
                    @elseif ($item->status === 1)
                        <span class="badge badge-danger">Menunggu Tanggapan</span>
                    @elseif ($item->status === 2)
                        <span class="badge badge-warning">Dalam Penanganan</span>
                    @elseif ($item->status === 3)
                        <span class="badge badge-success">Selesai</span>
                    @else
                        <span class="badge badge-secondary">Unknown Status</span>
                    @endif
                </td>
            </tr>
        @endforeach
    @endforeach

</table>
