<?php 
  require_once 'koneksi.php';
  $menu_makanan = mysqli_query($koneksi, "SELECT * FROM menu WHERE jenis_menu = 'makanan'");
  $menu_minuman = mysqli_query($koneksi, "SELECT * FROM menu WHERE jenis_menu = 'minuman'");

  $menu = mysqli_query($koneksi, "SELECT * FROM menu ORDER BY jenis_menu ASC");

 ?>

<!DOCTYPE html>
<html lang="en" id="home">

<head>
  <title>Pesan - Markas Pancong UJ</title>
  <?php include 'head.php' ?>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-dark">
      <div class="container">
        <a class="navbar-brand" href="index.php"><img src="img/logo.png" alt="logo" width="45"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link btn btn-danger text-white m-1" href="index.php#home"><i class="fas fa-fw fa-home"></i> Beranda</a>
            </li>
            <li class="nav-item">
              <a class="nav-link btn btn-danger text-white m-1" href="index.php#menu"><i class="fas fa-fw fa-concierge-bell"></i> Menu</a>
            </li>
            <li class="nav-item">
              <a class="nav-link btn btn-danger text-white m-1" href="status_pesanan.php"><i class="fas fa-fw fa-check"></i> Cek Status Pesanan</a>
            </li>
          </ul>
        </div>
      </div>
  </nav>

  <section id="menu" class="my-5 pt-5">
    <div class="container">
      <form method="post" action="checkout.php">
        <div class="row text-center">
          <div class="col">
            <h2>Menu</h2>
            <hr>
          </div>
        </div>
        <div class="row">
          <div class="col">
              <h3 class="text-center">Makanan</h3>
              <hr>
              <div class="row">
                <?php foreach ($menu_makanan as $dmm): ?>
                  <div class="col-lg-3 my-2">
                    <div class="card">
                      <img src="img/menu/<?= $dmm['foto_menu']; ?>" class="card-img-top" alt="<?= $dmm['foto_menu']; ?>">
                      <div class="card-body">
                        <h5 class="card-title"><?= $dmm['nama_menu']; ?></h5>
                        <p class="card-text">Rp. <?= str_replace(",", ".", number_format($dmm['harga_menu'])); ?></p>
                        <input type="hidden" name="id_menu[]" value="<?= $dmm['id_menu']; ?>">
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text">Jumlah</span>
                          </div>
                          <input type="number" class="form-control" min="0" name="jml_menu[]">
                        </div>
                      </div>
                    </div>
                  </div>
                <?php endforeach ?>
              </div>
          </div>
        </div>
        <div class="row">
          <div class="col">
              <h3 class="text-center">Minuman</h3>
              <hr>
              <div class="row">
                <?php foreach ($menu_minuman as $dmm): ?>
                  <div class="col-lg-3 my-2">
                    <div class="card">
                      <img src="img/menu/<?= $dmm['foto_menu']; ?>" class="card-img-top" alt="<?= $dmm['foto_menu']; ?>">
                      <div class="card-body">
                        <h5 class="card-title"><?= $dmm['nama_menu']; ?></h5>
                        <p class="card-text">Rp. <?= str_replace(",", ".", number_format($dmm['harga_menu'])); ?></p>
                        <input type="hidden" name="id_menu[]" value="<?= $dmm['id_menu']; ?>">
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text">Jumlah</span>
                          </div>
                          <input type="number" class="form-control" min="0" name="jml_menu[]">
                        </div>
                      </div>
                    </div>
                  </div>
                <?php endforeach ?>
              </div>
          </div>
        </div>
        <button type="submit" name="btnCheckout" class="btn btn-success btn-checkout"><i class="fas fa-fw fa-cart-arrow-down"></i> Checkout</button>
      </form>  
    </div>
  </section>
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