<?php 
require 'koneksi.php';

if (isset($_GET['kode_pesanan'])) {
  $kode_pesanan = $_GET['kode_pesanan'];
  $pesanan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM pesanan INNER JOIN user ON pesanan.id_user = user.id_user WHERE kode_pesanan = '$kode_pesanan'"));
  if ($pesanan == null) {
    header("Location: status_pesanan.php");
    exit;
  }

  $detail_pesanan = mysqli_query($koneksi, "SELECT * FROM detail_pesanan INNER JOIN menu ON detail_pesanan.id_menu = menu.id_menu WHERE kode_pesanan = '$kode_pesanan'");
}
else {
	header("Location: status_pesanan.php");
	exit;
}

?>

<!DOCTYPE html>
<html lang="en" id="home">

<head>
  <title>Status Pesanan <?php if (isset($_GET['kode_pesanan'])) { echo $pesanan['nama_lengkap']; } ?> - Markas Pancong UJ</title>
  <?php include 'head.php' ?>
</head>
<body>
    <h3 class="text-center mt-3">Status Pesanan<?php if (isset($_GET['kode_pesanan'])) { echo "<br>".$pesanan['nama_lengkap']; } ?></h3>
    <hr>
	<h5>Kode Pesanan: <?= $pesanan['kode_pesanan']; ?></h5>
	<hr>
	<div class="row">
	    <div class="col">
	      <table cellpadding="5">
	        <tr>
	          <th>Nama Pemesan</th>
	          <th>:</th>
	          <td><?= $pesanan['nama_lengkap']; ?></td>
	        </tr>
	        <tr>
	          <th>WhatsApp Pemesan</th>
	          <th>:</th>
	          <td><?= $pesanan['no_telepon']; ?></td>
	        </tr>
	        <tr>
	          <th>Alamat Pemesan</th>
	          <th>:</th>
	          <td><?= $pesanan['alamat']; ?></td>
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
	          	<?= ucwords($pesanan['status_pesanan']); ?>
	          </td>
	        </tr>
	      </table>
	    </div>
	</div>
  <hr>
	<div class="table-responsive mt-3">
	    <table class="table table-bordered font-size-checkout">
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
	            <td><?= str_replace(",", ".", number_format($dp['harga_menu'])); ?></td>
	            <td><?= $dp['jumlah']; ?></td>
	            <td class="text-right"><?= str_replace(",", ".", number_format($dp['subtotal'])); ?></td>
	          </tr>
	        <?php endforeach ?>
	        	<tr>
              <th colspan="4">Total Pembayaran</th>
              <th class="text-right"><?= str_replace(",", ".", number_format($pesanan['total_pembayaran'])); ?></th>
            </tr>
	      </tbody>
	    </table>
	  </div>
  <footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright &copy; Markas Pancong UJ 2023</span>
        </div>
    </div>
  </footer>
 <?php include 'script.php' ?>
 <script>
 	window.print();
 </script>
</body>
</html>