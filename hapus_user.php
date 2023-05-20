<?php 
	require 'koneksi.php';

	if (!isset($_SESSION['id_user'])) {
	    header("Location: login.php");
	    exit;
	}

	$id_user = $_GET['id_user'];

    $check_username = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'");
    if (mysqli_fetch_assoc($check_username)['username'] == 'admin') {
        setAlert("Perhatian!", "User admin tidak dapat dihapus!", "error");
        header("Location: user.php");
        exit;
    }

	$delete_user = mysqli_query($koneksi, "DELETE FROM user WHERE id_user = '$id_user'");

	if ($delete_user) {
        $tgl_riwayat = date('Y-m-d H:i:s');
		
        mysqli_query($koneksi, "INSERT INTO riwayat VALUES ('', 'User Berhasil dihapus!', '$tgl_riwayat', '$id_user')");
		
        setAlert("Berhasil!", "User Berhasil dihapus!", "success");
        header("Location: user.php");
        exit;
	} 
	else 
	{
        setAlert("Perhatian!", "User Gagal dihapus!", "error");
        header("Location: user.php");
        exit;
	}