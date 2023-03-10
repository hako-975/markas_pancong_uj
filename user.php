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

    if (isset($_POST['btnTambahUser'])) {
        $username = htmlspecialchars($_POST['username']);
        $nama_lengkap = htmlspecialchars($_POST['nama_lengkap']);
        $password = $_POST['password'];
        $verifikasi_password = $_POST['verifikasi_password'];

        // cek username
        $check_username = mysqli_query($koneksi, "SELECT * FROM user WHERE username = '$username'");
        if (mysqli_num_rows($check_username)) {
            echo "
                <script>
                    alert('Username sudah digunakan!')
                    window.location='user.php'
                </script>
            ";
            exit;
        }

        // cek password
        if ($password != $verifikasi_password) {
            echo "
                <script>
                    alert('Password tidak sama dengan Verifikasi Password!')
                    window.location='user.php'
                </script>
            ";
            exit;
        }

        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $insert_user = mysqli_query($koneksi, "INSERT INTO user (username, nama_lengkap, password) VALUES ('$username', '$nama_lengkap', '$password_hash')");

        if ($insert_user) {
            echo "
                <script>
                    alert('User berhasil ditambahkan!')
                    window.location='user.php'
                </script>
            ";
            exit;
        }
        else
        {
            echo "
                <script>
                    alert('Gagal berhasil ditambahkan!')
                    window.location='user.php'
                </script>
            ";
            exit;
        }
    }

    if (isset($_POST['btnUbahUser'])) {
        $id_user_data = htmlspecialchars($_POST['id_user_data']);
        $username = htmlspecialchars($_POST['username']);
        $nama_lengkap = htmlspecialchars($_POST['nama_lengkap']);

        $update_user = mysqli_query($koneksi, "UPDATE user SET username = '$username', nama_lengkap = '$nama_lengkap' WHERE id_user = '$id_user_data'");

        if ($update_user) {
            echo "
                <script>
                    alert('User berhasil diubah!')
                    window.location='user.php'
                </script>
            ";
            exit;
        }
        else
        {
            echo "
                <script>
                    alert('Gagal berhasil diubah!')
                    window.location='user.php'
                </script>
            ";
            exit;
        }
        
    }

    $user = mysqli_query($koneksi, "SELECT * FROM user");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>User - Markas Pancong UJ</title>

    <?php include 'head.php'; ?>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include 'sidebar.php'; ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include 'topbar.php'; ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="align-items-center justify-content-between mb-4">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <div class="row">
                                    <div class="col head-left">
                                        <h6 class="mt-2 font-weight-bold text-primary">Data User</h6>
                                    </div>
                                    <div class="col head-right">
                                        <button type="button" class="btn btn-sm btn-primary"  data-toggle="modal" data-target="#tambahUserModal"><i class="fas fa-fw fa-plus"></i> Tambah User</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" cellspacing="0">
                                        <thead>
                                            <tr class="text-center">
                                                <th>No.</th>
                                                <th>Username</th>
                                                <th>Nama Lengkap</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            <?php foreach ($user as $du): ?>
                                                <tr>
                                                    <td class="align-middle"><?= $i++; ?></td>
                                                    <td class="align-middle"><?= $du['username']; ?></td>
                                                    <td class="align-middle"><?= $du['nama_lengkap']; ?></td>
                                                    <td class="text-center align-middle">
                                                        <?php if ($du['username'] != 'admin'): ?>
                                                            <a class="btn btn-sm btn-warning text-white m-1" data-toggle="modal" data-target="#ubahUserModal<?= $du['id_user']; ?>"><i class="fas fa-fw fa-edit"></i> Ubah</a>
                                                            <a class="btn btn-sm btn-danger text-white m-1" href="hapus_user.php?id_user=<?= $du['id_user']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus user dengan username <?= $du['username']; ?>?')"><i class="fas fa-fw fa-trash"></i> Hapus</a>
                                                            
                                                            <div class="modal fade" id="ubahUserModal<?= $du['id_user']; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="ubahUserModalLabel<?= $du['id_user']; ?>" aria-hidden="true">
                                                              <div class="modal-dialog text-left">
                                                                <form method="post" enctype="multipart/form-data">
                                                                    <input type="hidden" name="id_user_data" value="<?= $du['id_user']; ?>">
                                                                    <div class="modal-content">
                                                                      <div class="modal-header">
                                                                        <h5 class="modal-title" id="ubahUserModalLabel<?= $du['id_user']; ?>"><i class="fas fa-fw fa-edit"></i> Ubah User - <?= $du['username']; ?></h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                          <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                      </div>
                                                                      <div class="modal-body">
                                                                        <div class="form-group">
                                                                            <label for="username">Username<sup class="text-danger">*</sup></label>
                                                                            <input type="text" class="form-control" id="username" name="username" required value="<?= (isset($_POST['username']) ? ($_POST['username'] == '' ? $du['username'] : $_POST['username']) : $du['username']); ?>">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="nama_lengkap">Nama Lengkap<sup class="text-danger">*</sup></label>
                                                                            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required value="<?= (isset($_POST['nama_lengkap']) ? ($_POST['nama_lengkap'] == '' ? $du['nama_lengkap'] : $_POST['nama_lengkap']) : $du['nama_lengkap']); ?>">
                                                                        </div>
                                                                      </div>
                                                                      <div class="modal-footer">
                                                                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-fw fa-times"></i> Batal</button>
                                                                        <button type="submit" name="btnUbahUser" class="btn btn-primary"><i class="fas fa-fw fa-save"></i> Ubah</button>
                                                                      </div>
                                                                    </div>
                                                                </form>
                                                              </div>
                                                            </div>
                                                        <?php endif ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include 'footer.php'; ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Tambah User Modal -->
    <div class="modal fade" id="tambahUserModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="tambahUserModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form method="post" enctype="multipart/form-data">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="tambahUserModalLabel"><i class="fas fa-fw fa-plus"></i> Tambah User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="form-group">
                    <label for="username">Username<sup class="text-danger">*</sup></label>
                    <input type="text" class="form-control" id="username" name="username" required value="<?= (isset($_POST['username']) ? ($_POST['username'] == '' ? '' : $_POST['username']) : ""); ?>">
                </div>
                <div class="form-group">
                    <label for="nama_lengkap">Nama Lengkap<sup class="text-danger">*</sup></label>
                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required value="<?= (isset($_POST['nama_lengkap']) ? ($_POST['nama_lengkap'] == '' ? '' : $_POST['nama_lengkap']) : ""); ?>">
                </div>
                <div class="form-group">
                    <label for="password">Password<sup class="text-danger">*</sup></label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="verifikasi_password">Verifikasi Password<sup class="text-danger">*</sup></label>
                    <input type="password" class="form-control" id="verifikasi_password" name="verifikasi_password" required>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-fw fa-times"></i> Batal</button>
                <button type="submit" name="btnTambahUser" class="btn btn-primary"><i class="fas fa-fw fa-save"></i> Simpan</button>
              </div>
            </div>
        </form>
      </div>
    </div>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


    <?php include 'script.php'; ?>

</body>

</html>