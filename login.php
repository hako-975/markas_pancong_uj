<?php 
    require_once 'koneksi.php';

    if (isset($_POST['btnLogin'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $data = mysqli_query($koneksi, "SELECT * FROM user WHERE username = '$username'");
        if ($dataUser = mysqli_fetch_assoc($data)) {
            if (password_verify($password, $dataUser['password'])) {
                $id_user = $dataUser['id_user'];
                $tgl_riwayat = date('Y-m-d H:i:s');
                mysqli_query($koneksi, "INSERT INTO riwayat VALUES ('', 'User Berhasil login!', '$tgl_riwayat', '$id_user')");
                $_SESSION['id_user'] = $id_user;
                $_SESSION['username'] = $dataUser['username'];
                header("Location:dashboard.php");
                exit;
            }
            else
            {
                setAlert("Perhatian!", "sername atau password yang anda masukkan salah!", "error");
                header("Location: login.php");
                exit;
            }
        }
        else
        {
            setAlert("Perhatian!", "sername atau password yang anda masukkan salah!", "error");
            header("Location: login.php");
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

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6">
                                <img src="img/logo_background.png" alt="logo" class="img-fluid">
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Login Markas Pancong UJ</h1>
                                    </div>
                                    <form method="post" class="user">
                                        <div class="form-group">
                                            <label for="username">Username</label>
                                            <input type="text" class="form-control form-control-user"
                                                id="username" name="username">
                                        </div>
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="password" class="form-control form-control-user"
                                                id="password" name="password">
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" name="btnLogin" class="btn btn-warning btn-pancong font-weight-bold btn-user btn-block">Login</button>
                                        </div>
                                    </form>
                                    <a href="index.php" class="text-pancong">Bukan Admin?</a>
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