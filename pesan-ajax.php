<?php 
require 'koneksi.php';
$keyword = $_GET['keyword'];
if ($keyword != '') {
  $menu_makanan = mysqli_query($koneksi, "SELECT * FROM menu WHERE jenis_menu = 'makanan' AND nama_menu LIKE '%$keyword%'");
  $menu_minuman = mysqli_query($koneksi, "SELECT * FROM menu WHERE jenis_menu = 'minuman' AND nama_menu LIKE '%$keyword%'");
} else {
  $menu_makanan = mysqli_query($koneksi, "SELECT * FROM menu WHERE jenis_menu = 'makanan'");
  $menu_minuman = mysqli_query($koneksi, "SELECT * FROM menu WHERE jenis_menu = 'minuman'");
}
?>
<div class="row">
  <div class="col">
    <h3 class="text-center text-pancong mb-3">Makanan</h3>
    <div class="row">
      <?php foreach ($menu_makanan as $dmm): ?>
        <div class="col-lg-3 my-2">
          <div class="card border-pancong bg-black text-pancong">
            <div class="card-image-container">
              <img src="img/menu/<?= $dmm['foto_menu']; ?>" class="card-img-top" alt="<?= $dmm['foto_menu']; ?>">
            </div>
            <div class="card-body">
              <h5 class="card-title"><?= $dmm['nama_menu']; ?></h5>
              <p class="card-text">Rp. <?= str_replace(",", ".", number_format($dmm['harga_menu'])); ?></p>
              <input type="hidden" name="id_menu[]" value="<?= $dmm['id_menu']; ?>">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text bg-black text-pancong border-pancong">Jumlah</span>
                </div>
                <input type="number" class="form-control bg-black border-pancong text-pancong" value="0" min="0" name="jml_menu[]">
              </div>
            </div>
          </div>
        </div>
      <?php endforeach ?>
    </div>
  </div>
</div>
<hr>
<div class="row">
  <div class="col">
    <h3 class="text-center text-pancong mb-3">Minuman</h3>
    <div class="row">
      <?php foreach ($menu_minuman as $dmm): ?>
        <div class="col-lg-3 my-2">
          <div class="card border-pancong bg-black text-pancong">
            <div class="card-image-container">
              <img src="img/menu/<?= $dmm['foto_menu']; ?>" class="card-img-top" alt="<?= $dmm['foto_menu']; ?>">
            </div>
            <div class="card-body">
              <h5 class="card-title"><?= $dmm['nama_menu']; ?></h5>
              <p class="card-text">Rp. <?= str_replace(",", ".", number_format($dmm['harga_menu'])); ?></p>
              <input type="hidden" name="id_menu[]" value="<?= $dmm['id_menu']; ?>">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text bg-black text-pancong border-pancong">Jumlah</span>
                </div>
                <input type="number" class="form-control bg-black border-pancong text-pancong" value="0" min="0" name="jml_menu[]">
              </div>
            </div>
          </div>
        </div>
      <?php endforeach ?>
    </div>
  </div>
</div>