<?php 
	require_once 'koneksi.php';

	if (isset($_GET['counter'])) {
		$data = mysqli_query($koneksi, "SELECT * FROM pesanan INNER JOIN user ON pesanan.id_user = user.id_user WHERE status_notif = '0'");
		echo mysqli_num_rows($data);
	}

	if (isset($_GET['content-notif'])) {
		$data = mysqli_query($koneksi, "SELECT * FROM pesanan INNER JOIN user ON pesanan.id_user = user.id_user WHERE status_notif = '0' || status_pesanan = 'proses' ORDER BY tanggal_pesanan ASC");
		if (mysqli_num_rows($data) > 0) {
			foreach ($data as $d) {
				$kode_pesanan = $d['kode_pesanan'];
	            $detail_pesanan = mysqli_query($koneksi, "SELECT * FROM detail_pesanan INNER JOIN menu ON detail_pesanan.id_menu = menu.id_menu WHERE kode_pesanan = '$kode_pesanan'");
				echo '
					<a class="dropdown-item align-items-center" href="detail_pesanan.php?kode_pesanan='.$kode_pesanan.'">';
				?>
						<h6 class="font-weight-bold">Pesanan kak <?= $d['nama_lengkap']; ?></h6>
						<ul class="mb-2">
						<?php foreach ($detail_pesanan as $ddp): ?>
		                    <li style="margin-left: -20px;">
			                    <span class="font-weight-bold my-0 py-0"><?= $ddp['nama_menu']; ?> - <?= $ddp['jumlah']; ?></span>
		                    </li>
		                <?php endforeach ?>
		            	</ul>
		                <div class="small text-gray-500"><?= $d["tanggal_pesanan"]; ?></div>
	                </a>
	            <?php
			}
		}
		else
		{
			echo '
				<a class="dropdown-item" href="pesanan.php">
				    <span>Belum ada pesanan terbaru</span>
				</a>
			';
		}
	}
 ?>