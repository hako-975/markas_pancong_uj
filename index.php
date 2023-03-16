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
                <a class="nav-link btn btn-danger text-white m-1" href="#home"><i class="fas fa-fw fa-home"></i> Beranda</a>
              </li>
              <li class="nav-item">
                <a class="nav-link btn btn-danger text-white m-1" href="#menu"><i class="fas fa-fw fa-concierge-bell"></i> Menu</a>
              </li>
              <li class="nav-item">
                <a class="nav-link btn btn-danger text-white m-1" href="pesan.php"><i class="fas fa-fw fa-shopping-cart"></i> Pesan Sekarang!</a>
              </li>
            </ul>
          </div>
        </div>
    </nav>

    <div class="jumbotron text-white font-weight-bolder">
      <h1 class="display-4">Markas Pancong UJ</h1>
      <p class="lead">Lokasi: Pondok Makan Cemara, depan UNPAM Viktor</p>
      <a class="btn btn-danger btn-lg" href="#" role="button"><i class="fas fa-fw fa-shopping-cart"></i> Pesan Sekarang!</a>
    </div>

    <section id="menu">
        <div class="container">
            <div class="row text-center">
                <div class="col">
                    <h2>Menu</h2>
                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                      <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="makanan-tab" data-toggle="tab" data-target="#makanan" type="button" role="tab" aria-controls="makanan" aria-selected="true"><i class="fas fa-fw fa-hamburger"></i> Makanan</button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button class="nav-link" id="minuman-tab" data-toggle="tab" data-target="#minuman" type="button" role="tab" aria-controls="minuman" aria-selected="false"><i class="fas fa-fw fa-coffee"></i> minuman</button>
                      </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                      <div class="tab-pane fade show active" id="makanan" role="tabpanel" aria-labelledby="makanan-tab">
                        <div class="row">
                            <?php foreach ($menu_makanan as $dmm): ?>
                              <div class="col-lg-4">
                                <div class="card">
                                  <img src="img/menu/<?= $dmm['foto_menu']; ?>" class="card-img-top" alt="<?= $dmm['foto_menu']; ?>">
                                  <div class="card-body">
                                    <h5 class="card-title"><?= $dmm['nama_menu']; ?></h5>
                                    <p class="card-text">Rp. <?= str_replace(",", ".", number_format($dmm['harga_menu'])); ?></p>
                                  </div>
                                </div>
                              </div>
                            <?php endforeach ?>
                        </div>

                      </div>
                      <div class="tab-pane fade" id="minuman" role="tabpanel" aria-labelledby="minuman-tab">
                        <div class="row">
                            <?php foreach ($menu_minuman as $dmm): ?>
                              <div class="col-lg-4">
                                <div class="card">
                                  <img src="img/menu/<?= $dmm['foto_menu']; ?>" class="card-img-top" alt="<?= $dmm['foto_menu']; ?>">
                                  <div class="card-body">
                                    <h5 class="card-title"><?= $dmm['nama_menu']; ?></h5>
                                    <p class="card-text">Rp. <?= str_replace(",", ".", number_format($dmm['harga_menu'])); ?></p>
                                  </div>
                                </div>
                              </div>
                            <?php endforeach ?>
                        </div>
                      </div>
                    </div>
                </div>
            </div>  
        </div>
    </section>
    <?php include 'script.php' ?>
    
</body>
</html>