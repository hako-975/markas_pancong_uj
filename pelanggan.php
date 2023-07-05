<?php 
    require_once 'koneksi.php';
    if (!isset($_SESSION['id_user'])) {
        header("Location: login.php");
        exit;
    }

    if ($_SESSION['role'] == 'administrator') {
        header("Location: dashboard.php");
        exit;
    }

    if (isset($_SESSION['menu_items'])) {
        header("Location: checkout.php");
        exit;
    }

    $id_user = $_SESSION['id_user'];
    $pesanan = mysqli_query($koneksi, "SELECT * FROM pesanan INNER JOIN user ON pesanan.id_user = user.id_user WHERE pesanan.id_user = '$id_user' ORDER BY tanggal_pesanan DESC");
    
    if (!$dataUser = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"))) {
        header("Location: logout.php");
        exit;
    }


 ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Pesanan Saya - Kantin Markas Pancong UJ</title>
    <?php include 'head.php' ?>
</head>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

<!-- Main Content -->
<div id="content">

<?php include 'topbar.php' ?>

<!-- Begin Page Content -->
<div class="container bg-white rounded p-3">

    <!-- Page Heading -->
    <div class="row">
        <div class="col head-left">
            <h5 class="my-2 font-weight-bold">Pesanan Saya</h5>
        </div>
        <div class="col head-right">
            <a href="pesan.php" class="btn btn-sm btn-primary"><i class="fas fa-fw fa-plus"></i> Buat Pesanan</a>
        </div>
    </div>
    <hr class="mt-0">
    <div class="row">
        <div class="col">
            <?php if (mysqli_num_rows($pesanan) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" cellspacing="0">
                        <thead>
                            <tr class="text-center">
                                <th>No.</th>
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
                                    <td class="align-middle"><?= date("d-m-Y, H:i", strtotime($dp['tanggal_pesanan'])); ?></td>
                                    <td class="align-middle">
                                        Rp. <?= str_replace(",", ".", number_format($dp['total_pembayaran'])); ?>
                                    </td>
                                    <td class="align-middle text-center">
                                        <?php if ($dp['status_pesanan'] == 'proses'): ?>
                                            <a class="btn btn-danger"><?= ucwords($dp['status_pesanan']); ?></a>
                                        <?php elseif ($dp['status_pesanan'] == 'dibuat'): ?>
                                            <a class="btn btn-warning"><?= ucwords($dp['status_pesanan']); ?></a>
                                        <?php elseif ($dp['status_pesanan'] == 'perjalanan'): ?>
                                            <a class="btn btn-success"><?= ucwords($dp['status_pesanan']); ?></a>
                                        <?php elseif ($dp['status_pesanan'] == 'selesai'): ?>
                                            <a class="btn btn-primary"><?= ucwords($dp['status_pesanan']); ?></a>
                                        <?php endif ?>
                                    </td>
                                    <td class="text-center align-middle">
                                        <a class="btn btn-sm btn-success" href="status_pesanan.php?kode_pesanan=<?= $dp['kode_pesanan']; ?>"><i class="fas fa-fw fa-bars"></i> Detail</a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <h3>Belum ada pesanan</h3>
            <?php endif ?>
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