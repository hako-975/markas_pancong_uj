<?php 
  require_once 'koneksi.php';
  $menu_makanan = mysqli_query($koneksi, "SELECT * FROM menu WHERE jenis_menu = 'makanan'");
  $menu_minuman = mysqli_query($koneksi, "SELECT * FROM menu WHERE jenis_menu = 'minuman'");

 ?>

<!DOCTYPE html>
<html lang="en" id="home">

<head>
  <title>Markas Pancong UJ</title>
  <?php include 'head.php' ?>
</head>
<body class="bg-black">
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-black">
    <div class="container">
      <a class="navbar-brand" href="index.php"><img src="img/logo.png" alt="logo"><span>Markas Pancong UJ</span></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link btn btn-warning btn-pancong m-1" href="#menu"><i class="fas fa-fw fa-concierge-bell"></i> Menu</a>
          </li>
          <li class="nav-item">
            <a class="nav-link btn btn-warning btn-pancong m-1" href="pesan.php"><i class="fas fa-fw fa-shopping-cart"></i> Pesan Sekarang!</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="container mt-5 pt-3"></div>
  <div class="jumbotron text-white font-weight-bolder bg-black mt-5">
    <a class="btn btn-warning btn-lg btn-pancong mt-5" href="pesan.php" role="button"><i class="fas fa-fw fa-shopping-cart"></i> Pesan Sekarang!</a>
  </div>

  <section id="menu" class="bg-black py-5">
    <div class="container">
      <div class="row mb-3 text-center text-pancong">
        <div class="col">
          <h2>Menu</h2>
        </div>
      </div>
      <div class="row">
        <div class="col">
            <ul style="border-bottom: none;" class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link active bg-black text-pancong border-pancong" id="makanan-tab" data-toggle="tab" data-target="#makanan" type="button" role="tab" aria-controls="makanan" aria-selected="true"><i class="fas fa-fw fa-hamburger"></i> Makanan</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link bg-black text-pancong border-pancong" id="minuman-tab" data-toggle="tab" data-target="#minuman" type="button" role="tab" aria-controls="minuman" aria-selected="false"><i class="fas fa-fw fa-coffee"></i> minuman</button>
              </li>
            </ul>
            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show active" id="makanan" role="tabpanel" aria-labelledby="makanan-tab">
                <div class="row">
                  <?php foreach ($menu_makanan as $dmm): ?>
                    <div class="col-lg-4 my-2">
                      <a href="pesan.php" class="text-decoration-none text-dark">
                        <div class="card card-menu border-pancong bg-black text-pancong">
                          <div class="card-image-container">
                            <img src="img/menu/<?= $dmm['foto_menu']; ?>" class="card-img-top" alt="<?= $dmm['foto_menu']; ?>">
                          </div>
                          <div class="card-body">
                            <h5 class="card-title"><?= $dmm['nama_menu']; ?></h5>
                            <p class="card-text">Rp. <?= str_replace(",", ".", number_format($dmm['harga_menu'])); ?></p>
                          </div>
                        </div>
                      </a>
                    </div>
                  <?php endforeach ?>
                </div>
              </div>
              <div class="tab-pane fade" id="minuman" role="tabpanel" aria-labelledby="minuman-tab">
                <div class="row">
                    <?php foreach ($menu_minuman as $dmm): ?>
                      <div class="col-lg-4 my-2">
                        <a href="pesan.php" class="text-decoration-none text-dark">
                          <div class="card card-menu border-pancong bg-black text-pancong">
                            <div class="card-image-container">
                              <img src="img/menu/<?= $dmm['foto_menu']; ?>" class="card-img-top" alt="<?= $dmm['foto_menu']; ?>">
                            </div>
                            <div class="card-body">
                              <h5 class="card-title"><?= $dmm['nama_menu']; ?></h5>
                              <p class="card-text">Rp. <?= str_replace(",", ".", number_format($dmm['harga_menu'])); ?></p>
                            </div>
                          </div>
                        </a>
                      </div>
                    <?php endforeach ?>
                </div>
              </div>
            </div>
        </div>
      </div>  
    </div>
  </section>
  <footer class="sticky-footer bg-black">
    <div class="container my-auto">
      <div class="row mt-3 mb-5 text-pancong justify-content-between">
        <div class="col-lg-3 col-md-6">
          <h5>Markas Pancong UJ</h5>
          <p>Kantin Cemara No.49 <br> Depan kampus Universitas Pamulang Victor</p>
        </div>
        <div class="col-lg-3 col-md-6">
          <h5>Sosial Media</h5>
          <a class="btn btn-warning btn-pancong p-2" href="https://www.youtube.com/@mapaufamily600" target="_blank"><i class="fab fa-fw fa-youtube"></i></a>
          <a class="btn btn-warning btn-pancong p-2" href="https://www.instagram.com/markaspanconguj/" target="_blank"><i class="fab fa-fw fa-instagram"></i></a>
        </div>
      </div>
      <div class="copyright text-center my-auto text-pancong">
        <span>Copyright &copy; Markas Pancong UJ 2023</span>
      </div>
    </div>
  </footer>
  <?php include 'script.php' ?>
    
</body>
</html>