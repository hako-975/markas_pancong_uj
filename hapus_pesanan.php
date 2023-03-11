<?php 
	require 'koneksi.php';

	if (!isset($_SESSION['id_user'])) {
	    header("Location: login.php");
	    exit;
	}

	$id_pesanan = $_GET['id_pesanan'];

	$delete_pesanan = mysqli_query($koneksi, "DELETE FROM pesanan WHERE id_pesanan = '$id_pesanan'");

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