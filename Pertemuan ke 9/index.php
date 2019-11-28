<?php
// Connect to database
include('db.php');
// Function to avoid XSS attacks
function test_data($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
// variable initialization
$nim = $nama = $divisi = $jenis_kelamin = "";
$errNIM = $errNama = $errDivisi = $errJK = "";
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Pertemuan 9: Koneksi Database dan Input Data</title>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.css">
	<style>
		body {
			padding: 0;
			margin: 0;
			min-width: 480px;
		}
		div.content-middle {
			position:absolute;
			top:50%;
			left:50%;
			transform:translate(-50%,-50%);
			-ms-transform:translate(-50%,-50%);
			border: 1px solid #2A8CCE;
			border-radius: 10px;
		}
		form {
			display: table;
			margin: 20px;
		}
		input, select {
			margin-top: 0;
			padding: 10px;
			margin-bottom: 8px;
			border: 1px solid #197BBD;
			border-radius: 5px;
		}
		input {
			width: calc(100% - 25px);
		}
		select {
			width: 100%;
			margin-bottom: 0;
		}
		fieldset {
			border: 1px solid #197BBD;
			border-radius: 5px;
			margin-bottom: 8px;
		}
		legend {
			color: #0F0F0F;
		}
		button {
			padding: 10px;
			margin-bottom: 8px;
			background-color: #197BBD;
			color: #EEEEFF;
			border: none;
			border-radius: 5px;
			width: 100%;
		}
		button:hover {
			background-color: #145C9E;
			cursor: pointer;
		}
		.err {
			background-color: #FF4141;
			color: white;
			padding: 5px;
		}
	</style>
</head>
<body>
	<div class="content-middle">
		<?php
		// Check the request method
		if ($_SERVER["REQUEST_METHOD"] == "POST" ) {
			// Check the submit button
			if (isset($_POST['submit'])) {
				// errors variable initialization
				$errors = 0;
				// get data from user input
				$nim = test_data($_POST['nim']);
				if (empty($nim)) {
					$errNIM = "<div class='err'>Harap isi NIM!</div>";
					$errors += 1;
				}
				$nama = test_data($_POST['nama']);
				if (empty($nama)) {
					$errNama = "<div class='err'>Harap isi Nama!</div>";
					$errors += 1;
				}
				if (isset($_POST['divisi'])) {
					$divisi = test_data($_POST['divisi']);
				} else {
					$errDivisi = "<div class='err'>Harap Pilih Divisi!</div>";
					$errors += 1;
				}
				if (isset($_POST['jenis_kelamin'])) {
					$jenis_kelamin = test_data($_POST['jenis_kelamin']);
				} else {
					$errJK = "<div class='err'>Harap Pilih Jenis Kelamin!</div>";
					$errors += 1;
				}

				// Query for check user input in database
				if ($errors > 0) {
					echo "
					<script type='text/javascript'>
					setTimeout(function () {
						swal({
							title: 'Data belum lengkap!',
							text: 'Lengkapi semua data',
							type: 'error',
							timer: 3000,
							showConfirmButton: true
						});  
					},10);
					</script>
					";
				} else {
					$query = mysqli_query($db, "SELECT * FROM anggota WHERE nim = '$nim'");

					// Check the user input is exist or not
					if (mysqli_num_rows($query) > 0) {
						// if exist
						// Run this javascript (SweetAlert)
						echo "
						<script type='text/javascript'>
						setTimeout(function () {
							swal({
								title: 'Pengurus Sudah Ada!',
								text: '$nama merupakan $divisi',
								type: 'error',
								timer: 3000,
								showConfirmButton: true
							});  
						},10); 
						window.setTimeout(function(){ 
							window.location.replace('index.php');
						} ,3000);
						</script>
						";
					} else {
						// if not exist
						// Run this query
						$query = mysqli_query($db, "INSERT INTO anggota (nim,nama,divisi,jenis_kelamin) VALUES ('$nim','$nama','$divisi','$jenis_kelamin')");
						// then, Run this javascript (SweetAlert)
						echo "
						<script type='text/javascript'>
						setTimeout(function () {  
							swal({
								title: 'Pengurus Berhasil ditambahkan',
								text: '$nama ditambahkan ke $divisi',
								type: 'success',
								timer: 3000,
								showConfirmButton: true
							});
						},10);
						window.setTimeout(function(){
							window.location.replace('index.php');
						} ,3000);
						</script>
						";
					}
				}
			}
		}
		?>

		<form action="" method="post">
			<table cellpadding="0" cellspacing="0" border="0">
				<tr><th><h3>Tambah Pengurus HIMATIKA</h3></th></tr>
				<tr><td><?=$errNIM;?><input type="text" value="<?=$nim;?>" placeholder="Masukkan NIM" name="nim" maxlength="10" autocomplete="off" required /></td></tr>
				<tr><td><?=$errNama;?><input type="text" value="<?=$nama;?>" placeholder="Masukkan Nama" name="nama" maxlength="50" autocomplete="off" required /></td></tr>
				<tr>
					<td>
						<fieldset>
							<legend>Pilih Jenis Kelamin:</legend>
							<?=$errJK;?><select name="jenis_kelamin" required>
								<option <?php if (empty($jenis_kelamin)) echo "selected"; ?> disabled>Jenis Kelamin</option>
								<option <?php if ($jenis_kelamin == "Laki-Laki") echo "selected"; ?> value="Laki-Laki">Laki-Laki</option>
								<option <?php if ($jenis_kelamin == "Perempuan") echo "selected"; ?>value="Perempuan">Perempuan</option>
							</select>
						</fieldset>
					</td>
				</tr>
				<tr>
					<td>
						<fieldset>
							<legend>Pilih Divisi:</legend>
							<?=$errDivisi;?><select name="divisi" required>
								<option <?php if (empty($divisi)) echo "selected"; ?> disabled>Divisi</option>
								<option <?php if ($divisi == "Divisi Keilmuan") echo "selected"; ?> value="Divisi Keilmuan">Divisi Keilmuan</option>
								<option <?php if ($divisi == "Divisi Humas") echo "selected"; ?> value="Divisi Humas">Divisi Humas</option>
								<option <?php if ($divisi == "Divisi Media") echo "selected"; ?> value="Divisi Media">Divisi Media</option>
								<option <?php if ($divisi == "Divisi SDM") echo "selected"; ?> value="Divisi SDM">Divisi SDM</option>
							</select>
						</fieldset>
					</td>
				</tr>
				<tr><td><button name="submit">Simpan</button></td></tr>
			</table>
		</form>

	</div>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.js"></script>
</body>
</html>