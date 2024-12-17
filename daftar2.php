<?php 
//koneksi ke database
session_start();
$koneksi = new mysqli('localhost','root','','bnsp-alat-kesehatan');
?>
<!DOCTYPE html>
<html>
<head>
    <!-- Compiled and minified CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
	<!-- Compiled and minified JavaScript -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
	<!--Let browser know website is optimized for mobile-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>Daftar</title>
</head>
<body>
    <!-- NAVBAR -->
    <?php include"navbar.php"; ?>
    
    <div class="container">
	<center id='login'><h3> DAFTAR AKUN BARU</h3></center>

	<div class="row">
		<form method="post"	>
			<div class="row">
				<div class="input-field">
					<i class="material-icons prefix">account_circle</i>
					<input id="icon_prefix" type="text" required class="validate" name="nama" autocomplete="off">
					<label for="icon_prefix">Username</label>
				</div>
				<div class="input-field">
					<i class="material-icons prefix">lock</i>
					<input id="icon_lock" type="password" required class="validate" name="password">
					<label for="icon_lock">Password</label>
				</div>
				<div class="input-field">
					<i class="material-icons prefix">email</i>
					<input id="icon_email" type="email" required class="validate" name="email" autocomplete="off">
					<label for="icon_email">E-mail</label>
				</div>
				<div class="input-field">
					<i class="material-icons prefix">calendar_today</i>
					<input id="icon_callendar" type="date" required class="validate" name="tanggal_lahir">
					<label for="icon_callendar">Tanggal Lahir</label>
				</div>
				<div class="input-field">
					<i class="material-icons prefix">wc</i>
					<input id="icon_gender" type="text" required class="validate" name="jenis_kelamin">
					<label for="icon_gender">Jenis Kelamin</label>
				</div>
				<div class="input-field">
					<i class="material-icons prefix">book</i>
					<textarea id="textarea1" class="materialize-textarea" name="alamat"></textarea>
					<label for="textarea1">Alamat</label>
				</div>
				<div class="input-field">
					<i class="material-icons prefix">location_on</i>
					<textarea id="textarea2" class="materialize-textarea" name="kota"></textarea>
					<label for="textarea2">Kota</label>
				</div>		
				<div class="input-field">
					<i class="material-icons prefix">phone</i>
					<input id="icon_telephone" type="number" required class="validate" name="telepon">
					<label for="icon_telephone">Telephone</label>
				</div>
				<div class="input-field">
					<i class="material-icons prefix">credit_card</i>
					<input id="icon_paypal" type="number" required class="validate" name="paypal">
					<label for="icon_paypal">Paypal ID</label>
				</div>
				<div class="right">
					<button  class="btn waves-effect waves-light" type="submit" name="daftar">Daftar
						<i class="material-icons right">send</i>
					</button>
					<button class="btn waves-effect waves-light" type="reset" name="clear">Clear
						<i class="material-icons right">clear</i>
					</button>
				</div>
			</div>
		</form>
		<?php 
			// jika ada tombol daftar(ditekan tombol daftar)
		if (isset($_POST["daftar"])) 
		{
			//mengambil isian nama, password, email, tanggal_lahir, jenis_kelamin, alamat, kota, telepon, paypal
			$nama = $_POST["nama"];
			$password = $_POST["password"];
			$email = $_POST["email"];
			$tanggal_lahir = $_POST["tanggal_lahir"];
			$jenis_kelamin = $_POST["jenis kelamin"];
			$alamat = $_POST["alamat"];
			$kota = $_POST["kota"];
			$telepon = $_POST["telepon"];
			$paypal = $_POST["paypal"];

			// cek apakah email sudah digunakan
			$ambil = $koneksi->query("SELECT * FROM pelanggan WHERE email_pelanggan='$email'");
			$yangcocok =$ambil->num_rows;
			if ($yangcocok==1)
			{
				echo "<script>alert('pendaftaran gagal, email sudah digunakan');</script>";
				echo "<script>location='daftar.php';</script>";
			}
			else 
			{
			// query insert ke tabel pelanggan 
				$koneksi->query("INSERT INTO pelanggan (nama_pelanggan, password_pelanggan, email_pelanggan, tanggal_lahir_pelanggan, jenis_kelamin_pelanggan, alamat_pelanggan, kota_pelanggan, telepon_pelanggan, paypal_pelanggan)
					VALUES('$nama', '$password', '$email', '$tanggal_lahir', '$jenis_kelamin', '$alamat', '$kota', '$telepon', $paypal);");

				echo "<script>alert('pendaftaran sukses, silahkan login');</script>";
				echo "<script>location='login.php';</script>";
			}

		}

		?>
	</div>


</body>
</html>