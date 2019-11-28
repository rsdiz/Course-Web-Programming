<?php
// Connect with database
include('connection.php');

// if button clicked
if (isset($_POST['submit'])) {
	// get data from user input
	$nim = $_POST['nim'];
	$nama = $_POST['nama'];
	$prodi = $_POST['prodi'];

	// input data query
	$query = "INSERT INTO mahasiswa (nim,nama,prodi)
			  VALUES ('$nim','$nama','$prodi')";

	// Input data to database Process
	$input = mysqli_query($db, $query);

	// Checking...
	if ($input) {
		echo '<script>alert("Sukses")</script>';
	} else { 
		echo '<script>alert("Gagal")</script>';
	}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Pertemuan 9: Muhammad Rosyid Izzulkhaq</title>
	<style>
		body {
			max-width: 768px;
			margin: auto;
		}
		form {
			display: table;
			text-align: center;
			margin: auto;
		}
		input {
			padding: 10px;
			margin-bottom: 8px;
			border: 1px solid #197BBD;
			border-radius: 5px;
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
	</style>
</head>
<body>
	
<form action="" method="post">
	
	<table cellpadding="0" cellspacing="0" border="0">
		<tr><th><h3>Input Data Mahasiswa</h3></th></tr>
		<tr><td><input type="text" placeholder="NIM" name="nim" maxlength="10" autocomplete="off"/></td></tr>
		<tr><td><input type="text" placeholder="Nama" name="nama" maxlength="50" autocomplete="off"/></td></tr>
		<tr><td><input type="text" placeholder="Program Studi" name="prodi" maxlength="20" autocomplete="off"/></td></tr>
		<tr><td><button name="submit">Simpan</button></td></tr>
	</table>

</form>

</body>
</html>