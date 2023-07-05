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

    $dari_awal_bulan = date('Y-m-01') . ' 00:00:00';
    $sampai_tanggal_ini = date('Y-m-d') . ' 23:59:59';
    
    $menu = mysqli_query($koneksi, "SELECT * FROM menu");

    $pesanan = mysqli_query($koneksi, "SELECT * FROM pesanan INNER JOIN user ON pesanan.id_user = user.id_user WHERE tanggal_pesanan BETWEEN '$dari_awal_bulan' AND '$sampai_tanggal_ini' ORDER BY tanggal_pesanan DESC");
    if (isset($_GET['status_pesanan'])) {
        $status_pesanan = htmlspecialchars($_GET['status_pesanan']);
        if ($status_pesanan == 'semua') {
            $pesanan = mysqli_query($koneksi, "SELECT * FROM pesanan INNER JOIN user ON pesanan.id_user = user.id_user WHERE tanggal_pesanan BETWEEN '$dari_awal_bulan' AND '$sampai_tanggal_ini' ORDER BY tanggal_pesanan DESC");
        }
        else
        {
            $pesanan = mysqli_query($koneksi, "SELECT * FROM pesanan INNER JOIN user ON pesanan.id_user = user.id_user WHERE status_pesanan = '$status_pesanan' AND tanggal_pesanan BETWEEN '$dari_awal_bulan' AND '$sampai_tanggal_ini' ORDER BY tanggal_pesanan DESC");
        }
    }

    
    $pesanan_semua = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pesanan INNER JOIN user ON pesanan.id_user = user.id_user WHERE tanggal_pesanan BETWEEN '$dari_awal_bulan' AND '$sampai_tanggal_ini'"));
    $pesanan_proses = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pesanan INNER JOIN user ON pesanan.id_user = user.id_user WHERE status_pesanan = 'proses' AND tanggal_pesanan BETWEEN '$dari_awal_bulan' AND '$sampai_tanggal_ini'"));
    $pesanan_dibuat = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pesanan INNER JOIN user ON pesanan.id_user = user.id_user WHERE status_pesanan = 'dibuat' AND tanggal_pesanan BETWEEN '$dari_awal_bulan' AND '$sampai_tanggal_ini'"));
    $pesanan_perjalanan = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pesanan INNER JOIN user ON pesanan.id_user = user.id_user WHERE status_pesanan = 'perjalanan' AND tanggal_pesanan BETWEEN '$dari_awal_bulan' AND '$sampai_tanggal_ini'"));
    $pesanan_selesai = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pesanan INNER JOIN user ON pesanan.id_user = user.id_user WHERE status_pesanan = 'selesai' AND tanggal_pesanan BETWEEN '$dari_awal_bulan' AND '$sampai_tanggal_ini'"));

    if (isset($_GET['btnFilter'])) {
        $dari_tanggal = htmlspecialchars($_GET['dari_tanggal']);
        $sampai_tanggal = htmlspecialchars($_GET['sampai_tanggal']);

        $dari_tanggal_baru =  $dari_tanggal . ' 00:00:00';
        $sampai_tanggal_baru =  $sampai_tanggal . ' 23:59:59';

        $pesanan = mysqli_query($koneksi, "SELECT * FROM pesanan INNER JOIN user ON pesanan.id_user = user.id_user WHERE tanggal_pesanan BETWEEN '$dari_tanggal_baru' AND '$sampai_tanggal_baru' ORDER BY tanggal_pesanan DESC");
        if (isset($_GET['status_pesanan'])) {
            $status_pesanan = htmlspecialchars($_GET['status_pesanan']);
            if ($status_pesanan == 'semua') {
                $pesanan = mysqli_query($koneksi, "SELECT * FROM pesanan INNER JOIN user ON pesanan.id_user = user.id_user ORDER BY tanggal_pesanan DESC");
            }
            else
            {
                $pesanan = mysqli_query($koneksi, "SELECT * FROM pesanan INNER JOIN user ON pesanan.id_user = user.id_user WHERE status_pesanan = '$status_pesanan' ORDER BY tanggal_pesanan DESC");
            }
        }

        
        $pesanan_semua = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pesanan INNER JOIN user ON pesanan.id_user = user.id_user WHERE tanggal_pesanan BETWEEN '$dari_tanggal_baru' AND '$sampai_tanggal_baru'"));
        $pesanan_proses = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pesanan INNER JOIN user ON pesanan.id_user = user.id_user WHERE status_pesanan = 'proses' AND tanggal_pesanan BETWEEN '$dari_tanggal_baru' AND '$sampai_tanggal_baru'"));
        $pesanan_dibuat = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pesanan INNER JOIN user ON pesanan.id_user = user.id_user WHERE status_pesanan = 'dibuat' AND tanggal_pesanan BETWEEN '$dari_tanggal_baru' AND '$sampai_tanggal_baru'"));
        $pesanan_perjalanan = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pesanan INNER JOIN user ON pesanan.id_user = user.id_user WHERE status_pesanan = 'perjalanan' AND tanggal_pesanan BETWEEN '$dari_tanggal_baru' AND '$sampai_tanggal_baru'"));
        $pesanan_selesai = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pesanan INNER JOIN user ON pesanan.id_user = user.id_user WHERE status_pesanan = 'selesai' AND tanggal_pesanan BETWEEN '$dari_tanggal_baru' AND '$sampai_tanggal_baru'"));
    }
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
                        <h6 class="mt-2 font-weight-bold text-primary">Data Pesanan (<?= (isset($_GET['btnFilter'])) ? "Filter" : "Bulan Ini"; ?>)</h6>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form method="GET">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="dari_tanggal">Dari Tanggal</label>
                                <input class="form-control" type="date" name="dari_tanggal" value="<?= isset($_GET['btnFilter']) ? $dari_tanggal : date('Y-m-01'); ?>">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="sampai_tanggal">Sampai Tanggal</label>
                                <input class="form-control" type="date" name="sampai_tanggal" value="<?= isset($_GET['btnFilter']) ? $sampai_tanggal : date('Y-m-d'); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="btnFilter" class="btn btn-primary"><i class="fas fa-fw fa-filter"></i> Filter</button>
                        <a href="pesanan.php" class="btn btn-primary"><i class="fas fa-fw fa-redo"></i> Reset</a>
                    </div>
                </form>
                <hr>
                <div class="row justify-content-center text-center mb-2">
                    <div class="col">
                        <h4>Filter Status:</h4>
                        <a href="pesanan.php?status_pesanan=semua" class="col-2 text-center text-white m-auto btn btn-dark">(<?= $pesanan_semua; ?>) Semua</a>
                        <a href="pesanan.php?status_pesanan=proses" class="col-2 text-center text-white m-auto btn btn-danger">(<?= $pesanan_proses; ?>) Proses</a>
                        <a href="pesanan.php?status_pesanan=dibuat" class="col-2 text-center text-white m-auto btn btn-warning">(<?= $pesanan_dibuat; ?>) Dibuat</a>
                        <a href="pesanan.php?status_pesanan=perjalanan" class="col-2 text-center text-white m-auto btn btn-success">(<?= $pesanan_perjalanan; ?>) Perjalanan</a>
                        <a href="pesanan.php?status_pesanan=selesai" class="col-2 text-center text-white m-auto btn btn-primary">(<?= $pesanan_selesai; ?>) Selesai</a>
                    </div>
                </div>
                <hr>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" cellspacing="0">
                        <thead>
                            <tr class="text-center">
                                <th>No.</th>
                                <th>Nama Pemesan</th>
                                <th>No. WhatsApp Pemesan</th>
                                <th>Alamat Pemesan</th>
                                <th style="min-width: 8rem;">Tanggal Pesanan</th>
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
                                    <td class="align-middle"><?= $dp['nama_lengkap']; ?></td>
                                    <?php 
                                        $toNumber62 = $dp['no_telepon'];
                                        if (substr($toNumber62, 0, 2) != "62") {
                                            $toNumber62 = substr_replace($toNumber62, "62", 0, 1);
                                        }
                                     ?>
                                    <td class="align-middle"><a target="_blank" class="btn btn-sm btn-success" href="https://wa.me/<?= $toNumber62; ?>"><i class="fab fa-fw fa-whatsapp"></i> +<?= $toNumber62; ?></a></td>
                                    <td class="align-middle"><?= $dp['alamat']; ?></td>
                                    <td class="align-middle"><?= date("d-m-Y, H:i", strtotime($dp['tanggal_pesanan'])); ?></td>
                                    <td class="align-middle">
                                        Rp. <?= str_replace(",", ".", number_format($dp['total_pembayaran'])); ?>
                                    </td>
                                    <td class="align-middle text-center">
                                        <?php if ($dp['status_pesanan'] == 'proses'): ?>
                                            <a data-status="Ubah" data-nama="Apakah Anda yakin ingin mengubah status menjadi dibuat?" href="ubah_status.php?kode_pesanan=<?= $dp['kode_pesanan']; ?>&status=dibuat" class="btn btn-alert btn-danger"><?= ucwords($dp['status_pesanan']); ?></a>
                                        <?php elseif ($dp['status_pesanan'] == 'dibuat'): ?>
                                            <a data-status="Ubah" data-nama="Apakah Anda yakin ingin mengubah status menjadi perjalanan?" href="ubah_status.php?kode_pesanan=<?= $dp['kode_pesanan']; ?>&status=perjalanan" class="btn btn-alert btn-warning"><?= ucwords($dp['status_pesanan']); ?></a>
                                        <?php elseif ($dp['status_pesanan'] == 'perjalanan'): ?>
                                            <a data-status="Ubah" data-nama="Apakah Anda yakin ingin mengubah status menjadi selesai?" href="ubah_status.php?kode_pesanan=<?= $dp['kode_pesanan']; ?>&status=selesai" class="btn btn-alert btn-success"><?= ucwords($dp['status_pesanan']); ?></a>
                                        <?php elseif ($dp['status_pesanan'] == 'selesai'): ?>
                                            <a class="btn btn-primary"><?= ucwords($dp['status_pesanan']); ?></a>
                                        <?php endif ?>
                                    </td>
                                    <td class="text-center align-middle">
                                        <a class="btn btn-sm btn-success m-1" href="detail_pesanan.php?kode_pesanan=<?= $dp['kode_pesanan']; ?>"><i class="fas fa-fw fa-bars"></i> Detail</a>
                                        <a class="btn btn-sm btn-danger text-white m-1 btn-alert" data-status="Hapus" href="hapus_pesanan.php?kode_pesanan=<?= $dp['kode_pesanan']; ?>" data-nama="Pesanan dengan nama kak <?= $dp['nama_lengkap']; ?> akan terhapus!"><i class="fas fa-fw fa-trash"></i> Hapus</a>
                                        
                                        <div class="modal fade" id="ubahPesananModal<?= $dp['kode_pesanan']; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="ubahPesananModalLabel<?= $dp['kode_pesanan']; ?>" aria-hidden="true">
                                          <div class="modal-dialog text-left">
                                            <form method="post" enctype="multipart/form-data">
                                                <input type="hidden" name="kode_pesanan" value="<?= $dp['kode_pesanan']; ?>">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <h5 class="modal-title" id="ubahPesananModalLabel<?= $dp['kode_pesanan']; ?>"><i class="fas fa-fw fa-edit"></i> Ubah Pesanan - <?= $dp['nama_lengkap']; ?></h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                      <span aria-hidden="true">&times;</span>
                                                    </button>
                                                  </div>
                                                  <div class="modal-body">
                                                    <div class="row">
                                                      <div class="col">
                                                        <div class="form-group">
                                                          <label for="nama_lengkap">Nama Pemesan<sup class="text-danger">*</sup></label>
                                                          <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required value="<?= (isset($_POST['nama_lengkap']) ? ($_POST['nama_lengkap'] == '' ? $dp['nama_lengkap'] : $_POST['nama_lengkap']) : $dp['nama_lengkap']); ?>">
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

 
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


    <?php include 'script.php'; ?>

</body>

</html>