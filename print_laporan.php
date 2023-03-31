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

    if (!isset($_GET['dari_tanggal'])) {
        header("Location: laporan.php");
        exit;
    }

    $dari_tanggal = htmlspecialchars($_GET['dari_tanggal']);
    $sampai_tanggal = htmlspecialchars($_GET['sampai_tanggal']);
    $status_pesanan = htmlspecialchars($_GET['status_pesanan']);

    $dari_tanggal_baru =  $dari_tanggal . ' 00:00:00';
    $sampai_tanggal_baru =  $sampai_tanggal . ' 23:59:59';

    if ($status_pesanan == 'semua') {
        $pesanan = mysqli_query($koneksi, "SELECT * FROM pesanan LEFT JOIN user ON pesanan.id_user = user.id_user WHERE tanggal_pesanan BETWEEN '$dari_tanggal_baru' AND '$sampai_tanggal_baru' ORDER BY tanggal_pesanan ASC");
        $omset = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT *, sum(total_pembayaran) as omset FROM pesanan WHERE tanggal_pesanan BETWEEN '$dari_tanggal_baru' AND '$sampai_tanggal_baru' ORDER BY tanggal_pesanan ASC"));
        $menu_paling_laku = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT tanggal_pesanan, status_pesanan, detail_pesanan.id_menu, nama_menu, SUM(jumlah) as laku FROM detail_pesanan INNER JOIN menu ON detail_pesanan.id_menu = menu.id_menu INNER JOIN pesanan ON detail_pesanan.id_pesanan = pesanan.id_pesanan WHERE tanggal_pesanan BETWEEN '$dari_tanggal_baru' AND '$sampai_tanggal_baru' GROUP BY id_menu ORDER BY laku DESC LIMIT 1"));

    }
    else
    {
        $pesanan = mysqli_query($koneksi, "SELECT * FROM pesanan LEFT JOIN user ON pesanan.id_user = user.id_user WHERE status_pesanan = '$status_pesanan' AND tanggal_pesanan BETWEEN '$dari_tanggal_baru' AND '$sampai_tanggal_baru' ORDER BY tanggal_pesanan ASC");
        $omset = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT *, sum(total_pembayaran) as omset FROM pesanan WHERE status_pesanan = '$status_pesanan' AND tanggal_pesanan BETWEEN '$dari_tanggal_baru' AND '$sampai_tanggal_baru' ORDER BY tanggal_pesanan ASC"));
        $menu_paling_laku = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT tanggal_pesanan, status_pesanan, detail_pesanan.id_menu, nama_menu, SUM(jumlah) as laku FROM detail_pesanan INNER JOIN menu ON detail_pesanan.id_menu = menu.id_menu INNER JOIN pesanan ON detail_pesanan.id_pesanan = pesanan.id_pesanan WHERE status_pesanan = '$status_pesanan' AND tanggal_pesanan BETWEEN '$dari_tanggal_baru' AND '$sampai_tanggal_baru' GROUP BY id_menu ORDER BY laku DESC LIMIT 1"));

    }

 ?>

 <!DOCTYPE html>
 <html lang="en">
 <head>
     <title>Laporan Markas Pancong UJ Dari Tanggal <?= $dari_tanggal; ?> Sampai Tanggal <?= $sampai_tanggal; ?> Dengan Status Pesanan <?= $status_pesanan; ?></title>
    <link rel="icon" href="img/logo.png">
 </head>
 <body>
    <img style="display: block; text-align: center; margin: 0 auto;" src="img/logo.png" alt="Logo" width="100">
    <h4 style="text-align: center;">Laporan Markas Pancong UJ - Dari Tanggal <?= $dari_tanggal; ?> Sampai Tanggal <?= $sampai_tanggal; ?> Dengan Status Pesanan <?= $status_pesanan; ?></h4>
     <h5>Omset: Rp. <?= str_replace(",", ".", number_format($omset['omset'])); ?></h5>
    <?php if ($menu_paling_laku): ?>
         <h5>Menu Terlaku: <?= ucwords($menu_paling_laku['nama_menu']); ?> - <?= $menu_paling_laku['laku']; ?></h5>
    <?php endif ?>
     <table border="1" cellspacing="0" cellpadding="10">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Pemesan</th>
                <th>No. Telp Pemesan</th>
                <th>Alamat Pemesan</th>
                <th>Tanggal Pesanan</th>
                <th>Total Pembayaran</th>
                <th>Status Pesanan</th>
                <th>Operator</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            <?php foreach ($pesanan as $dp): ?>
                <tr>
                    <td><?= $i++; ?></td>
                    <td><?= $dp['nama_pemesan']; ?></td>
                    <td><?= $dp['no_telp_pemesan']; ?></td>
                    <td><?= $dp['alamat_pemesan']; ?></td>
                    <td><?= $dp['tanggal_pesanan']; ?></td>
                    <td>Rp. <?= str_replace(",", ".", number_format($dp['total_pembayaran'])); ?></td>
                    <td><?= $dp['status_pesanan']; ?></td>
                    <td><?= $dp['nama_lengkap']; ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
     <script>
         window.print();
     </script>
 </body>
 </html>