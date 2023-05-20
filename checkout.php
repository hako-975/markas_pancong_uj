<?php 
require_once 'koneksi.php';

if (isset($_POST['btnPesan'])) {
  $menu_items = unserialize($_POST['menu_items']);

  $nama_pemesan = htmlspecialchars($_POST['nama_pemesan']);
  $no_telp_pemesan = htmlspecialchars($_POST['no_telp_pemesan']);
  if (substr($no_telp_pemesan, 0, 2) == "08") { // check if it starts with "08"
    $no_telp_pemesan = "62" . substr($no_telp_pemesan, 1);
  }
  $alamat_pemesan = htmlspecialchars($_POST['alamat_pemesan']);
  $total_pembayaran = htmlspecialchars($_POST['total_pembayaran']);
  $tanggal_pesanan = date('Y-m-d H:i:s:s');
  $kode_pesanan = $no_telp_pemesan . '-' . kodePesananUnik();

  $insert_pesanan = mysqli_query($koneksi, "INSERT INTO pesanan (kode_pesanan, nama_pemesan, no_telp_pemesan, alamat_pemesan, tanggal_pesanan, total_pembayaran, status_pesanan) VALUES ('$kode_pesanan', '$nama_pemesan', '$no_telp_pemesan', '$alamat_pemesan', '$tanggal_pesanan', '$total_pembayaran', 'proses')");

  foreach ($menu_items as $mi) {
    $id_menu_mi = $mi['id_menu']; 
    $jml_menu_mi = $mi['jml_menu'];
    $data_menu = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM menu WHERE id_menu = '$id_menu_mi'"));
      if ($jml_menu_mi > 0) {
        $subtotal = $data_menu['harga_menu'] * $mi['jml_menu'];
        $insert_detail_pesanan = mysqli_query($koneksi, "INSERT INTO detail_pesanan VALUES('', '$id_menu_mi', '$jml_menu_mi', '$subtotal', '$kode_pesanan')");
      }
  }

  if ($insert_detail_pesanan) {
    $_SESSION['kode_pesanan'] = $kode_pesanan;
    $nama_depan_pemesan = explode(" ", $nama_pemesan)[0];
    setAlert("Berhasil!", "Pesanan kak " . $nama_depan_pemesan . " lagi disiapin!", "success");
    header("Location: status_pesanan.php?kode_pesanan=$kode_pesanan");
    exit;

  }
}

if (!isset($_POST['id_menu'])) {
  echo "
    <script>
      window.history.back();
    </script>
  ";
  exit;
}

$id_menu = $_POST['id_menu'];
$jml_menu = $_POST['jml_menu'];

$menu_items = array();

for ($i=0; $i < count($id_menu); $i++) { 
  $menu_items[] = [
    "id_menu" => $id_menu[$i], 
    "jml_menu" => $jml_menu[$i]
  ];
}

$all_zero = true;
foreach ($menu_items as $item) {
  if ($item['jml_menu'] != 0) {
    $all_zero = false;
    break;
  }
}

if ($all_zero) {
  setAlert("Perhatian!", "Pilih setidaknya satu menu!", "error");
  echo "
    <script>
      window.history.back();
    </script>
  ";
}

?>

<!DOCTYPE html>
<html lang="en" id="home">

<head>
  <title>Checkout - Markas Pancong UJ</title>
  <?php include 'head.php' ?>
</head>
<body>
  <div class="container-fluid my-3">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <button type="button" onclick="return window.history.back()" class="btn btn-primary mb-3"><i class="fas fa-fw fa-arrow-left"></i> Kembali</button>
        <h2 class="text-center">Checkout</h2>
        <hr>
        <div class="table-responsive">
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
              <?php foreach ($menu_items as $mi): ?>
                <?php 
                  $id_menu_mi = $mi['id_menu']; 
                  $data_menu = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM menu WHERE id_menu = '$id_menu_mi'"));
                  if ($mi['jml_menu'] > 0) :
                    $subtotal = $data_menu['harga_menu'] * $mi['jml_menu'];
                    $total_pembayaran += $subtotal;
                ?>
                <tr>
                  <td><?= $data_menu['nama_menu']; ?></td>
                  <td><?= $data_menu['jenis_menu']; ?></td>
                  <td><?= str_replace(",", ".", number_format($data_menu['harga_menu'])); ?></td>
                  <td><?= $mi['jml_menu']; ?></td>
                  <td class="text-right"><?= str_replace(",", ".", number_format($subtotal)); ?></td>
                </tr>
                <?php endif ?>
              <?php endforeach ?>
              <tr>
                <th colspan="4">Total</th>
                <th class="text-right"><?= str_replace(",", ".", number_format($total_pembayaran)); ?></th>
              </tr>
            </tbody>
          </table>
        </div>
        <h3>Data Penerima</h3>
        <form method="post">
          <input type="hidden" name="menu_items" value="<?= htmlspecialchars(serialize($menu_items)); ?>">
          <input type="hidden" name="total_pembayaran" value="<?= $total_pembayaran; ?>">
          <div class="form-group">
            <label for="nama_pemesan">Nama Pemesan</label>
            <input type="text" class="form-control" id="nama_pemesan" name="nama_pemesan" required>
          </div>
          <div class="form-group">
            <label for="no_telp_pemesan">WhatsApp Pemesan</label>
            <input type="number" class="form-control" id="no_telp_pemesan" name="no_telp_pemesan" required>
          </div>
          <div class="form-group">
            <label for="alamat_pemesan">Lokasi Pengantaran</label>
            <textarea class="form-control" id="alamat_pemesan" name="alamat_pemesan" required></textarea>
          </div>
          <div class="form-group text-right">
            <button type="submit" class="btn btn-success" name="btnPesan"><i class="fa fa-fw fa-paper-plane"></i> Pesan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <footer class="sticky-footer bg-white">
    <div class="container my-auto">
      <div class="copyright text-center my-auto">
        <span>Copyright &copy; Markas Pancong UJ 2023</span>
      </div>
    </div>
  </footer>
 <?php include 'script.php' ?>
</body>
</html>