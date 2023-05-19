<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/sweetalert2/sweetalert2.all.min.js"></script>

<?php 
	session_start();
	date_default_timezone_set("Asia/Jakarta");
	$host = "localhost";
	$user = "root";
	$pass = "";
	$database = "markas_pancong_uj";

	$koneksi = mysqli_connect($host, $user, $pass, $database);

	function setAlert($title='', $text='', $type='', $buttons='') 
	{
		$_SESSION["alert"]["title"]		= $title;
		$_SESSION["alert"]["text"] 		= $text;
		$_SESSION["alert"]["type"] 		= $type;
		$_SESSION["alert"]["buttons"]	= $buttons; 
	}

	if (isset($_SESSION['alert'])) 
	{
		$title 		= $_SESSION["alert"]["title"];
		$text 		= $_SESSION["alert"]["text"];
		$type 		= $_SESSION["alert"]["type"];
		$buttons	= $_SESSION["alert"]["buttons"];

		echo "
			<div id='msg' data-title='".$title."' data-type='".$type."' data-text='".$text."' data-buttons='".$buttons."'></div>
			<script>
				let title 		= $('#msg').data('title');
				let type 		= $('#msg').data('type');
				let text 		= $('#msg').data('text');
				let buttons		= $('#msg').data('buttons');
				if(text != '' && type != '' && title != '') {
					Swal.fire({
						title: title,
						text: text,
						icon: type,
					});
				}
			</script>
		";
		unset($_SESSION["alert"]);
	}

	function kodePesananUnik()
	{
		$length = 5;
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$primaryKey = '';

		for ($i = 0; $i < $length; $i++) {
		    $randomChar = $characters[mt_rand(0, strlen($characters) - 1)];
		    $primaryKey .= $randomChar;
		}

		return $primaryKey;
	}
?>
