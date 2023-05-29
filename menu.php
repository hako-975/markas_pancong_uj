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

    if (isset($_POST['btnTambahMenu'])) {
        $nama_menu = htmlspecialchars($_POST['nama_menu']);
        $harga_menu = htmlspecialchars($_POST['harga_menu']);
        $jenis_menu = htmlspecialchars($_POST['jenis_menu']);

        $foto_menu = $_FILES['foto_menu']['name'];
        if ($foto_menu != '') {
            $acc_extension = array('png','jpg', 'jpeg', 'gif');
            $extension = explode('.', $foto_menu);
            $extension_lower = strtolower(end($extension));
            $size = $_FILES['foto_menu']['size'];
            $file_tmp = $_FILES['foto_menu']['tmp_name'];   
            
            if(!in_array($extension_lower, $acc_extension))
            {
                setAlert("Perhatian!", "File yang di upload bukan gambar!", "error");
                echo "
                    <script>
                        window.history.back();
                    </script>
                ";
                exit;
            }

            $foto_menu = uniqid() . $foto_menu;
            move_uploaded_file($file_tmp, 'img/menu/'. $foto_menu);
        }

        $insert_menu = mysqli_query($koneksi, "INSERT INTO menu (nama_menu, harga_menu, jenis_menu, foto_menu) VALUES ('$nama_menu', '$harga_menu', '$jenis_menu', '$foto_menu')");

        if ($insert_menu) {
            $tgl_riwayat = date('Y-m-d H:i:s');
            mysqli_query($koneksi, "INSERT INTO riwayat VALUES ('', 'Menu $nama_menu Berhasil ditambahkan!', '$tgl_riwayat', '$id_user')");
            
            setAlert("Berhasil!", "Menu ".$nama_menu." Berhasil ditambahkan!", "success");
            header("Location: menu.php");
            exit;
        }
        else
        {
            setAlert("Perhatian!", "Menu ".$nama_menu." Gagal ditambahkan!", "error");
            echo "
                <script>
                    window.history.back();
                </script>
            ";
            exit;
        }
    }

    if (isset($_POST['btnUbahMenu'])) {
        $id_menu = htmlspecialchars($_POST['id_menu']);
        $nama_menu = htmlspecialchars($_POST['nama_menu']);
        $harga_menu = htmlspecialchars($_POST['harga_menu']);
        $jenis_menu = htmlspecialchars($_POST['jenis_menu']);

        $foto_menu = $_POST['foto_menu_old'];
        
        $foto_menu_new = $_FILES['foto_menu']['name'];
        if ($foto_menu_new != '') {
            $acc_extension = array('png','jpg', 'jpeg', 'gif');
            $extension = explode('.', $foto_menu_new);
            $extension_lower = strtolower(end($extension));
            $size = $_FILES['foto_menu']['size'];
            $file_tmp = $_FILES['foto_menu']['tmp_name'];     
            if(!in_array($extension_lower, $acc_extension))
            {
                setAlert("Perhatian!", "File yang di upload bukan gambar!", "error");
                echo "
                    <script>
                        window.history.back();
                    </script>
                ";
                exit;
            }

            $image_path = 'img/menu/' . $foto_menu;
            
            if (file_exists($image_path)) {
                unlink($image_path);
            }

            $foto_menu = uniqid() . $foto_menu_new;
            move_uploaded_file($file_tmp, 'img/menu/' . $foto_menu);
        }


        $update_menu = mysqli_query($koneksi, "UPDATE menu SET nama_menu = '$nama_menu', harga_menu = '$harga_menu', jenis_menu = '$jenis_menu', foto_menu = '$foto_menu' WHERE id_menu = '$id_menu'");

        if ($update_menu) {
            $tgl_riwayat = date('Y-m-d H:i:s');
            mysqli_query($koneksi, "INSERT INTO riwayat VALUES ('', 'Menu $nama_menu Berhasil diubah!', '$tgl_riwayat', '$id_user')");
            setAlert("Berhasil!", "Menu ".$nama_menu." Berhasil diubah!", "success");
            header("Location: menu.php");
            exit;
        }
        else
        {
            setAlert("Perhatian!", "Menu Gagal diubah!", "error");
            echo "
                <script>
                    window.history.back();
                </script>
            ";
            exit;
        }
        
    }

    $menu = mysqli_query($koneksi, "SELECT * FROM menu ORDER BY nama_menu ASC");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Menu - Markas Pancong UJ</title>

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
                                        <h6 class="mt-2 font-weight-bold text-primary">Data Menu</h6>
                                    </div>
                                    <div class="col head-right">
                                        <button type="button" class="btn btn-sm btn-primary"  data-toggle="modal" data-target="#tambahMenuModal"><i class="fas fa-fw fa-plus"></i> Tambah Menu</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" cellspacing="0">
                                        <thead>
                                            <tr class="text-center">
                                                <th>No.</th>
                                                <th>Nama Menu</th>
                                                <th>Harga Menu</th>
                                                <th>Jenis Menu</th>
                                                <th>Foto Menu</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            <?php foreach ($menu as $dm): ?>
                                                <tr>
                                                    <td class="align-middle"><?= $i++; ?></td>
                                                    <td class="align-middle"><?= $dm['nama_menu']; ?></td>
                                                    <td class="align-middle">Rp. <?= str_replace(",", ".", number_format($dm['harga_menu'])); ?></td>
                                                    <td class="align-middle"><?= ucwords($dm['jenis_menu']); ?></td>
                                                    <td class="align-middle text-center">
                                                        <a href="img/menu/<?= $dm['foto_menu']; ?>" target="_blank">
                                                            <img width="200" src="img/menu/<?= $dm['foto_menu']; ?>" alt="<?= $dm['foto_menu']; ?>">
                                                        </a>
                                                    </td>
                                                    <td class="text-center align-middle">
                                                        <a class="btn btn-sm btn-warning text-white m-1" data-toggle="modal" data-target="#ubahMenuModal<?= $dm['id_menu']; ?>"><i class="fas fa-fw fa-edit"></i> Ubah</a>
                                                        <a class="btn btn btn-sm btn-danger text-white m-1 btn-alert" data-status="Hapus" data-nama="Menu <?= $dm['nama_menu']; ?> akan terhapus!" href="hapus_menu.php?id_menu=<?= $dm['id_menu']; ?>"><i class="fas fa-fw fa-trash"></i> Hapus</a>
                                                        
                                                        <div class="modal fade" id="ubahMenuModal<?= $dm['id_menu']; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="ubahMenuModalLabel<?= $dm['id_menu']; ?>" aria-hidden="true">
                                                          <div class="modal-dialog text-left">
                                                            <form method="post" enctype="multipart/form-data">
                                                                <input type="hidden" name="id_menu" value="<?= $dm['id_menu']; ?>">
                                                                <input type="hidden" name="foto_menu_old" value="<?= $dm['foto_menu']; ?>">
                                                                <div class="modal-content">
                                                                  <div class="modal-header">
                                                                    <h5 class="modal-title" id="ubahMenuModalLabel<?= $dm['id_menu']; ?>"><i class="fas fa-fw fa-edit"></i> Ubah Menu - <?= $dm['nama_menu']; ?></h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                      <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                  </div>
                                                                  <div class="modal-body">
                                                                    <div class="form-group">
                                                                        <label for="nama_menu">Nama Menu<sup class="text-danger">*</sup></label>
                                                                        <input type="text" class="form-control" id="nama_menu" name="nama_menu" required value="<?= (isset($_POST['nama_menu']) ? ($_POST['nama_menu'] == '' ? $dm['nama_menu'] : $_POST['nama_menu']) : $dm['nama_menu']); ?>">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="harga_menu">Harga Menu<sup class="text-danger">*</sup></label>
                                                                        <input type="number" class="form-control" id="harga_menu" name="harga_menu" required value="<?= (isset($_POST['harga_menu']) ? ($_POST['harga_menu'] == '' ? $dm['harga_menu'] : $_POST['harga_menu']) : $dm['harga_menu']); ?>">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="jenis_menu">Jenis Menu<sup class="text-danger">*</sup></label>
                                                                        <select name="jenis_menu" id="jenis_menu" class="custom-select">
                                                                            <option value="<?= $dm['jenis_menu']; ?>"><?= ucwords($dm['jenis_menu']); ?></option>
                                                                            <option value="makanan"><?= ucwords('makanan'); ?></option>
                                                                            <option value="minuman"><?= ucwords('minuman'); ?></option>
                                                                        </select>
                                                                    </div>
                                                                    
                                                                    <label for="foto_menu">Foto Menu (Optional)</label>
                                                                    <div class="input-group mb-3">
                                                                      <div class="custom-file">
                                                                        <input type="file" class="custom-file-input" id="foto_menu" aria-describedby="foto_menu" name="foto_menu">
                                                                        <label class="custom-file-label" for="foto_menu"><?= $dm['foto_menu']; ?></label>
                                                                      </div>
                                                                    </div>
                                                                  </div>
                                                                  <div class="modal-footer">
                                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-fw fa-times"></i> Batal</button>
                                                                    <button type="submit" name="btnUbahMenu" class="btn btn-primary"><i class="fas fa-fw fa-save"></i> Ubah</button>
                                                                  </div>
                                                                </div>
                                                            </form>
                                                          </div>
                                                        </div>
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

    <!-- Tambah Menu Modal -->
    <div class="modal fade" id="tambahMenuModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="tambahMenuModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form method="post" enctype="multipart/form-data">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="tambahMenuModalLabel"><i class="fas fa-fw fa-plus"></i> Tambah Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="form-group">
                    <label for="nama_menu">Nama Menu<sup class="text-danger">*</sup></label>
                    <input type="text" class="form-control" id="nama_menu" name="nama_menu" required value="<?= (isset($_POST['nama_menu']) ? ($_POST['nama_menu'] == '' ? '' : $_POST['nama_menu']) : ""); ?>">
                </div>
                <div class="form-group">
                    <label for="harga_menu">Harga Menu<sup class="text-danger">*</sup></label>
                    <input type="number" class="form-control" id="harga_menu" name="harga_menu" required value="<?= (isset($_POST['harga_menu']) ? ($_POST['harga_menu'] == '' ? '' : $_POST['harga_menu']) : ""); ?>">
                </div>
                <div class="form-group">
                    <label for="jenis_menu">Jenis Menu <sup class="text-danger">*</sup></label>
                    <select name="jenis_menu" id="jenis_menu" class="custom-select">
                        <option value="makanan"><?= ucwords('makanan'); ?></option>
                        <option value="minuman"><?= ucwords('minuman'); ?></option>
                    </select>
                </div>
                <label for="foto_menu">Foto Menu<sup class="text-danger">*</sup></label>
                <div class="input-group mb-3">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="foto_menu" aria-describedby="foto_menu" name="foto_menu" required>
                    <label class="custom-file-label" for="foto_menu">Choose file</label>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-fw fa-times"></i> Batal</button>
                <button type="submit" name="btnTambahMenu" class="btn btn-primary"><i class="fas fa-fw fa-save"></i> Simpan</button>
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