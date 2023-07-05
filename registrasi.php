<?php 
    require_once 'koneksi.php';

    if (isset($_POST['btnRegistrasi'])) {
        $username = htmlspecialchars($_POST['username']);
        $nama_lengkap = htmlspecialchars($_POST['nama_lengkap']);
        $no_telepon = htmlspecialchars($_POST['no_telepon']);
        if (substr($no_telepon, 0, 2) == "08") { // check if it starts with "08"
            $no_telepon = "62" . substr($no_telepon, 1);
        }
        $alamat = htmlspecialchars($_POST['alamat']);
        $password = $_POST['password'];
        $verifikasi_password = $_POST['verifikasi_password'];

        // cek username
        $check_username = mysqli_query($koneksi, "SELECT * FROM user WHERE username = '$username'");
        if (mysqli_num_rows($check_username) > 0) {
            setAlert("Perhatian!", "Username sudah digunakan!", "error");
            echo "
                <script>
                    window.history.back();
                </script>
            ";
            exit;
        }

        // cek password
        if ($password != $verifikasi_password) {
            setAlert("Perhatian!", "Password tidak sama dengan Verifikasi Password!", "error");
            echo "
                <script>
                    window.history.back();
                </script>
            ";
            exit;
        }

        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $insert_user = mysqli_query($koneksi, "INSERT INTO user (username, nama_lengkap, no_telepon, alamat, password, role) VALUES ('$username', '$nama_lengkap', '$no_telepon', '$alamat', '$password_hash', 'pelanggan')");
        $id_user = mysqli_insert_id($koneksi);

        if ($insert_user) {
            $tgl_riwayat = date('Y-m-d H:i:s');
            mysqli_query($koneksi, "INSERT INTO riwayat VALUES ('', 'User berhasil ditambahkan!', '$tgl_riwayat', '$id_user')");
            
            setAlert("Berhasil!", "Registrasi akun Markas Pancong UJ Berhasil!", "success");
            header("location: login.php");
            exit;
        }
        else
        {
            setAlert("Perhatian!", "Registrasi akun Markas Pancong UJ Gagal!", "error");
            echo "
                <script>
                    window.history.back();
                </script>
            ";
            exit;
        }
    }

    if (isset($_SESSION['id_user'])) {
        header("Location: dashboard.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login - Kantin Markas Pancong UJ</title>
    <?php include 'head.php' ?>
</head>

<body style="background-color: #F8B211;">
    <?php include_once 'navbar.php'; ?>

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-lg-6">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col">
                                <img src="img/logo_background.png" alt="logo" style="display: block; width: 150px; margin: auto; margin-top: 20px; border-radius: 50%;">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Registrasi Markas Pancong UJ</h1>
                                    </div>
                                    <form method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="username">Username<sup class="text-danger">*</sup></label>
                                            <input type="text" class="form-control" id="username" name="username" required value="<?= (isset($_POST['username']) ? ($_POST['username'] == '' ? '' : $_POST['username']) : ""); ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="nama_lengkap">Nama Lengkap<sup class="text-danger">*</sup></label>
                                            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required value="<?= (isset($_POST['nama_lengkap']) ? ($_POST['nama_lengkap'] == '' ? '' : $_POST['nama_lengkap']) : ""); ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="no_telepon">No. Telepon<sup class="text-danger">*</sup></label>
                                            <input type="text" class="form-control" id="no_telepon" name="no_telepon" required value="<?= (isset($_POST['no_telepon']) ? ($_POST['no_telepon'] == '' ? '' : $_POST['no_telepon']) : ""); ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="alamat">Alamat<sup class="text-danger">*</sup></label>
                                            <textarea class="form-control" id="alamat" name="alamat" required><?= (isset($_POST['alamat']) ? ($_POST['alamat'] == '' ? '' : $_POST['alamat']) : ""); ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="password">Password<sup class="text-danger">*</sup></label>
                                            <input type="password" class="form-control" id="password" name="password" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="verifikasi_password">Verifikasi Password<sup class="text-danger">*</sup></label>
                                            <input type="password" class="form-control" id="verifikasi_password" name="verifikasi_password" required>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" name="btnRegistrasi" class="btn btn-warning btn-pancong font-weight-bold btn-user btn-block">Registrasi</button>
                                        </div>
                                    </form>
                                    <hr>
                                    <a href="login.php" class="text-pancong text-center mx-auto d-block">Login</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <?php include 'script.php'; ?>

</body>

</html>