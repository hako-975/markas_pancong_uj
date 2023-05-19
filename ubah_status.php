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
		echo "
            <script>
                alert('Status Pesanan Berhasil diubah!')
                window.location='detail_pesanan.php?kode_pesanan=$kode_pesanan'
            </script>
        ";
        exit;
	} 
	else 
	{
	   echo "
            <script>
                alert('Status Pesanan Gagal diubah!')
                window.location='detail_pesanan.php?kode_pesanan=$kode_pesanan'
            </script>
        ";
        exit;
	}