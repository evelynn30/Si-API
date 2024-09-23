<div>
    <ul class="nav nav-pills">
        <li class="nav-item">
            <a class="nav-link {{ request('status') === null ? 'active' : '' }}" href="{{ route('temuan.index') }}">Semua
                Status
                <span class="badge badge-white">{{ $allCount }}</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request('status') == '0' ? 'active' : '' }}"
                href="{{ route('temuan.index', ['status' => 0]) }}">Baru Ditemukan <span
                    class="badge badge-info">{{ $baruCount }}</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request('status') == '1' ? 'active' : '' }}"
                href="{{ route('temuan.index', ['status' => 1]) }}">Menunggu Tanggapan <span
                    class="badge badge-danger">{{ $menungguCount }}</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request('status') == '2' ? 'active' : '' }}"
                href="{{ route('temuan.index', ['status' => 2]) }}">Dalam Penanganan <span
                    class="badge badge-warning">{{ $penangananCount }}</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request('status') == '3' ? 'active' : '' }}"
                href="{{ route('temuan.index', ['status' => 3]) }}">Selesai <span
                    class="badge badge-success">{{ $selesaiCount }}</span></a>
        </li>
    </ul>
</div>
