<?php 
	require 'koneksi.php';

	if (!isset($_SESSION['id_user'])) {
	    header("Location: login.php");
	    exit;
	}
	
	$id_user = $_SESSION['id_user'];
	$kode_pesanan = $_GET['kode_pesanan'];
	$id_detail_pesanan = $_GET['id_detail_pesanan'];

	$delete_detail_pesanan = mysqli_query($koneksi, "DELETE FROM detail_pesanan WHERE id_detail_pesanan = '$id_detail_pesanan'");

	$total_pembayaran = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(subtotal) as total_pembayaran FROM detail_pesanan WHERE kode_pesanan = '$kode_pesanan'"))['total_pembayaran'];
        mysqli_query($koneksi, "UPDATE pesanan SET total_pembayaran = '$total_pembayaran'");

	if ($delete_detail_pesanan) {
        $tgl_riwayat = date('Y-m-d H:i:s');
        mysqli_query($koneksi, "INSERT INTO riwayat VALUES ('', 'Menu Pesanan Berhasil dihapus!', '$tgl_riwayat', '$id_user')");

    	setAlert("Berhasil!", "Menu Pesanan Berhasil dihapus!", "success");
		header("Location: detail_pesanan.php?kode_pesanan=$kode_pesanan");
        exit;
	} 
	else 
	{
       	setAlert("Perhatian!", "Menu Pesanan Gagal dihapus!", "error");
		header("Location: detail_pesanan.php?kode_pesanan=$kode_pesanan");
        exit;
	}