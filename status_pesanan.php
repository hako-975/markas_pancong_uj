<?php 
require_once 'koneksi.php';

if (isset($_GET['kode_pesanan'])) {
  $kode_pesanan = $_GET['kode_pesanan'];
  $pesanan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM pesanan WHERE kode_pesanan = '$kode_pesanan'"));

  if ($pesanan == null) {
    setAlert("Perhatian!", "Kode Pesanan yang Anda masukkan tidak ditemukan!", "error");
    header("Location: status_pesanan.php");
    exit;
  }

  $detail_pesanan = mysqli_query($koneksi, "SELECT * FROM detail_pesanan INNER JOIN menu ON detail_pesanan.id_menu = menu.id_menu WHERE kode_pesanan = '$kode_pesanan'");
}

?>

<!DOCTYPE html>
<html lang="en" id="home">

<head>
  <title>Status Pesanan <?php if (isset($_GET['kode_pesanan'])) { echo $pesanan['nama_pemesan']; } ?> - Markas Pancong UJ</title>
  <?php include 'head.php' ?>
</head>
<body>
  <div class="container my-3">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="row justify-content-between">
          <div class="col text-left">
            <a href="pesan.php" class="btn btn-primary"><i class="fas fa-fw fa-arrow-left"></i> Kembali</a>
          </div>
        <?php if (isset($_GET['kode_pesanan'])): ?>
          <div class="col text-right">
            <a class="btn btn-success" target="_blank" href="cetak_status_pesanan.php?kode_pesanan=<?= $kode_pesanan; ?>"><i class="fas fa-fw fa-print"></i> Cetak</a>
          </div>
        <?php endif ?>
        </div>
        <h3 class="text-center mt-3">Status Pesanan<?php if (isset($_GET['kode_pesanan'])) { echo "<br>".$pesanan['nama_pemesan']; } ?></h3>
        <hr>
        <?php if (!isset($_GET['kode_pesanan'])): ?>
        <form class="form-inline mx-auto justify-content-center" method="GET">
          <div class="form-group mx-3 mb-2">
            <label for="kode_pesanan" class="mx-3">Kode Pesanan</label>
            <input type="text" name="kode_pesanan" class="form-control" id="kode_pesanan" placeholder="Kode Pesanan" value="<?= isset($_SESSION['kode_pesanan']) ? $_SESSION['kode_pesanan'] : ''; ?>">
          </div>
          <button type="submit" class="btn btn-primary mb-2"><i class="fas fa-fw fa-paper-plane"></i> Kirim</button>
        </form>
        <?php endif ?>

        <?php if (isset($_GET['kode_pesanan'])): ?>
          <h5>
            Kode Pesanan: <span id="kodePesanan"><?= $pesanan['kode_pesanan']; ?></span>
            <sup><button class="btn p-0" onclick="copyContent()" type="button"><i class="fas fa-fw fa-copy"></i></button></sup>
          </h5>
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
                      <a data-toggle="modal" data-target="#statusPesananModal" href="status_pesanan.php?kode_pesanan=<?= $kode_pesanan; ?>" class="btn btn-danger"><?= ucwords($pesanan['status_pesanan']); ?></a>
                    <?php elseif ($pesanan['status_pesanan'] == 'dibuat'): ?>
                      <a data-toggle="modal" data-target="#statusPesananModal" href="status_pesanan.php?kode_pesanan=<?= $kode_pesanan; ?>" class="btn btn-warning"><?= ucwords($pesanan['status_pesanan']); ?></a>
                    <?php elseif ($pesanan['status_pesanan'] == 'perjalanan'): ?>
                      <a data-toggle="modal" data-target="#statusPesananModal" href="status_pesanan.php?kode_pesanan=<?= $kode_pesanan; ?>" class="btn btn-success"><?= ucwords($pesanan['status_pesanan']); ?></a>
                    <?php elseif ($pesanan['status_pesanan'] == 'selesai'): ?>
                      <a data-toggle="modal" data-target="#statusPesananModal" href="status_pesanan.php?kode_pesanan=<?= $kode_pesanan; ?>" class="btn btn-primary"><?= ucwords($pesanan['status_pesanan']); ?></a>
                    <?php endif ?>
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
        <?php endif ?>
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

  <div class="modal fade" id="statusPesananModal" tabindex="-1" aria-labelledby="statusPesananLabelModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="statusPesananLabelModal">Status Pesanan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row justify-content-between">
            <div class="col-12 my-3 text-center">
              <a class="btn <?= ($pesanan['status_pesanan'] == 'proses') ? "btn-danger" : "btn-secondary"; ?>">
                <?= ucwords('Proses'); ?>
              </a>
            </div>
            <div class="col-12 my-3 text-center">
              <a class="btn <?= ($pesanan['status_pesanan'] == 'dibuat') ? "btn-warning" : "btn-secondary"; ?>">
                <?= ucwords('Dibuat'); ?>
              </a>
            </div>
            <div class="col-12 my-3 text-center">
              <a class="btn <?= ($pesanan['status_pesanan'] == 'perjalanan') ? "btn-success" : "btn-secondary"; ?>">
                <?= ucwords('Perjalanan'); ?>
              </a>
            </div>
            <div class="col-12 my-3 text-center">
              <a class="btn <?= ($pesanan['status_pesanan'] == 'success') ? "btn-primary" : "btn-secondary"; ?>">
                <?= ucwords('Selesai'); ?>
              </a>
            </div>

          </div>
        </div>
        <div class="modal-footer">
          <a href="status_pesanan.php?kode_pesanan=<?= $kode_pesanan; ?>" class="btn btn-primary">Refresh</a>
        </div>
      </div>
    </div>
  </div>

 <?php include 'script.php' ?>
 <script>
    function copyContent() {
      var contentElement = document.getElementById("kodePesanan");
      
      var range = document.createRange();
      range.selectNode(contentElement);
      
      var selection = window.getSelection();
      selection.removeAllRanges();
      selection.addRange(range);
      
      document.execCommand("copy");
      
      selection.removeAllRanges();

      Swal.fire(
        'Berhasil!',
        'Kode Pesanan berhasil disalin!',
        'success'
      )
    }
 </script>
</body>
</html>