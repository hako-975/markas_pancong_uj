<?php 
	require 'koneksi.php';

	if (!isset($_SESSION['id_user'])) {
	    header("Location: login.php");
	    exit;
	}

    $id_user = $_SESSION['id_user'];

	$id_pesanan = $_GET['id_pesanan'];
	$status = $_GET['status'];

	$update_status = mysqli_query($koneksi, "UPDATE pesanan SET status_pesanan = '$status', id_user = '$id_user' WHERE id_pesanan = '$id_pesanan'");

	if ($update_status) {
		echo "
            <script>
                alert('Status Pesanan Berhasil diubah!')
                window.location='detail_pesanan.php?id_pesanan=$id_pesanan'
            </script>
        ";
        exit;
	} 
	else 
	{
	   echo "
            <script>
                alert('Status Pesanan Gagal diubah!')
                window.location='detail_pesanan.php?id_pesanan=$id_pesanan'
            </script>
        ";
        exit;
	}