<?php 
	require 'koneksi.php';

	if (!isset($_SESSION['id_user'])) {
	    header("Location: login.php");
	    exit;
	}

	$id_pesanan = $_GET['id_pesanan'];
	$id_detail_pesanan = $_GET['id_detail_pesanan'];

	$delete_detail_pesanan = mysqli_query($koneksi, "DELETE FROM detail_pesanan WHERE id_detail_pesanan = '$id_detail_pesanan'");

	if ($delete_detail_pesanan) {
		echo "
            <script>
                alert('Menu Pesanan Berhasil dihapus!')
                window.location='detail_pesanan.php?id_pesanan=$id_pesanan'
            </script>
        ";
        exit;
	} 
	else 
	{
	   echo "
            <script>
                alert('Menu Pesanan Gagal dihapus!')
                window.location='detail_pesanan.php?id_pesanan=$id_pesanan'
            </script>
        ";
        exit;
	}