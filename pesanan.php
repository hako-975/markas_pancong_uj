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

    if (isset($_POST['btnTambahPesanan'])) {
        $nama_pemesan = htmlspecialchars($_POST['nama_pemesan']);
        $no_telp_pemesan = htmlspecialchars($_POST['no_telp_pemesan']);
        $alamat_pemesan = htmlspecialchars($_POST['alamat_pemesan']);
        $tanggal_pesanan = date("Y-m-d H:i:s");
        $status_pesanan = 'proses';

        $insert_pesanan = mysqli_query($koneksi, "INSERT INTO pesanan (nama_pemesan, no_telp_pemesan, alamat_pemesan, tanggal_pesanan, status_pesanan) VALUES ('$nama_pemesan', '$no_telp_pemesan', '$alamat_pemesan', '$tanggal_pesanan', '$status_pesanan')");

        if ($insert_pesanan) {
            $id_pesanan = mysqli_insert_id($koneksi);
            echo "
                <script>
                    alert('Pesanan berhasil ditambahkan!')
                    window.location='detail_pesanan.php?id_pesanan=$id_pesanan'
                </script>
            ";
            exit;
        }
        else
        {
            echo "
                <script>
                    alert('Pesanan Gagal ditambahkan!')
                    window.history.back();
                </script>
            ";
            exit;
        }
    }

    if (isset($_POST['btnUbahPesanan'])) {
        $id_pesanan = htmlspecialchars($_POST['id_pesanan']);
        $nama_pemesan = htmlspecialchars($_POST['nama_pemesan']);
        $no_telp_pemesan = htmlspecialchars($_POST['no_telp_pemesan']);
        $alamat_pemesan = htmlspecialchars($_POST['alamat_pemesan']);

        $update_pesanan = mysqli_query($koneksi, "UPDATE pesanan SET nama_pemesan = '$nama_pemesan', no_telp_pemesan = '$no_telp_pemesan', alamat_pemesan = '$alamat_pemesan' WHERE id_pesanan = '$id_pesanan'");

        if ($update_pesanan) {
            echo "
                <script>
                    alert('Pesanan berhasil diubah!')
                    window.location='pesanan.php'
                </script>
            ";
            exit;
        }
        else
        {
            echo "
                <script>
                    alert('Pesanan Gagal diubah!')
                    window.history.back();
                </script>
            ";
            exit;
        }
    }

    $pesanan = mysqli_query($koneksi, "SELECT * FROM pesanan");
    $menu = mysqli_query($koneksi, "SELECT * FROM menu");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Pesanan - Markas Pancong UJ</title>

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
                                        <h6 class="mt-2 font-weight-bold text-primary">Data Pesanan</h6>
                                    </div>
                                    <div class="col head-right">
                                        <button type="button" class="btn btn-sm btn-primary"  data-toggle="modal" data-target="#tambahPesananModal"><i class="fas fa-fw fa-plus"></i> Tambah Pesanan</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" cellspacing="0">
                                        <thead>
                                            <tr class="text-center">
                                                <th>No.</th>
                                                <th>Nama Pemesan</th>
                                                <th>No. WhatsApp Pemesan</th>
                                                <th>Alamat Pemesan</th>
                                                <th style="min-width: 11rem;">Tanggal Pesanan</th>
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
                                                    <td class="align-middle"><?= ucwords($dp['status_pesanan']); ?></td>
                                                    <td class="text-center align-middle">
                                                        <a class="btn btn-sm btn-success" href="detail_pesanan.php?id_pesanan=<?= $dp['id_pesanan']; ?>"><i class="fas fa-fw fa-bars"></i> Detail</a>
                                                        <a class="btn btn-sm btn-warning text-white m-1" data-toggle="modal" data-target="#ubahPesananModal<?= $dp['id_pesanan']; ?>"><i class="fas fa-fw fa-edit"></i> Ubah</a>
                                                        <a class="btn btn-sm btn-danger text-white m-1" href="hapus_pesanan.php?id_pesanan=<?= $dp['id_pesanan']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus pesanan dengan nama pemesan <?= $dp['nama_pemesan']; ?>?')"><i class="fas fa-fw fa-trash"></i> Hapus</a>
                                                        
                                                        <div class="modal fade" id="ubahPesananModal<?= $dp['id_pesanan']; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="ubahPesananModalLabel<?= $dp['id_pesanan']; ?>" aria-hidden="true">
                                                          <div class="modal-dialog text-left">
                                                            <form method="post" enctype="multipart/form-data">
                                                                <input type="hidden" name="id_pesanan" value="<?= $dp['id_pesanan']; ?>">
                                                                <div class="modal-content">
                                                                  <div class="modal-header">
                                                                    <h5 class="modal-title" id="ubahPesananModalLabel<?= $dp['id_pesanan']; ?>"><i class="fas fa-fw fa-edit"></i> Ubah Pesanan - <?= $dp['nama_pemesan']; ?></h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                      <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                  </div>
                                                                  <div class="modal-body">
                                                                    <div class="row">
                                                                      <div class="col">
                                                                        <div class="form-group">
                                                                          <label for="nama_pemesan">Nama Pemesan<sup class="text-danger">*</sup></label>
                                                                          <input type="text" class="form-control" id="nama_pemesan" name="nama_pemesan" required value="<?= (isset($_POST['nama_pemesan']) ? ($_POST['nama_pemesan'] == '' ? $dp['nama_pemesan'] : $_POST['nama_pemesan']) : $dp['nama_pemesan']); ?>">
                                                                        </div>
                                                                      </div>
                                                                      <div class="col">
                                                                        <div class="form-group">
                                                                          <label for="no_telp_pemesan">No. Telp Pemesan<sup class="text-danger">*</sup></label>
                                                                          <input type="text" class="form-control" id="no_telp_pemesan" name="no_telp_pemesan" required value="<?= (isset($_POST['no_telp_pemesan']) ? ($_POST['no_telp_pemesan'] == '' ? $dp['no_telp_pemesan'] : $_POST['no_telp_pemesan']) : $dp['no_telp_pemesan']); ?>">
                                                                        </div>
                                                                      </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                      <label for="alamat_pemesan">Alamat Pemesan<sup class="text-danger">*</sup></label>
                                                                      <textarea class="form-control" id="alamat_pemesan" name="alamat_pemesan" required><?= (isset($_POST['alamat_pemesan']) ? ($_POST['alamat_pemesan'] == '' ? $dp['alamat_pemesan'] : $_POST['alamat_pemesan']) : $dp['alamat_pemesan']); ?></textarea>
                                                                    </div>
                                                                  </div>
                                                                  <div class="modal-footer">
                                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-fw fa-times"></i> Batal</button>
                                                                    <button type="submit" name="btnUbahPesanan" class="btn btn-primary"><i class="fas fa-fw fa-save"></i> Ubah</button>
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

    <!-- Tambah Pesanan Modal -->
    <div class="modal fade" id="tambahPesananModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="tambahPesananModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form method="post" enctype="multipart/form-data">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="tambahPesananModalLabel"><i class="fas fa-fw fa-plus"></i> Tambah Pesanan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <h5>Data Pemesan</h5>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="nama_pemesan">Nama Pemesan<sup class="text-danger">*</sup></label>
                            <input type="text" class="form-control" id="nama_pemesan" name="nama_pemesan" required value="<?= (isset($_POST['nama_pemesan']) ? ($_POST['nama_pemesan'] == '' ? '' : $_POST['nama_pemesan']) : ""); ?>">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="no_telp_pemesan">No. Telp Pemesan<sup class="text-danger">*</sup></label>
                            <input type="number" class="form-control" id="no_telp_pemesan" name="no_telp_pemesan" required value="<?= (isset($_POST['no_telp_pemesan']) ? ($_POST['no_telp_pemesan'] == '' ? '' : $_POST['no_telp_pemesan']) : ""); ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="alamat_pemesan">Alamat Pemesan<sup class="text-danger">*</sup></label>
                    <textarea class="form-control" id="alamat_pemesan" name="alamat_pemesan" required><?= (isset($_POST['alamat_pemesan']) ? ($_POST['alamat_pemesan'] == '' ? '' : $_POST['alamat_pemesan']) : ""); ?></textarea>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-fw fa-times"></i> Batal</button>
                <button type="submit" name="btnTambahPesanan" class="btn btn-primary"><i class="fas fa-fw fa-save"></i> Simpan</button>
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