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

    $pesanan_semua = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pesanan"));
    $pesanan_proses = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pesanan WHERE status_pesanan = 'proses'"));
    $pesanan_dibuat = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pesanan WHERE status_pesanan = 'dibuat'"));
    $pesanan_perjalanan = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pesanan WHERE status_pesanan = 'perjalanan'"));
    $pesanan_selesai = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pesanan WHERE status_pesanan = 'selesai'"));

    $pesanan = mysqli_query($koneksi, "SELECT * FROM pesanan ORDER BY tanggal_pesanan DESC");

    $omset = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT *, sum(total_pembayaran) as omset FROM pesanan"));

    $total_menu = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM menu"));

 ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dashboard - Kantin Markas Pancong UJ</title>
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
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    </div>
                    <div class="row">
                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Omset</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. <?= str_replace(",", ".", number_format($omset['omset'])); ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Pesanan</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $pesanan_semua; ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Menu</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_menu; ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="mt-0">
                    <div class="row">
                        <div class="col">
                            <h4>Total Pesanan Berdasarkan Status:</h4>
                            <!-- Content Row -->
                            <div class="row">

                                <!-- Earnings (Monthly) Card Example -->
                                <div class="col-xl-3 col-md-6 mb-4">
                                    <a href="pesanan.php?status_pesanan=proses" class="text-decoration-none">
                                        <div class="card border-left-danger shadow h-100 py-2">
                                            <div class="card-body">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Belum Di Proses</div>
                                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $pesanan_proses; ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <!-- Earnings (Monthly) Card Example -->
                                <div class="col-xl-3 col-md-6 mb-4">
                                    <a href="pesanan.php?status_pesanan=dibuat" class="text-decoration-none">
                                        <div class="card border-left-warning shadow h-100 py-2">
                                            <div class="card-body">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Dibuat</div>
                                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $pesanan_dibuat; ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <!-- Earnings (Monthly) Card Example -->
                                <div class="col-xl-3 col-md-6 mb-4">
                                    <a href="pesanan.php?status_pesanan=perjalanan" class="text-decoration-none">
                                        <div class="card border-left-success shadow h-100 py-2">
                                            <div class="card-body">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Dalam Perjalan</div>
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col-auto">
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $pesanan_perjalanan; ?></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <!-- Pending Requests Card Example -->
                                <div class="col-xl-3 col-md-6 mb-4">
                                    <a href="pesanan.php?status_pesanan=selesai" class="text-decoration-none">
                                        <div class="card border-left-primary shadow h-100 py-2">
                                            <div class="card-body">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Selesai</div>
                                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $pesanan_selesai; ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="mt-0">
                    <div class="row">
                        <div class="col">
                            <h4>Pesanan Terbaru:</h4>
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
                                                        <a onclick="return confirm('Apakah Anda yakin ingin mengubah status menjadi dibuat?')" href="ubah_status.php?id_pesanan=<?= $dp['id_pesanan']; ?>&status=dibuat" class="btn btn-danger"><?= ucwords($dp['status_pesanan']); ?></a>
                                                    <?php elseif ($dp['status_pesanan'] == 'dibuat'): ?>
                                                        <a onclick="return confirm('Apakah Anda yakin ingin mengubah status menjadi perjalanan?')" href="ubah_status.php?id_pesanan=<?= $dp['id_pesanan']; ?>&status=perjalanan" class="btn btn-warning"><?= ucwords($dp['status_pesanan']); ?></a>
                                                    <?php elseif ($dp['status_pesanan'] == 'perjalanan'): ?>
                                                        <a onclick="return confirm('Apakah Anda yakin ingin mengubah status menjadi selesai?')" href="ubah_status.php?id_pesanan=<?= $dp['id_pesanan']; ?>&status=selesai" class="btn btn-success"><?= ucwords($dp['status_pesanan']); ?></a>
                                                    <?php elseif ($dp['status_pesanan'] == 'selesai'): ?>
                                                        <a class="btn btn-primary"><?= ucwords($dp['status_pesanan']); ?></a>
                                                    <?php endif ?>
                                                </td>
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