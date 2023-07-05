<?php 
    require_once 'koneksi.php';
    if (!isset($_SESSION['id_user'])) {
        header("Location: login.php");
        exit;
    }

    if ($_SESSION['role'] != 'administrator') {
        header("Location: pelanggan.php");
        exit;
    }

    $id_user = $_SESSION['id_user'];
    
    if (!$dataUser = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"))) {
        header("Location: logout.php");
        exit;
    }

    $dari_awal_bulan = date('Y-m-01') . ' 00:00:00';
    $sampai_tanggal_ini = date('Y-m-d') . ' 23:59:59';

    $pesanan_semua = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pesanan INNER JOIN user ON pesanan.id_user = user.id_user WHERE tanggal_pesanan BETWEEN '$dari_awal_bulan' AND '$sampai_tanggal_ini'"));
    $pesanan_proses = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pesanan INNER JOIN user ON pesanan.id_user = user.id_user WHERE status_pesanan = 'proses' AND tanggal_pesanan BETWEEN '$dari_awal_bulan' AND '$sampai_tanggal_ini'"));
    $pesanan_dibuat = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pesanan INNER JOIN user ON pesanan.id_user = user.id_user WHERE status_pesanan = 'dibuat' AND tanggal_pesanan BETWEEN '$dari_awal_bulan' AND '$sampai_tanggal_ini'"));
    $pesanan_perjalanan = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pesanan INNER JOIN user ON pesanan.id_user = user.id_user WHERE status_pesanan = 'perjalanan' AND tanggal_pesanan BETWEEN '$dari_awal_bulan' AND '$sampai_tanggal_ini'"));
    $pesanan_selesai = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pesanan INNER JOIN user ON pesanan.id_user = user.id_user WHERE status_pesanan = 'selesai' AND tanggal_pesanan BETWEEN '$dari_awal_bulan' AND '$sampai_tanggal_ini'"));

    $pesanan = mysqli_query($koneksi, "SELECT * FROM pesanan INNER JOIN user ON pesanan.id_user = user.id_user WHERE tanggal_pesanan BETWEEN '$dari_awal_bulan' AND '$sampai_tanggal_ini' ORDER BY tanggal_pesanan DESC");

    $omset = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT *, sum(total_pembayaran) as omset FROM pesanan INNER JOIN user ON pesanan.id_user = user.id_user WHERE tanggal_pesanan BETWEEN '$dari_awal_bulan' AND '$sampai_tanggal_ini'"));

    $total_menu = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM menu"));

    $menu_paling_laku = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT *, detail_pesanan.id_menu, nama_menu, SUM(jumlah) as laku FROM detail_pesanan INNER JOIN menu ON detail_pesanan.id_menu = menu.id_menu INNER JOIN pesanan ON pesanan.kode_pesanan = detail_pesanan.kode_pesanan WHERE tanggal_pesanan BETWEEN '$dari_awal_bulan' AND '$sampai_tanggal_ini' GROUP BY detail_pesanan.id_menu ORDER BY laku DESC LIMIT 1"));

    if (isset($_GET['btnFilter'])) {
        $dari_tanggal = htmlspecialchars($_GET['dari_tanggal']);
        $sampai_tanggal = htmlspecialchars($_GET['sampai_tanggal']);

        $dari_tanggal_baru =  $dari_tanggal . ' 00:00:00';
        $sampai_tanggal_baru =  $sampai_tanggal . ' 23:59:59';
        $pesanan_semua = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pesanan INNER JOIN user ON pesanan.id_user = user.id_user WHERE tanggal_pesanan BETWEEN '$dari_tanggal_baru' AND '$sampai_tanggal_baru'"));
        $pesanan_proses = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pesanan INNER JOIN user ON pesanan.id_user = user.id_user WHERE status_pesanan = 'proses' AND tanggal_pesanan BETWEEN '$dari_tanggal_baru' AND '$sampai_tanggal_baru'"));
        $pesanan_dibuat = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pesanan INNER JOIN user ON pesanan.id_user = user.id_user WHERE status_pesanan = 'dibuat' AND tanggal_pesanan BETWEEN '$dari_tanggal_baru' AND '$sampai_tanggal_baru'"));
        $pesanan_perjalanan = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pesanan INNER JOIN user ON pesanan.id_user = user.id_user WHERE status_pesanan = 'perjalanan' AND tanggal_pesanan BETWEEN '$dari_tanggal_baru' AND '$sampai_tanggal_baru'"));
        $pesanan_selesai = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pesanan INNER JOIN user ON pesanan.id_user = user.id_user WHERE status_pesanan = 'selesai' AND tanggal_pesanan BETWEEN '$dari_tanggal_baru' AND '$sampai_tanggal_baru'"));

        $pesanan = mysqli_query($koneksi, "SELECT * FROM pesanan INNER JOIN user ON pesanan.id_user = user.id_user WHERE tanggal_pesanan BETWEEN '$dari_tanggal_baru' AND '$sampai_tanggal_baru' ORDER BY tanggal_pesanan DESC");

        $omset = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT *, sum(total_pembayaran) as omset FROM pesanan INNER JOIN user ON pesanan.id_user = user.id_user WHERE tanggal_pesanan BETWEEN '$dari_tanggal_baru' AND '$sampai_tanggal_baru'"));

        $total_menu = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM menu"));

        $menu_paling_laku = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT *, detail_pesanan.id_menu, nama_menu, SUM(jumlah) as laku FROM detail_pesanan INNER JOIN menu ON detail_pesanan.id_menu = menu.id_menu INNER JOIN pesanan ON pesanan.kode_pesanan = detail_pesanan.kode_pesanan WHERE tanggal_pesanan BETWEEN '$dari_tanggal_baru' AND '$sampai_tanggal_baru' GROUP BY detail_pesanan.id_menu ORDER BY laku DESC LIMIT 1"));
    }

 ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dashboard - Kantin Markas Pancong UJ</title>
    <?php include 'head.php' ?>
