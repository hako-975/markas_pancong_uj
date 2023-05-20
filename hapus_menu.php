<?php 
	require 'koneksi.php';

	if (!isset($_SESSION['id_user'])) {
	    header("Location: login.php");
	    exit;
	}

	$id_menu = $_GET['id_menu'];

    $dataMenu = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM menu WHERE id_menu = '$id_menu'"));
    $image_path = 'img/menu/' . $dataMenu['foto_menu'];
    
    if (file_exists($image_path)) {
    	unlink($image_path);
    }

	$delete_menu = mysqli_query($koneksi, "DELETE FROM menu WHERE id_menu = '$id_menu'");

	if ($delete_menu) {
		setAlert("Berhasil!", "Menu Berhasil dihapus!", "success");
		header("Location: menu.php");
        exit;
	} 
	else 
	{
		setAlert("Perhatian!", "Menu Gagal dihapus!", "error");
		header("Location: menu.php");
        exit;
	}