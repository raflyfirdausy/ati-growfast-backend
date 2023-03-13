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
        <span class="hide-menu">Gerai</span>
    </a>
    <ul aria-expanded="false" class="collapse  first-level">
        <li class="sidebar-item">
            <a href="<?= base_url('master/gerai/layanan') ?>" class="sidebar-link">
                <i class="mdi mdi-adjust"></i>
                <span class="hide-menu"> Layanan Gerai </span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="<?= base_url('master/gerai/keperluan') ?>" class="sidebar-link">
                <i class="mdi mdi-adjust"></i>
                <span class="hide-menu"> Keperluan Gerai </span>
            </a>
        </li>
    </ul>
</li>

<li class="sidebar-item">
    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
        <i class="mdi mdi-code-equal"></i>
        <span class="hide-menu">Jadwal Gerai</span>
    </a>
    <ul aria-expanded="false" class="collapse  first-level">
        <li class="sidebar-item">
            <a href="<?= base_url('master/jadwal/umum') ?>" class="sidebar-link">
                <i class="mdi mdi-adjust"></i>
                <span class="hide-menu"> Jadwal Umum </span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="<?= base_url('master/jadwal/khusus') ?>" class="sidebar-link">
                <i class="mdi mdi-adjust"></i>
                <span class="hide-menu"> Jadwal Khusus </span>
            </a>
        </li>
    </ul>
</li>

<li class="sidebar-item">
    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
        <i class="mdi mdi-code-equal"></i>
        <span class="hide-menu">Akun</span>
    </a>
    <ul aria-expanded="false" class="collapse  first-level">
        <li class="sidebar-item">
            <a href="<?= base_url('master/akun/petugas-gerai') ?>" class="sidebar-link">
                <i class="mdi mdi-adjust"></i>
                <span class="hide-menu"> Akun Petugas Gerai </span>
            </a>
        </li>
    </ul>
</li>

<li class="nav-small-cap">
    <i class="mdi mdi-dots-horizontal"></i>
    <span class="hide-menu">Transaksi</span>
</li>


<li class="sidebar-item">
    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url('transaksi/antrean') ?>" aria-expanded="false">
        <i class="mdi mdi-code-equal"></i>
        <span class="hide-menu">Antrean</span>
    </a>
</li>


<li class="nav-small-cap">
    <i class="mdi mdi-dots-horizontal"></i>
    <span class="hide-menu">Laporan</span>
</li>

<li class="sidebar-item">
    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url('laporan/pendaftaran-hari-ini') ?>" aria-expanded="false">
        <i class="mdi mdi-code-equal"></i>
        <span class="hide-menu">Pendaftaran Hari ini</span>
    </a>
</li>

<li class="sidebar-item">
    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url('laporan/agregate') ?>" aria-expanded="false">
        <i class="mdi mdi-code-equal"></i>
        <span class="hide-menu">Laporan Agregate</span>
    </a>
</li>

<li class="sidebar-item">
    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url('laporan/grafik') ?>" aria-expanded="false">
        <i class="mdi mdi-code-equal"></i>
        <span class="hide-menu">Laporan Grafik</span>
    </a>
</li>

<li class="sidebar-item">
    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url('laporan/statistik') ?>" aria-expanded="false">
        <i class="mdi mdi-code-equal"></i>
        <span class="hide-menu">Pendaftaran Terbanyak</span>
    </a>
</li>