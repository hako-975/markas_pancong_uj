<?php 
	require 'koneksi.php';

	if (!isset($_SESSION['id_user'])) {
	    header("Location: login.php");
	    exit;
	}

    $id_user = $_SESSION['id_user'];

	$kode_pesanan = $_GET['kode_pesanan'];
	$status = $_GET['status'];

	$update_status = mysqli_query($koneksi, "UPDATE pesanan SET status_pesanan = '$status', id_user = '$id_user' WHERE kode_pesanan = '$kode_pesanan'");

	if ($update_status) {
		setAlert("Berhasil!", "Status Pesanan Berhasil diubah!", "success");
		header("Location: detail_pesanan.php?kode_pesanan=$kode_pesanan");
        exit;
	} 
	else 
	{
		setAlert("Perhatian!", "Status Pesanan Gagal diubah!", "error");
		header("Location: detail_pesanan.php?kode_pesanan=$kode_pesanan");
        exit;
	}