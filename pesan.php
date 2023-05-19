<?php 
  require_once 'koneksi.php';

  if (isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];
    $menu_makanan = mysqli_query($koneksi, "SELECT * FROM menu WHERE jenis_menu = 'makanan' AND nama_menu LIKE '%$keyword%'");
    $menu_minuman = mysqli_query($koneksi, "SELECT * FROM menu WHERE jenis_menu = 'minuman' AND nama_menu LIKE '%$keyword%'");
  } else {
    $menu_makanan = mysqli_query($koneksi, "SELECT * FROM menu WHERE jenis_menu = 'makanan'");
    $menu_minuman = mysqli_query($koneksi, "SELECT * FROM menu WHERE jenis_menu = 'minuman'");
  }

 ?>

<!DOCTYPE html>
<html lang="en" id="home">

<head>
  <title>Pesan - Markas Pancong UJ</title>
  <?php include 'head.php' ?>
</head>
<body style="background-color: black;">
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-black">
    <div class="container">
      <a class="navbar-brand" href="index.php"><img src="img/logo.png" alt="logo"><span>Markas Pancong UJ</span></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link btn btn-warning btn-pancong text-white m-1" href="status_pesanan.php"><i class="fas fa-fw fa-check"></i> Cek Status Pesanan</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <section id="menu" class="mt-5 pt-5 bg-black">
    <div class="container mt-4">
      <form>
        <h4 class="text-left text-pancong">Cari Menu</h4>
        <div class="input-group mb-3">
          <input type="search" name="keyword" id="keyword" class="form-control" placeholder="Contoh: Pancong Cokelat" aria-label="Contoh: Pancong Cokelat" aria-describedby="button-search" value="<?php isset($_GET['keyword']) ? $_GET['keyword'] : ''; ?>">
        </div>
      </form>
      <form method="post" action="checkout.php">
        <div id="menu-search">
          <div class="row">
            <div class="col">
              <h3 class="text-center text-pancong mb-3">Makanan</h3>
              <div class="row" id="list-makanan">
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
              <div class="row" id="list-minuman">
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
        </div>
        <button type="submit" name="btnCheckout" class="btn btn-warning btn-checkout btn-pancong"><i class="fas fa-fw fa-cart-arrow-down"></i> Checkout</button>
      </form>  
    </div>
  </section>
  <footer class="sticky-footer bg-black">
    <div class="container my-auto">
      <div class="copyright text-center my-auto text-pancong">
        <span>Copyright &copy; Markas Pancong UJ 2023</span>
      </div>
    </div>
  </footer>
  <?php include 'script.php' ?>
  <script>
    $(document).ready(function() {
      
      $(window).keydown(function(event) {
        if( (event.keyCode == 13)) {
          event.preventDefault();
          return false;
        }
      });

      $("#keyword").on("keyup", function() {
        $('#menu-search').load("pesan-ajax.php?keyword=" + $("#keyword").val());
      });
    });
  </script>
</body>
</html>