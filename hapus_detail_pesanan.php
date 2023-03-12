<?php 
	require 'koneksi.php';

	if (!isset($_SESSION['id_user'])) {
	    header("Location: login.php");
	    exit;
	}

	$id_pesanan = $_GET['id_pesanan'];
	$id_detail_pesanan = $_GET['id_detail_pesanan'];

	$delete_detail_pesanan = mysqli_query($koneksi, "DELETE FROM detail_pesanan WHERE id_detail_pesanan = '$id_detail_pesanan'");

	$total_pembayaran = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(subtotal) as total_pembayaran FROM detail_pesanan WHERE id_pesanan = '$id_pesanan'"))['total_pembayaran'];
        mysqli_query($koneksi, "UPDATE pesanan SET total_pembayaran = '$total_pembayaran'");

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