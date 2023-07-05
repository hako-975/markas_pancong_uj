<nav class="navbar navbar-expand-lg navbar-dark bg-black">
  <div class="container justify-content-between">
    <a class="navbar-brand" href="index.php"><img src="img/logo.png" alt="logo"><span>Markas Pancong UJ</span></a>
    <?php if (isset($_SESSION['id_user'])): ?>
      <div class="d-flex flex-row">
        <a class="nav-link btn btn-warning btn-pancong text-center text-white m-1" href="pesan.php"><i class="fas fa-fw fa-shopping-cart"></i> Buat Pesanan</a>
        <a class="nav-link btn btn-warning btn-pancong text-center text-white m-1" href="pelanggan.php"><i class="fas fa-fw fa-check"></i> Pesanan Saya</a>
      </div>
    <?php else: ?>
      <div class="d-flex flex-row">
        <a class="nav-link btn btn-warning btn-pancong text-center text-white m-1" href="pesan.php"><i class="fas fa-fw fa-shopping-cart"></i> Pesan</a>
        <a class="nav-link btn btn-warning btn-pancong text-center text-white m-1" href="login.php"><i class="fas fa-fw fa-sign-in-alt"></i> Login</a>
        <a class="nav-link btn btn-warning btn-pancong text-center text-white m-1" href="registrasi.php"><i class="fas fa-fw fa-edit"></i> Registrasi</a>
      </div>
    <?php endif ?>
  </div>
</nav>