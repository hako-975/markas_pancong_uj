<?php 
	session_start();
	date_default_timezone_set("Asia/Jakarta");
	$host = "localhost";
	$user = "root";
	$pass = "";
	$database = "markas_pancong_uj";

	$koneksi = mysqli_connect($host, $user, $pass, $database);

	// if ($koneksi) {
	// 	echo "koneksi berhasil";
	// }
?>