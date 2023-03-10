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

    if (isset($_POST['btnUbahPassword'])) {
        $password_lama = $_POST['password_lama'];
        $password_baru = $_POST['password_baru'];
        $verifikasi_password_baru = $_POST['verifikasi_password_baru'];
        // cek password
        if (password_verify($password_lama, $dataUser['password'])) {
            if ($password_baru == $verifikasi_password_baru) {
                $password_baru_hash = password_hash($password_baru, PASSWORD_DEFAULT);
                $update_password = mysqli_query($koneksi, "UPDATE user SET password = '$password_baru_hash' WHERE id_user = '$id_user'");
                if ($update_password) {
                    echo "
                        <script>
                            alert('Password berhasil diganti!')
                            window.location='ganti_password.php'
                        </script>
                    ";
                    exit;
                }
                else
                {
                    echo "
                        <script>
                            alert('Password gagal diganti!')
                            window.location='ganti_password.php'
                        </script>
                    ";
                    exit;
                }
            } 
            else 
            {
                echo "
                    <script>
                        alert('Password baru tidak sama dengan verifikasi Password!')
                        window.location='ganti_password.php'
                    </script>
                ";
                exit;
            }
        } 
        else
        {
            echo "
                <script>
                    alert('Password lama salah!')
                    window.location='ganti_password.php'
                </script>
            ";
            exit;
        }
        
    }

    
 ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Ganti Password - <?= $dataUser['nama_lengkap']; ?></title>
    <?php include 'head.php'; ?>
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
                    <div class="row my-2">
                        <div class="col">
                            <a href="profile.php" class="btn btn-primary"><i class="fas fa-fw fa-arrow-left"></i> Profile</a>
                        </div>
                    </div>

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Ganti Password - <?= $dataUser['nama_lengkap']; ?></h1>
                    </div>

                    <div class="row">
                        <div class="col-lg-4 col-sm-12">
                            <form method="post">
                                <div class="form-group">
                                    <label for="password_lama">Password Lama</label>
                                    <input type="password" class="form-control" name="password_lama" required>
                                </div>
                                <div class="form-group">
                                    <label for="password_baru">Password Baru</label>
                                    <input type="password" class="form-control" name="password_baru" required>
                                </div>
                                <div class="form-group">
                                    <label for="verifikasi_password_baru">Verifikasi Password Baru</label>
                                    <input type="password" class="form-control" name="verifikasi_password_baru" required>
                                </div>
                                <div class="row">
                                    <div class="col text-left">
                                        <button type="submit" name="btnUbahPassword" class="btn btn-success">Ganti Password</button>
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


    <?php include 'script.php' ?>

</body>

</html>