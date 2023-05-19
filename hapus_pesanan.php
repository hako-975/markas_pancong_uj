<?php 
	require 'koneksi.php';

	if (!isset($_SESSION['id_user'])) {
	    header("Location: login.php");
	    exit;
	}

	$kode_pesanan = $_GET['kode_pesanan'];


	$delete_detail_pesanan = mysqli_query($koneksi, "DELETE FROM detail_pesanan WHERE detail_pesanan.kode_pesanan = '$kode_pesanan'");
	$delete_pesanan = mysqli_query($koneksi, "DELETE FROM pesanan WHERE kode_pesanan = '$kode_pesanan'");

	if ($delete_pesanan) {
		echo "
            <script>
                alert('Pesanan Berhasil dihapus!')
                window.location='pesanan.php'
            </script>
        ";
        exit;
	} 
	else 
	{
	   echo "
            <script>
                alert('Pesanan Gagal dihapus!')
                window.location='pesanan.php'
            </script>
        ";
        exit;
	}