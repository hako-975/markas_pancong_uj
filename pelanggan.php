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
    $pesanan = mysqli_query($koneksi, "SELECT * FROM pesanan WHERE id_user = '$id_user' ORDER BY tanggal_pesanan DESC");
    
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
                                                <th>Nama Pemesan</th>
                                                <th>No. WhatsApp Pemesan</th>
                                                <th>Alamat Pemesan</th>
                                                <th style="min-width: 11rem;">Tanggal Pesanan</th>
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
                                                    <td class="align-middle"><?= $dp['nama_pemesan']; ?></td>
                                                    <?php 
                                                        $toNumber62 = $dp['no_telp_pemesan'];
                                                        if (substr($toNumber62, 0, 2) != "62") {
                                                            $toNumber62 = substr_replace($toNumber62, "62", 0, 1);
                                                        }
                                                     ?>
                                                    <td class="align-middle"><a target="_blank" class="btn btn-sm btn-success" href="https://wa.me/<?= $toNumber62; ?>"><i class="fab fa-fw fa-whatsapp"></i> +<?= $toNumber62; ?></a></td>
                                                    <td class="align-middle"><?= $dp['alamat_pemesan']; ?></td>
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
                                                        <a class="btn btn-sm btn-danger text-white m-1 btn-alert" data-status="Hapus" data-nama="Pesanan dengan nama <?= $dp['nama_pemesan']; ?> akan terhapus!" href="hapus_pesanan.php?kode_pesanan=<?= $dp['kode_pesanan']; ?>"><i class="fas fa-fw fa-trash"></i> Hapus</a>
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