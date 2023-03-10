<?php 
    require_once 'koneksi.php';
    if (!isset($_SESSION['id_user'])) {
        header("Location: login.php");
        exit;
    }

    $id_user = $_SESSION['id_user'];
    
    if (isset($_POST['btnUbahProfile'])) {
        $username = $_POST['username'];
        $nama_lengkap = $_POST['nama_lengkap'];
        $update_profile = mysqli_query($koneksi, "UPDATE user SET username = '$username', nama_lengkap = '$nama_lengkap' WHERE id_user = '$id_user'");
        if ($update_profile) {
            echo "
                <script>
                    alert('Profile berhasil diubah!')
                    window.location='profile.php'
                </script>
            ";
            exit;
        }
        else
        {
            echo "
                <script>
                    alert('Profile gagal diubah!')
                    window.location='profile.php'
                </script>
            ";
            exit;
        }
    }

    if (!$dataUser = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"))) {
        header("Location: logout.php");
        exit;
    }
 ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Profile - <?= $dataUser['nama_lengkap']; ?></title>
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
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Profile - <?= $dataUser['nama_lengkap']; ?></h1>
                    </div>

                    <div class="row">
                        <div class="col-lg-4 col-sm-12">
                            <form method="post">
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" value="<?= $dataUser['username']; ?>" name="username" required>
                                </div>
                                <div class="form-group">
                                    <label for="nama_lengkap">Nama Lengkap</label>
                                    <input type="text" class="form-control" name="nama_lengkap" value="<?= $dataUser['nama_lengkap']; ?>" required>
                                </div>
                                <div class="row">
                                    <div class="col text-left">
                                        <button type="submit" name="btnUbahProfile" class="btn btn-success">Ubah</button>
                                    </div>
                                    <div class="col text-right">
                                        <a class="btn btn-danger" href="ganti_password.php">Ganti Password</a>
                                    </div>
                                </div>
                            </form>
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


    <?php include 'script.php'; ?>

</body>

</html>