<?php 
	require_once 'koneksi.php';
	$update_status = mysqli_query($koneksi, "UPDATE pesanan SET status_notif = 1 WHERE status_pesanan != 'proses'");
 ?>