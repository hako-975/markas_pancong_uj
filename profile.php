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
        $no_telepon = $_POST['no_telepon'];
        $alamat = $_POST['alamat'];
        $update_profile = mysqli_query($koneksi, "UPDATE user SET username = '$username', nama_lengkap = '$nama_lengkap', no_telepon = '$no_telepon', alamat = '$alamat' WHERE id_user = '$id_user'");
        if ($update_profile) {
            $tgl_riwayat = date('Y-m-d H:i:s');
            mysqli_query($koneksi, "INSERT INTO riwayat VALUES ('', 'Profile berhasil diubah!', '$tgl_riwayat', '$id_user')");

            setAlert("Berhasil!", "Profile berhasil diubah!", "success");

            header("Location: profile.php");
            exit;
        }
        else
        {
            setAlert("Perhatian!", "Profile gagal diubah!", "error");
            echo "
                <script>
                    window.history.back();
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
        <?php if ($dataUser['role'] == 'administrator'): ?>
            <?php include 'sidebar.php'; ?>
        <?php endif ?>

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
                                <div class="form-group">
                                    <label for="no_telepon">No. Telepon</label>
                                    <input type="text" class="form-control" name="no_telepon" value="<?= $dataUser['no_telepon']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <textarea class="form-control" name="alamat" required><?= $dataUser['alamat']; ?></textarea>
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