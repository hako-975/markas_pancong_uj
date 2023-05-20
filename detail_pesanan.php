<?php 
    require_once 'koneksi.php';
    
    if (!isset($_SESSION['id_user'])) {
        header("Location: login.php");
        exit;
    }

    $id_user = $_SESSION['id_user'];
    
    if (!$dataUser = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"))) {
        header("Location: logout.php");
        exit;
    }

    $kode_pesanan = $_GET['kode_pesanan'];


    if (isset($_POST['btnTambahDetailPesanan'])) {
        $id_menu = htmlspecialchars($_POST['id_menu']);
        
        if($id_menu == '0')
        {
            setAlert("Perhatian!", "Pilih menu terlebih dahulu!", "error");
            echo "
                <script>
                    window.history.back();
                </script>
            ";
            exit;
        }

        $jumlah = htmlspecialchars($_POST['jumlah']);
        $dataMenu = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM menu WHERE id_menu = '$id_menu'"));
        $harga_menu = $dataMenu['harga_menu']; 
        $subtotal = $jumlah * $harga_menu;


        $insert_detail_pesanan = mysqli_query($koneksi, "INSERT INTO detail_pesanan (id_menu, jumlah, subtotal, kode_pesanan) VALUES ('$id_menu', '$jumlah', '$subtotal', '$kode_pesanan')");

        $total_pembayaran = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(subtotal) as total_pembayaran FROM detail_pesanan WHERE kode_pesanan = '$kode_pesanan'"))['total_pembayaran'];
        mysqli_query($koneksi, "UPDATE pesanan SET total_pembayaran = '$total_pembayaran'");

        if ($insert_detail_pesanan) {
            setAlert("Berhasil!", "Menu Pesanan berhasil ditambahkan!", "success");
            header("Location: detail_pesanan.php?kode_pesanan=$kode_pesanan");
            exit;
        }
        else
        {
            setAlert("Perhatian!", "Menu Pesanan Gagal ditambahkan!", "error");
            echo "
                <script>
                    window.history.back();
                </script>
            ";
            exit;
        }
    }

    if (isset($_POST['btnUbahDetailPesanan'])) {
        $id_detail_pesanan = htmlspecialchars($_POST['id_detail_pesanan']);
        $id_menu = htmlspecialchars($_POST['id_menu']);
        
        if($id_menu == '0')
        {
            setAlert("Perhatian!", "Pilih menu terlebih dahulu!", "error");
            echo "
                <script>
                    window.history.back();
                </script>
            ";
            exit;
        }

        $jumlah = htmlspecialchars($_POST['jumlah']);
        $dataMenu = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM menu WHERE id_menu = '$id_menu'"));
        $harga_menu = $dataMenu['harga_menu']; 
        $subtotal = $jumlah * $harga_menu;

        $update_detail_pesanan = mysqli_query($koneksi, "UPDATE detail_pesanan SET id_menu = '$id_menu', jumlah = '$jumlah', subtotal = '$subtotal', kode_pesanan = '$kode_pesanan' WHERE id_detail_pesanan = '$id_detail_pesanan'");
        $total_pembayaran = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(subtotal) as total_pembayaran FROM detail_pesanan WHERE kode_pesanan = '$kode_pesanan'"))['total_pembayaran'];
        mysqli_query($koneksi, "UPDATE pesanan SET total_pembayaran = '$total_pembayaran'");
        if ($update_detail_pesanan) {
            setAlert("Berhasil!", "Menu Pesanan berhasil diubah!", "success");
            header("Location: detail_pesanan.php?kode_pesanan=$kode_pesanan");
            exit;
        }
        else
        {
            setAlert("Perhatian!", "Menu Pesanan Gagal diubah!", "error");
            echo "
                <script>
                    window.history.back();
                </script>
            ";
            exit;
        }
    }

    $dataPesanan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM pesanan WHERE kode_pesanan = '$kode_pesanan'"));

    $detail_pesanan = mysqli_query($koneksi, "SELECT * FROM detail_pesanan INNER JOIN menu ON detail_pesanan.id_menu = menu.id_menu INNER JOIN pesanan ON detail_pesanan.kode_pesanan = pesanan.kode_pesanan WHERE detail_pesanan.kode_pesanan = '$kode_pesanan'");
    $menu = mysqli_query($koneksi, "SELECT * FROM menu");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Detail Pesanan - <?= $dataPesanan['nama_pemesan']; ?></title>

    <?php include 'head.php'; ?>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include 'sidebar.php'; ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include 'topbar.php'; ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="row my-2">
                        <div class="col">
                            <a href="pesanan.php" class="btn btn-primary"><i class="fas fa-fw fa-arrow-left"></i> Data Pesanan</a>
                        </div>
                    </div>

                    <!-- Page Heading -->
                    <div class="align-items-center justify-content-between mb-4">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <div class="row">
                                    <div class="col head-left">
                                        <h6 class="mt-2 font-weight-bold text-primary">Detail Pesanan - <?= $dataPesanan['nama_pemesan']; ?></h6>
                                    </div>
                                    <div class="col head-right">
                                        <button type="button" class="btn btn-sm btn-primary"  data-toggle="modal" data-target="#tambahDetailPesananModal"><i class="fas fa-fw fa-plus"></i> Tambah Menu</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-4">
                                        <h5 class="btn btn-success">Total Pembayaran: Rp. <?= str_replace(",", ".", number_format($dataPesanan['total_pembayaran'])); ?></h5>
                                    </div>
                                    <div class="col">
                                        <div class="row mb-2">
                                            <?php 
                                                $status = $dataPesanan['status_pesanan'];
                                                switch ($status) {
                                                    case 'proses':
                                                        $prosesClass = 'bg-danger';
                                                        $dibuatClass = 'bg-dark';
                                                        $perjalananClass = 'bg-dark';
                                                        $selesaiClass = 'bg-dark';
                                                        break;
                                                    case 'dibuat':
                                                        $prosesClass = 'bg-dark';
                                                        $dibuatClass = 'bg-warning';
                                                        $perjalananClass = 'bg-dark';
                                                        $selesaiClass = 'bg-dark';
                                                        break;
                                                    case 'perjalanan':
                                                        $prosesClass = 'bg-dark';
                                                        $dibuatClass = 'bg-dark';
                                                        $perjalananClass = 'bg-success';
                                                        $selesaiClass = 'bg-dark';
                                                        break;
                                                    case 'selesai':
                                                        $prosesClass = 'bg-dark';
                                                        $dibuatClass = 'bg-dark';
                                                        $perjalananClass = 'bg-dark';
                                                        $selesaiClass = 'bg-primary';
                                                        break;
                                                    default:
                                                        $prosesClass = 'bg-dark';
                                                        $dibuatClass = 'bg-dark';
                                                        $perjalananClass = 'bg-dark';
                                                        $selesaiClass = 'bg-dark';
                                                }
                                            ?>
                                            <a href="ubah_status.php?kode_pesanan=<?= $kode_pesanan; ?>&status=proses" onclick="return confirm('Apakah Anda yakin ingin mengubah status menjadi proses?')" class="col-2 text-center text-decoration-none text-white rounded p-2 m-auto <?php echo $prosesClass; ?>">Proses</a>
                                            <a href="ubah_status.php?kode_pesanan=<?= $kode_pesanan; ?>&status=dibuat" onclick="return confirm('Apakah Anda yakin ingin mengubah status menjadi dibuat?')" class="col-2 text-center text-decoration-none text-white rounded p-2 m-auto <?php echo $dibuatClass; ?>">Dibuat</a>
                                            <a href="ubah_status.php?kode_pesanan=<?= $kode_pesanan; ?>&status=perjalanan" onclick="return confirm('Apakah Anda yakin ingin mengubah status menjadi perjalanan?')" class="col-2 text-center text-decoration-none text-white rounded p-2 m-auto <?php echo $perjalananClass; ?>">Perjalanan</a>
                                            <a href="ubah_status.php?kode_pesanan=<?= $kode_pesanan; ?>&status=selesai" onclick="return confirm('Apakah Anda yakin ingin mengubah status menjadi selesai?')" class="col-2 text-center text-decoration-none text-white rounded p-2 m-auto <?php echo $selesaiClass; ?>">Selesai</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" cellspacing="0">
                                        <thead>
                                            <tr class="text-center">
                                                <th>No.</th>
                                                <th>Nama Menu</th>
                                                <th>Harga</th>
                                                <th>Jumlah</th>
                                                <th>Subtotal</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            <?php foreach ($detail_pesanan as $dp): ?>
                                                <tr>
                                                    <td class="align-middle"><?= $i++; ?></td>
                                                    <td class="align-middle"><?= $dp['nama_menu']; ?></td>
                                                    <td class="align-middle">Rp. <?= str_replace(",", ".", number_format($dp['harga_menu'])); ?></td>
                                                    <td class="align-middle"><?= $dp['jumlah']; ?></td>
                                                    <td class="align-middle">Rp. <?= str_replace(",", ".", number_format($dp['subtotal'])); ?></td>
                                                    <td class="text-center align-middle">
                                                        <a class="btn btn-sm btn-warning text-white m-1" data-toggle="modal" data-target="#ubahDetailPesananModal<?= $dp['id_detail_pesanan']; ?>"><i class="fas fa-fw fa-edit"></i> Ubah</a>
                                                        <a class="btn btn-sm btn-danger text-white m-1" href="hapus_detail_pesanan.php?id_detail_pesanan=<?= $dp['id_detail_pesanan']; ?>&kode_pesanan=<?= $kode_pesanan; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus menu pesanan <?= $dp['nama_menu']; ?>?')"><i class="fas fa-fw fa-trash"></i> Hapus</a>
                                                        
                                                        <div class="modal fade" id="ubahDetailPesananModal<?= $dp['id_detail_pesanan']; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="ubahPesananModalLabel<?= $dp['id_detail_pesanan']; ?>" aria-hidden="true">
                                                          <div class="modal-dialog modal-lg text-left">
                                                            <form method="post" enctype="multipart/form-data">
                                                                <input type="hidden" name="id_detail_pesanan" value="<?= $dp['id_detail_pesanan']; ?>">
                                                                <div class="modal-content">
                                                                  <div class="modal-header">
                                                                    <h5 class="modal-title" id="ubahPesananModalLabel<?= $dp['id_detail_pesanan']; ?>"><i class="fas fa-fw fa-edit"></i> Ubah Pesanan - <?= $dp['nama_pemesan']; ?></h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                      <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                  </div>
                                                                  <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col">
                                                                            <div class="form-group">
                                                                                <label for="id_menu-<?= $dp['id_detail_pesanan']; ?>">Nama Menu</label>
                                                                                <select name="id_menu" id="id_menu-<?= $dp['id_detail_pesanan']; ?>" class="custom-select">
                                                                                    <option value="<?= $dp['id_menu']; ?>"><?= $dp['nama_menu']; ?></option>
                                                                                    <?php foreach ($menu as $dm): ?>
                                                                                        <?php if ($dp['id_menu'] != $dm['id_menu']): ?>
                                                                                            <option value="<?= $dm['id_menu']; ?>"><?= $dm['nama_menu']; ?></option>
                                                                                        <?php endif ?>
                                                                                    <?php endforeach ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-2">
                                                                            <div class="form-group">
                                                                                <label for="harga_menu-<?= $dp['id_detail_pesanan']; ?>">Harga Menu</label>
                                                                                <input type="text" disabled class="not-allowed form-control" id="harga_menu-<?= $dp['id_detail_pesanan']; ?>" name="harga_menu" value="<?= str_replace(",", ".", number_format($dp['harga_menu'])); ?>">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-2">
                                                                            <div class="form-group">
                                                                                <label for="jumlah-<?= $dp['id_detail_pesanan']; ?>">Jumlah</label>
                                                                                <input type="number" name="jumlah" id="jumlah-<?= $dp['id_detail_pesanan']; ?>" class="form-control" required min="1" max="10" value="<?= str_replace(",", ".", number_format($dp['jumlah'])); ?>">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-2">
                                                                            <div class="form-group">
                                                                                <label for="subtotal-<?= $dp['id_detail_pesanan']; ?>">Subtotal</label>
                                                                                <input type="text" disabled class="not-allowed form-control" id="subtotal-<?= $dp['id_detail_pesanan']; ?>" name="subtotal" value="<?= str_replace(",", ".", number_format($dp['subtotal'])); ?>">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                  </div>
                                                                  <div class="modal-footer">
                                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-fw fa-times"></i> Batal</button>
                                                                    <button type="submit" name="btnUbahDetailPesanan" class="btn btn-primary"><i class="fas fa-fw fa-save"></i> Ubah</button>
                                                                  </div>
                                                                </div>
                                                            </form>
                                                          </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <script src="vendor/jquery/jquery.min.js"></script>
                                                <script>
                                                    $(document).ready(function() {
                                                        // Get the id_menu, harga_menu, jumlah, and subtotal elements
                                                        var id_menu = $('#id_menu-<?= $dp['id_detail_pesanan']; ?>');
                                                        var harga_menu = $('#harga_menu-<?= $dp['id_detail_pesanan']; ?>');
                                                        var jumlah = $('#jumlah-<?= $dp['id_detail_pesanan']; ?>');
                                                        var subtotal = $('#subtotal-<?= $dp['id_detail_pesanan']; ?>');

                                                        // Listen for changes to the id_menu or jumlah inputs
                                                        id_menu.add(jumlah).on('change', function() {
                                                            // Get the selected harga_menu based on the selected id_menu
                                                            var selected_id_menu = id_menu.val();
                                                            var selected_harga_menu = 0;
                                                            <?php foreach ($menu as $dm): ?>
                                                                if (selected_id_menu == <?= $dm['id_menu']; ?>) {
                                                                    selected_harga_menu = <?= $dm['harga_menu']; ?>;
                                                                }
                                                            <?php endforeach ?>

                                                            var formatted_harga_menu = selected_harga_menu.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                                                            // Update the harga_menu input field with the formatted harga_menu value
                                                            harga_menu.val(formatted_harga_menu);

                                                            // Calculate the subtotal based on the harga_menu and jumlah inputs
                                                            var current_subtotal = selected_harga_menu * jumlah.val();
                                                            // Format the subtotal with dot separators and add the 'Rp.' prefix
                                                            var formatted_subtotal = current_subtotal.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                                                            // Update the subtotal input field with the formatted subtotal value
                                                            subtotal.val(formatted_subtotal);
                                                        });
                                                    });
                                                </script>
                                            <?php endforeach ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include 'footer.php'; ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Tambah Pesanan Modal -->
    <div class="modal fade" id="tambahDetailPesananModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="tambahDetailPesananModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <form method="post" enctype="multipart/form-data">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="tambahDetailPesananModalLabel"><i class="fas fa-fw fa-plus"></i> Tambah Pesanan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <h5>Data Menu</h5>
                <div class="row justify-content-center">
                    <div class="col">
                        <div class="form-group">
                            <label for="id_menu">Nama Menu</label>
                            <select name="id_menu" id="id_menu" class="custom-select">
                                <option value="0">--- Pilih Menu ---</option>
                                <?php foreach ($menu as $dm): ?>
                                    <option value="<?= $dm['id_menu']; ?>"><?= $dm['nama_menu']; ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="harga_menu">Harga Menu</label>
                            <input type="text" disabled class="not-allowed form-control" id="harga_menu" name="harga_menu">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="jumlah">Jumlah</label>
                            <input type="number" name="jumlah" id="jumlah" class="form-control" required min="1" max="10" value="1">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="subtotal">Subtotal</label>
                            <input type="text" disabled class="not-allowed form-control" id="subtotal" name="subtotal">
                        </div>
                    </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-fw fa-times"></i> Batal</button>
                <button type="submit" name="btnTambahDetailPesanan" class="btn btn-primary"><i class="fas fa-fw fa-save"></i> Simpan</button>
              </div>
            </div>
        </form>
      </div>
    </div>


    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


    <?php include 'script.php'; ?>
    <script>
        $(document).ready(function() {
            // Get the id_menu, harga_menu, jumlah, and subtotal elements
            var id_menu = $('#id_menu');
            var harga_menu = $('#harga_menu');
            var jumlah = $('#jumlah');
            var subtotal = $('#subtotal');

            // Listen for changes to the id_menu or jumlah inputs
            id_menu.add(jumlah).on('change', function() {
                // Get the selected harga_menu based on the selected id_menu
                var selected_id_menu = id_menu.val();
                var selected_harga_menu = 0;
                <?php foreach ($menu as $dm): ?>
                    if (selected_id_menu == <?= $dm['id_menu']; ?>) {
                        selected_harga_menu = <?= $dm['harga_menu']; ?>;
                    }
                <?php endforeach ?>

                // Format the harga_menu with dot separators and add the 'Rp.' prefix
                var formatted_harga_menu = selected_harga_menu.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                // Update the harga_menu input field with the formatted harga_menu value
                harga_menu.val(formatted_harga_menu);

                // Calculate the subtotal based on the harga_menu and jumlah inputs
                var current_subtotal = selected_harga_menu * jumlah.val();
                // Format the subtotal with dot separators and add the 'Rp.' prefix
                var formatted_subtotal = current_subtotal.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                // Update the subtotal input field with the formatted subtotal value
                subtotal.val(formatted_subtotal);
            });
        });
    </script>
</body>

</html>