<?php 
	require 'koneksi.php';

	if (!isset($_SESSION['id_user'])) {
	    header("Location: login.php");
	    exit;
	}

	$id_user = $_GET['id_user'];

    $check_username = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'");
    if (mysqli_fetch_assoc($check_username)['username'] == 'admin') {
    	echo "
            <script>
                alert('User admin tidak dapat dihapus!')
                window.location='user.php'
            </script>
        ";
        exit;
    }

	$delete_user = mysqli_query($koneksi, "DELETE FROM user WHERE id_user = '$id_user'");

	if ($delete_user) {
		echo "
            <script>
                alert('User Berhasil dihapus!')
                window.location='user.php'
            </script>
        ";
        exit;
	} 
	else 
	{
	   echo "
            <script>
                alert('User Gagal dihapus!')
                window.location='user.php'
            </script>
        ";
        exit;
	}