</head>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

<?php include 'sidebar.php'; ?>

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

<!-- Main Content -->
<div id="content">

<?php include 'topbar.php' ?>

<!-- Begin Page Content -->
<div class="container-fluid bg-white rounded p-3">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>
    <form method="GET">
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="dari_tanggal">Dari Tanggal</label>
                    <input class="form-control" type="date" name="dari_tanggal" value="<?= isset($_GET['btnFilter']) ? $dari_tanggal : date('Y-m-01'); ?>">
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="sampai_tanggal">Sampai Tanggal</label>
                    <input class="form-control" type="date" name="sampai_tanggal" value="<?= isset($_GET['btnFilter']) ? $sampai_tanggal : date('Y-m-d'); ?>">
                </div>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" name="btnFilter" class="btn btn-primary"><i class="fas fa-fw fa-filter"></i> Filter</button>
            <a href="dashboard.php" class="btn btn-primary"><i class="fas fa-fw fa-redo"></i> Reset</a>
        </div>
    </form>
    <hr>
    <div class="row">
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Omset (<?= (isset($_GET['btnFilter'])) ? "Filter" : "Bulan Ini"; ?>)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. <?= str_replace(",", ".", number_format($omset['omset'])); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Menu Paling Laku (<?= (isset($_GET['btnFilter'])) ? "Filter" : "Bulan Ini"; ?>)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php if ($menu_paling_laku): ?>
                                <?= $menu_paling_laku['nama_menu']; ?> - <?= $menu_paling_laku['laku']; ?>
                                <?php else: ?>
                                    Tidak ada
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Pesanan (<?= (isset($_GET['btnFilter'])) ? "Filter" : "Bulan Ini"; ?>)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $pesanan_semua; ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    <hr class="mt-0">
    <div class="row">
        <div class="col">
            <h4>Total Pesanan Berdasarkan Status (<?= (isset($_GET['btnFilter'])) ? "Filter" : "Bulan Ini"; ?>):</h4>
            <!-- Content Row -->
            <div class="row">

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <a href="pesanan.php?status_pesanan=proses" class="text-decoration-none">
                        <div class="card border-left-danger shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Belum Di Proses (<?= (isset($_GET['btnFilter'])) ? "Filter" : "Bulan Ini"; ?>)</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $pesanan_proses; ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <a href="pesanan.php?status_pesanan=dibuat" class="text-decoration-none">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Dibuat (<?= (isset($_GET['btnFilter'])) ? "Filter" : "Bulan Ini"; ?>)</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $pesanan_dibuat; ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <a href="pesanan.php?status_pesanan=perjalanan" class="text-decoration-none">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Dalam Perjalan (<?= (isset($_GET['btnFilter'])) ? "Filter" : "Bulan Ini"; ?>)</div>
                                        <div class="row no-gutters align-items-center">
                                            <div class="col-auto">
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $pesanan_perjalanan; ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Pending Requests Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <a href="pesanan.php?status_pesanan=selesai" class="text-decoration-none">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Selesai (<?= (isset($_GET['btnFilter'])) ? "Filter" : "Bulan Ini"; ?>)</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $pesanan_selesai; ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <hr class="mt-0">
    <div class="row">
        <div class="col">
            <h4>Pesanan Terbaru (<?= (isset($_GET['btnFilter'])) ? "Filter" : "Bulan Ini"; ?>):</h4>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th>No.</th>
                            <th>Nama Pemesan</th>
                            <th>No. WhatsApp Pemesan</th>
                            <th>Alamat Pemesan</th>
                            <th style="min-width: 8rem;">Tanggal Pesanan</th>
                            <th>Total Pembayaran</th>
                            <th>Status Pesanan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($pesanan as $dp): ?>
                            <tr>
                                <td class="align-middle"><?= $i++; ?></td>
                                <td class="align-middle"><?= $dp['nama_lengkap']; ?></td>
                                <?php 
                                    $toNumber62 = $dp['no_telepon'];
                                    if (substr($toNumber62, 0, 2) != "62") {
                                        $toNumber62 = substr_replace($toNumber62, "62", 0, 1);
                                    }
                                 ?>
                                <td class="align-middle"><a target="_blank" class="btn btn-sm btn-success" href="https://wa.me/<?= $toNumber62; ?>"><i class="fab fa-fw fa-whatsapp"></i> +<?= $toNumber62; ?></a></td>
                                <td class="align-middle"><?= $dp['alamat']; ?></td>
                                <td class="align-middle"><?= date("d-m-Y, H:i", strtotime($dp['tanggal_pesanan'])); ?></td>
                                <td class="align-middle">
                                    Rp. <?= str_replace(",", ".", number_format($dp['total_pembayaran'])); ?>
                                </td>
                                <td class="align-middle text-center">
                                    <?php if ($dp['status_pesanan'] == 'proses'): ?>
                                        <a data-status="Ubah" data-nama="Apakah Anda yakin ingin mengubah status menjadi dibuat?" href="ubah_status.php?kode_pesanan=<?= $dp['kode_pesanan']; ?>&status=dibuat" class="btn-alert btn btn-danger"><?= ucwords($dp['status_pesanan']); ?></a>
                                    <?php elseif ($dp['status_pesanan'] == 'dibuat'): ?>
                                        <a data-status="Ubah" data-nama="Apakah Anda yakin ingin mengubah status menjadi perjalanan?" href="ubah_status.php?kode_pesanan=<?= $dp['kode_pesanan']; ?>&status=perjalanan" class="btn-alert btn btn-warning"><?= ucwords($dp['status_pesanan']); ?></a>
                                    <?php elseif ($dp['status_pesanan'] == 'perjalanan'): ?>
                                        <a data-status="Ubah" data-nama="Apakah Anda yakin ingin mengubah status menjadi selesai?" href="ubah_status.php?kode_pesanan=<?= $dp['kode_pesanan']; ?>&status=selesai" class="btn-alert btn btn-success"><?= ucwords($dp['status_pesanan']); ?></a>
                                    <?php elseif ($dp['status_pesanan'] == 'selesai'): ?>
                                        <a class="btn btn-primary"><?= ucwords($dp['status_pesanan']); ?></a>
                                    <?php endif ?>
                                </td>
                                <td class="text-center align-middle">
                                    <a class="btn btn-sm btn-success" href="detail_pesanan.php?kode_pesanan=<?= $dp['kode_pesanan']; ?>"><i class="fas fa-fw fa-bars"></i> Detail</a>
                                    <a class="btn btn-sm btn-warning text-white m-1" data-toggle="modal" data-target="#ubahPesananModal<?= $dp['kode_pesanan']; ?>"><i class="fas fa-fw fa-edit"></i> Ubah</a>
                                    <a class="btn btn-sm btn-danger text-white m-1 btn-alert" data-status="Hapus" data-nama="Pesanan dengan nama <?= $dp['nama_lengkap']; ?> akan terhapus!" href="hapus_pesanan.php?kode_pesanan=<?= $dp['kode_pesanan']; ?>"><i class="fas fa-fw fa-trash"></i> Hapus</a>
                                    
                                    <div class="modal fade" id="ubahPesananModal<?= $dp['kode_pesanan']; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="ubahPesananModalLabel<?= $dp['kode_pesanan']; ?>" aria-hidden="true">
                                      <div class="modal-dialog text-left">
                                        <form method="post" enctype="multipart/form-data">
                                            <input type="hidden" name="kode_pesanan" value="<?= $dp['kode_pesanan']; ?>">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <h5 class="modal-title" id="ubahPesananModalLabel<?= $dp['kode_pesanan']; ?>"><i class="fas fa-fw fa-edit"></i> Ubah Pesanan - <?= $dp['nama_lengkap']; ?></h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                                </button>
                                              </div>
                                              <div class="modal-body">
                                                <div class="row">
                                                  <div class="col">
                                                    <div class="form-group">
                                                      <label for="nama_lengkap">Nama Pemesan<sup class="text-danger">*</sup></label>
                                                      <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required value="<?= (isset($_POST['nama_lengkap']) ? ($_POST['nama_lengkap'] == '' ? $dp['nama_lengkap'] : $_POST['nama_lengkap']) : $dp['nama_lengkap']); ?>">
                                                    </div>
                                                  </div>
                                                  <div class="col">
                                                    <div class="form-group">
                                                      <label for="no_telepon">No. Telp Pemesan<sup class="text-danger">*</sup></label>
                                                      <input type="text" class="form-control" id="no_telepon" name="no_telepon" required value="<?= (isset($_POST['no_telepon']) ? ($_POST['no_telepon'] == '' ? $dp['no_telepon'] : $_POST['no_telepon']) : $dp['no_telepon']); ?>">
                                                    </div>
                                                  </div>
                                                </div>
                                                <div class="form-group">
                                                  <label for="alamat">Alamat Pemesan<sup class="text-danger">*</sup></label>
                                                  <textarea class="form-control" id="alamat" name="alamat" required><?= (isset($_POST['alamat']) ? ($_POST['alamat'] == '' ? $dp['alamat'] : $_POST['alamat']) : $dp['alamat']); ?></textarea>
                                                </div>
                                              </div>
                                              <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-fw fa-times"></i> Batal</button>
                                                <button type="submit" name="btnUbahPesanan" class="btn btn-primary"><i class="fas fa-fw fa-save"></i> Ubah</button>
                                              </div>
                                            </div>
                                        </form>
                                      </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Footer -->
<?php include 'footer.php' ?>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>


<?php include 'script.php' ?>

</body>

</html>