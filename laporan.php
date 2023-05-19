<?php 
    require_once 'koneksi.php';
    if (!isset($_SESSION['id_user'])) {
        header("Location: login.php");
        exit;
    }

    $id_user = $_SESSION['id_user'];
    
    if (!$dataUser = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"))) {
        header("Location: logout.php");
        exit;
    }

    if (isset($_GET['btnLaporan'])) {
        $dari_tanggal = htmlspecialchars($_GET['dari_tanggal']);
        $sampai_tanggal = htmlspecialchars($_GET['sampai_tanggal']);
        $status_pesanan = htmlspecialchars($_GET['status_pesanan']);

        $dari_tanggal_baru =  $dari_tanggal . ' 00:00:00';
        $sampai_tanggal_baru =  $sampai_tanggal . ' 23:59:59';
        if ($status_pesanan == 'semua') {
            $pesanan = mysqli_query($koneksi, "SELECT * FROM pesanan LEFT JOIN user ON pesanan.id_user = user.id_user WHERE pesanan.tanggal_pesanan BETWEEN '$dari_tanggal_baru' AND '$sampai_tanggal_baru' ORDER BY pesanan.tanggal_pesanan ASC");
        }
        else
        {
            $pesanan = mysqli_query($koneksi, "SELECT * FROM pesanan LEFT JOIN user ON pesanan.id_user = user.id_user WHERE status_pesanan = '$status_pesanan' AND tanggal_pesanan BETWEEN '$dari_tanggal_baru' AND '$sampai_tanggal_baru' ORDER BY tanggal_pesanan ASC");
        }
    }
 ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Laporan - Kantin Markas Pancong UJ</title>
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
                        <h1 class="h3 mb-0 text-gray-800">Laporan</h1>
                    </div>
                    <hr class="mt-0">
                    <div class="row">
                        <div class="col-lg-4">
                            <form method="get">
                                <div class="form-group">
                                    <label for="dari_tanggal">Dari Tanggal</label>
                                    <input class="form-control" type="date" name="dari_tanggal" value="<?= isset($_GET['btnLaporan']) ? $dari_tanggal : date('Y-m-01'); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="sampai_tanggal">Sampai Tanggal</label>
                                    <input class="form-control" type="date" name="sampai_tanggal" value="<?= isset($_GET['btnLaporan']) ? $sampai_tanggal : date('Y-m-d'); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="status_pesanan">Status Pesanan</label>
                                    <select name="status_pesanan" id="status_pesanan" class="custom-select">
                                        <?php if (isset($_GET['btnLaporan'])): ?>
                                            <option value="<?= $status_pesanan; ?>"><?= ucwords($status_pesanan); ?></option>
                                        <?php endif ?>
                                        <option value="selesai">Selesai</option>
                                        <option value="semua">Semua</option>
                                        <option value="proses">Proses</option>
                                        <option value="dibuat">Dibuat</option>
                                        <option value="perjalanan">Perjalanan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="btnLaporan" class="btn btn-primary"><i class="fas fa-fw fa-filter"></i> Filter</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php if (isset($_GET['btnLaporan'])): ?>
                        <hr class="mt-0">
                        <a target="_blank" href="print_laporan.php?dari_tanggal=<?= $dari_tanggal; ?>&sampai_tanggal=<?= $sampai_tanggal; ?>&status_pesanan=<?= $status_pesanan; ?>" class="btn btn-success my-3"><i class="fas fa-fw fa-print"></i> Print</a>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Pemesan</th>
                                        <th>No. Telp Pemesan</th>
                                        <th>Alamat Pemesan</th>
                                        <th>Tanggal Pesanan</th>
                                        <th>Total Pembayaran</th>
                                        <th>Status Pesanan</th>
                                        <th>Detail Pesanan</th>
                                        <th>Operator</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($pesanan as $dp): ?>
                                        <?php 
                                            $kode_pesanan = $dp['kode_pesanan'];
                                            $detail_pesanan = mysqli_query($koneksi, "SELECT * FROM detail_pesanan INNER JOIN menu ON detail_pesanan.id_menu = menu.id_menu WHERE kode_pesanan = '$kode_pesanan'");
                                         ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $dp['nama_pemesan']; ?></td>
                                            <td><?= $dp['no_telp_pemesan']; ?></td>
                                            <td><?= $dp['alamat_pemesan']; ?></td>
                                            <td><?= $dp['tanggal_pesanan']; ?></td>
                                            <td>Rp. <?= str_replace(",", ".", number_format($dp['total_pembayaran'])); ?></td>
                                            <td><?= $dp['status_pesanan']; ?></td>
                                            <td>
                                                <ul>
                                                    <?php foreach ($detail_pesanan as $ddp): ?>
                                                        <li>
                                                            <?= $ddp['nama_menu']; ?> - <?= $ddp['jumlah']; ?>
                                                        </li>
                                                    <?php endforeach ?>
                                                </ul>
                                            </td>
                                            <td><?= $dp['nama_lengkap']; ?></td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif ?>
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