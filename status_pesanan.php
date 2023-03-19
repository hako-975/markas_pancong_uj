<?php 
require_once 'koneksi.php';

if (!isset($_GET['id_pesanan'])) {
  header("Location: pesan.php");
  exit;
}

$id_pesanan = $_GET['id_pesanan'];

$pesanan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM pesanan WHERE id_pesanan = '$id_pesanan'"));
$detail_pesanan = mysqli_query($koneksi, "SELECT * FROM detail_pesanan INNER JOIN menu ON detail_pesanan.id_menu = menu.id_menu WHERE id_pesanan = '$id_pesanan'");
?>

<!DOCTYPE html>
<html lang="en" id="home">

<head>
  <title>Status Pesanan <?= $pesanan['nama_pemesan']; ?> - Markas Pancong UJ</title>
  <?php include 'head.php' ?>
</head>
<body>
  <div class="container my-5">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <h2 class="text-center">Status Pesanan - <?= $pesanan['nama_pemesan']; ?></h2>
        <hr>
        <div class="row">
          <div class="col">
            <table cellpadding="5">
              <tr>
                <th>Nama Pemesan</th>
                <th>:</th>
                <td><?= $pesanan['nama_pemesan']; ?></td>
              </tr>
              <tr>
                <th>WhatsApp Pemesan</th>
                <th>:</th>
                <td><?= $pesanan['no_telp_pemesan']; ?></td>
              </tr>
              <tr>
                <th>Alamat Pemesan</th>
                <th>:</th>
                <td><?= $pesanan['alamat_pemesan']; ?></td>
              </tr>
            </table>
          </div>
          <div class="col">
            <table cellpadding="5">
              <tr>
                <th>Tanggal Pesanan</th>
                <th>:</th>
                <td><?= $pesanan['tanggal_pesanan']; ?></td>
              </tr>
              <tr>
                <th>Total Pembayaran</th>
                <th>:</th>
                <td>Rp. <?= str_replace(",", ".", number_format($pesanan['total_pembayaran'])); ?></td>
              </tr>
              <tr>
                <th>Status Pesanan</th>
                <th>:</th>
                <td>
                  <?php if ($pesanan['status_pesanan'] == 'proses'): ?>
                    <span class="btn btn-danger"><?= ucwords($pesanan['status_pesanan']); ?></span>
                  <?php elseif ($pesanan['status_pesanan'] == 'dibuat'): ?>
                    <span class="btn btn-warning"><?= ucwords($pesanan['status_pesanan']); ?></span>
                  <?php elseif ($pesanan['status_pesanan'] == 'perjalanan'): ?>
                    <span class="btn btn-success"><?= ucwords($pesanan['status_pesanan']); ?></span>
                  <?php elseif ($pesanan['status_pesanan'] == 'selesai'): ?>
                    <span class="btn btn-primary"><?= ucwords($pesanan['status_pesanan']); ?></span>
                  <?php endif ?>
                </td>
              </tr>
            </table>
          </div>
        </div>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Nama Menu</th>
              <th>Jenis Menu</th>
              <th>Harga Menu</th>
              <th>Jumlah Menu</th>
              <th>Subtotal</th>
            </tr>
          </thead>
          <tbody>
            <?php $total_pembayaran = 0; ?>
            <?php foreach ($detail_pesanan as $dp): ?>
              <tr>
                <td><?= $dp['nama_menu']; ?></td>
                <td><?= $dp['jenis_menu']; ?></td>
                <td>Rp. <?= str_replace(",", ".", number_format($dp['harga_menu'])); ?></td>
                <td><?= $dp['jumlah']; ?></td>
                <td class="text-right">Rp. <?= str_replace(",", ".", number_format($dp['subtotal'])); ?></td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
 <?php include 'script.php' ?>
</body>
</html>