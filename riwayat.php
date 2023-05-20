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

    $riwayat = mysqli_query($koneksi, "SELECT * FROM riwayat INNER JOIN user ON riwayat.id_user = user.id_user ORDER BY tanggal_riwayat DESC");
    
 ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Riwayat - Kantin Markas Pancong UJ</title>
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
                        <h1 class="h3 mb-0 text-gray-800">Riwayat</h1>
                    </div>
                    <hr class="mt-0">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Isi Riwayat</th>
                                    <th>Tanggal Riwayat</th>
                                    <th>Username</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($riwayat as $dr): ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $dr['isi_riwayat']; ?></td>
                                        <td><?= date("d-m-Y, H:i", strtotime($dr['tanggal_riwayat'])); ?></td>
                                        <td><?= $dr['username']; ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
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