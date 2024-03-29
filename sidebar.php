<!-- Sidebar -->
<ul class="navbar-nav bg-black sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard.php">
        <div class="sidebar-brand-icon rotate-n-15">
            <img src="img/logo.png" alt="Logo" width="40">
        </div>
        <div class="sidebar-brand-text mx-3">Markas Pancong UJ</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?= (strpos($_SERVER['REQUEST_URI'], "/dashboard.php") === 0)? 'btn-pancong active' : ''; ?>">
        <a class="nav-link" href="dashboard.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    <hr class="sidebar-divider my-0">
    <li class="nav-item <?= (strpos($_SERVER['REQUEST_URI'], "/pesanan.php") === 0)? 'btn-pancong active' : ''; ?>">
        <a class="nav-link" href="pesanan.php">
            <i class="fas fa-fw fa-shopping-cart"></i>
            <span>Pesanan</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">


    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
            aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>Manajemen Data</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="user.php">User</a>
                <a class="collapse-item" href="menu.php">Menu</a>
            </div>
        </div>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <li class="nav-item <?= (strpos($_SERVER['REQUEST_URI'], "/laporan.php") === 0)? 'btn-pancong active' : ''; ?>">
        <a class="nav-link" href="laporan.php">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Laporan</span></a>
    </li>
    <hr class="sidebar-divider my-0">
    <li class="nav-item <?= (strpos($_SERVER['REQUEST_URI'], "/riwayat.php") === 0)? 'btn-pancong active' : ''; ?>">
        <a class="nav-link" href="riwayat.php">
            <i class="fas fa-fw fa-history"></i>
            <span>Riwayat</span></a>
    </li>
    <hr class="sidebar-divider d-none d-md-block">
    
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->