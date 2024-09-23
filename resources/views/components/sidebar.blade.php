<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <span style="font-weight: bold">Si-API</span>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <span>
                <img src="{{ asset('assets/img/logo-api.png') }}" alt="Si-AI"
                    style="max-width: 30px; max-height: 30px;">
            </span>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class='{{ Request::is('dashboard') ? 'active' : '' }}'>
                <a class="nav-link" href="{{ route('dashboard.index') }}"><i
                        class="fas fa-tachometer-alt"></i><span>Dashboard</span></a>
            </li>
            <li class="menu-header">Menu Utama</li>
            <li class="{{ Request::is('temuan*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('temuan.index') }}"><i class="fas fa-search"></i>
                    <span>Temuan</span></a>
            </li>
            <li class="{{ Request::is('surat_keluar*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('surat_keluar.index') }}"><i class="fas fa-file-upload"></i>
                    <span>Surat Keluar</span></a>
            </li>
            <li class="{{ Request::is('surat_masuk*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('surat_masuk.index') }}"><i class="fas fa-file-download"></i>
                    <span>Surat Masuk</span></a>
            </li>
            <li class="{{ Request::is('rekapitulasi*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('rekapitulasi.index') }}"><i class="fas fa-poll"></i>
                    <span>Rekapitulasi</span></a>
            </li>

            <li class="menu-header">Master Data</li>
            <li class="{{ Request::is('insiden*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('insiden.index') }}"><i class="far fa-pen-to-square"></i>
                    <span>Insiden</span></a>
            </li>
            <li class="{{ Request::is('opd*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('opd.index') }}"><i class="far fa-pen-to-square"></i>
                    <span>OPD</span></a>
            </li>
            <li class="{{ Request::is('penemu*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('penemu.index') }}"><i class="far fa-pen-to-square"></i>
                    <span>Penemu</span></a>
            </li>
            <li class="{{ Request::is('perihal_surat*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('perihal_surat.index') }}"><i class="far fa-pen-to-square"></i>
                    <span>Perihal Surat</span></a>
            </li>
            <li class="{{ Request::is('sifat_surat*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('sifat_surat.index') }}"><i class="far fa-pen-to-square"></i>
                    <span>Sifat Surat</span></a>
            </li>
            <li class="{{ Request::is('jenis_surat_keluar*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('jenis_surat_keluar.index') }}"><i class="far fa-pen-to-square"></i>
                    <span>Jenis Surat Keluar</span></a>
            </li>
            <li class="{{ Request::is('jenis_surat_masuk*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('jenis_surat_masuk.index') }}"><i class="far fa-pen-to-square"></i>
                    <span>Jenis Surat Masuk</span></a>
            </li>
        </ul>
    </aside>
</div>
