<li class="nav-small-cap">
    <i class="mdi mdi-dots-horizontal"></i>
    <span class="hide-menu">DASHBOARD</span>
</li>

<li class="sidebar-item">
    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url('dashboard') ?>" aria-expanded="false">
        <i class="mdi mdi-code-equal"></i>
        <span class="hide-menu">Dashboard</span>
    </a>
</li>

<li class="nav-small-cap">
    <i class="mdi mdi-dots-horizontal"></i>
    <span class="hide-menu">Master Data</span>
</li>

<li class="sidebar-item">
    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
        <i class="mdi mdi-code-equal"></i>
        <span class="hide-menu">Wisata</span>
    </a>
    <ul aria-expanded="false" class="collapse  first-level">
        <li class="sidebar-item">
            <a href="<?= base_url('master/wisata/kategori') ?>" class="sidebar-link">
                <i class="mdi mdi-adjust"></i>
                <span class="hide-menu"> Kategori Wisata </span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="<?= base_url('master/wisata/data') ?>" class="sidebar-link">
                <i class="mdi mdi-adjust"></i>
                <span class="hide-menu"> Data & Foto Wisata </span>
            </a>
        </li>
    </ul>
</li>

<li class="sidebar-item">
    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url('master/galeri') ?>" aria-expanded="false">
        <i class="mdi mdi-code-equal"></i>
        <span class="hide-menu">Galeri Wisata</span>
    </a>
</li>


<li class="nav-small-cap">
    <i class="mdi mdi-dots-horizontal"></i>
    <span class="hide-menu">Transaksi</span>
</li>


<li class="sidebar-item">
    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
        <i class="mdi mdi-code-equal"></i>
        <span class="hide-menu">Pemesanan</span>
    </a>
    <ul aria-expanded="false" class="collapse  first-level">
        <li class="sidebar-item">
            <a href="<?= base_url('transaksi/pemesanan/semua') ?>" class="sidebar-link">
                <i class="mdi mdi-adjust"></i>
                <span class="hide-menu"> Semua Pemesanan </span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="<?= base_url('transaksi/pemesanan/belum') ?>" class="sidebar-link">
                <i class="mdi mdi-adjust"></i>
                <span class="hide-menu"> Pemesanan Belum Bayar </span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="<?= base_url('transaksi/pemesanan/sudah') ?>" class="sidebar-link">
                <i class="mdi mdi-adjust"></i>
                <span class="hide-menu"> Pemesanan Sudah Bayar</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="<?= base_url('transaksi/pemesanan/ditolak') ?>" class="sidebar-link">
                <i class="mdi mdi-adjust"></i>
                <span class="hide-menu"> Pemesanan Ditolak</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="<?= base_url('transaksi/pemesanan/dibatalkan') ?>" class="sidebar-link">
                <i class="mdi mdi-adjust"></i>
                <span class="hide-menu"> Pemesanan Dibatalkan</span>
            </a>
        </li>
    </ul>
</li>


<!-- <li class="nav-small-cap">
    <i class="mdi mdi-dots-horizontal"></i>
    <span class="hide-menu">Laporan</span>
</li>

<li class="sidebar-item">
    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url('laporan/pemesanan') ?>" aria-expanded="false">
        <i class="mdi mdi-code-equal"></i>
        <span class="hide-menu">Data Pemesanan</span>
    </a>
</li> -->