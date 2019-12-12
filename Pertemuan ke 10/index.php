<?php
// Connect to Database
include 'init/db.php';
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
	<title>CRUD Sederhana</title>
	<link rel="stylesheet" href="assets/css/sweetalert.min.css">
	<link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>

	<div class="content-middle">
		<h1 class="big-1">HIMATIKA</h1>

		<?php 
		// Check the request method
		if ($_SERVER["REQUEST_METHOD"] == "POST" ) {
			// Check the submit button
			if (isset($_POST['submit']) || isset($_POST['edit'])) {
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
					if (isset($_POST['edit'])) {
						$id = $_POST['id'];
						$query = "UPDATE `anggota` SET `nama` = '$nim', `nama` = '$nama', `divisi` = '$divisi', `jenis_kelamin` = '$jenis_kelamin' WHERE `id` = '$id'";
						$queryCheck = mysqli_query($conn, "SELECT * FROM anggota WHERE id = '$id'");
						$msg = "
						<script type='text/javascript'>
							setTimeout(function () {  
								swal({
									title: 'Pengurus Berhasil diedit',
									type: 'success',
									timer: 3000,
									showConfirmButton: true
								});
							},10);
							window.setTimeout(function(){
								window.location.replace('.?do=lihat');
							} ,3000);
						</script>";
					} elseif (isset($_POST['submit'])) {
						$query = "INSERT INTO anggota (id,nim,nama,divisi,jenis_kelamin) VALUES ('','$nim','$nama','$divisi','$jenis_kelamin')";
						$queryCheck = mysqli_query($conn, "SELECT * FROM anggota WHERE nim = '$nim'");
						$msg = "
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
								window.location.replace('.?do=tambah');
							} ,3000);
						</script>";
					}
					// Check the user input is exist or not
					if (isset($_POST['submit']) && mysqli_num_rows($queryCheck) > 0) {
						// if exist
						// Run this javascript (SweetAlert)
						echo "
						<script type='text/javascript'>
							setTimeout(function () {
								swal({
									title: 'Pengurus Sudah Ada!',
									text: '$nim sudah digunakan',
									type: 'error',
									timer: 3000,
									showConfirmButton: true
								});  
							},10); 
							window.setTimeout(function(){ 
								window.location.replace('.?do=tambah');
							} ,3000);
						</script>
						";
					} else {
						// if not exist
						// Run this query
						$query = mysqli_query($conn, $query);
						// then, Run this javascript (SweetAlert)
						echo $msg;
					}
				}
			}
		}
		?>

		<?php
		if (isset($_GET['do'])) {
			if ( $_GET['do'] == "tambah" ) { ?>
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
			<?php
			} elseif ( $_GET['do'] == "lihat") { ?>
			<form action="." method="get" style="text-align: left">
				<fieldset>
					<legend>Cari:</legend>
					<input type="hidden" name="do" value="lihat">
					<input type="text" placeholder="NIM / Nama / Divisi" name="q" style="display: inline-block; width: 70%; margin-right: 2%;"><button style="width: 23%;">CARI</button>
				</fieldset>
			</form>
			<div class="table-container">
				<table class="table-view">
					<?php
					if (isset($_GET['q'])) {
						$keyword = $_GET['q'];
						$query = mysqli_query($conn, "SELECT * FROM anggota WHERE nama like '%".$keyword."%'");
						if (mysqli_num_rows($query) == 0) $query = mysqli_query($conn, "SELECT * FROM anggota WHERE nim like '%".$keyword."%'");
						else if (mysqli_num_rows($query) == 0) $query = mysqli_query($conn, "SELECT * FROM anggota WHERE divisi like '%".$keyword."%'");
						echo "<caption>Hasil untuk pencarian: $keyword</caption>";
					} else {
						$query = mysqli_query($conn, "SELECT * FROM anggota");
					}
						if (mysqli_num_rows($query) == 0) {
							echo "<tr><th>Tidak ada pengurus!</th></tr>";
						} else { ?>
						<thead>
							<tr>
								<th width="107">NIM</th>
								<th width="137">NAMA</th>
								<th width="147">DIVISI</th>
								<th width="70">JK</th>
								<th width="170">AKSI</th>
							</tr>
						</thead>
						<tbody>
						<?php
						while ($data = mysqli_fetch_array($query)) { ?>
							<tr>
								<td width="104"><?= $data['nim'];?></td>
								<td width="145"><?= $data['nama'];?></td>
								<td width="147"><?= $data['divisi'];?></td>
								<td width="77"><?php $jk = ($data['jenis_kelamin'] == "Laki-Laki") ? "L" : "P" ; echo $jk;?></td>
								<td width="63"><a href="?do=edit&id=<?= $data['id'];?>"><button class="ic">✏</button></a></td>
								<td width="63"><a href="?do=hapus&id=<?= $data['id'];?>"><button class="ic">🗑</button></a></td>
							</tr>
						<?php }
						} ?>
					</tbody>
				</table>
			</div>
			<?php
			} elseif ($_GET['do'] == "edit") {
				if (isset($_GET['id'])) {
					$id = $_GET['id'];
					$query = mysqli_query($conn, "SELECT * FROM anggota WHERE id = '$id'");
					$data = mysqli_fetch_array($query);
					$nim = $data['nim'];
					$nama = $data['nama'];
					$jenis_kelamin = $data['jenis_kelamin'];
					$divisi = $data['divisi'];
				} else {
					header("Location: .?do=lihat");
				}
				?>
				<form action="." method="post">
				<table cellpadding="0" cellspacing="0" border="0">
					<tr><th><h3>Edit Pengurus HIMATIKA</h3></th></tr>
					<tr><td><?=$errNIM;?><input type="text" value="<?=$nim;?>" placeholder="Masukkan NIM" name="nim" maxlength="10" autocomplete="off" required /></td></tr>
					<tr><td><?=$errNama;?><input type="text" value="<?=$nama;?>" placeholder="Masukkan Nama" name="nama" maxlength="50" autocomplete="off" required /></td></tr>
					<tr>
						<td>
							<fieldset>
								<legend>Pilih Jenis Kelamin:</legend>
								<?=$errJK;?><select name="jenis_kelamin" required>
									<option <?php if (empty($jenis_kelamin)) echo "selected"; ?> disabled>Jenis Kelamin</option>
									<option <?php if ($jenis_kelamin == "Laki-Laki") echo "selected"; ?> value="Laki-Laki">Laki-Laki</option>
									<option <?php if ($jenis_kelamin == "Perempuan") echo "selected"; ?> value="Perempuan">Perempuan</option>
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
					<tr>
						<td>
							<input type="hidden" name="id" value="<?=$id;?>">
							<button name="edit">Simpan</button>
						</td>
					</tr>
				</table>
			</form>
			<?php } elseif ($_GET['do'] == "hapus") {
				if (isset($_GET['id'])) {
					$id = $_GET['id'];
					mysqli_query($conn, "DELETE FROM anggota WHERE id = '$id'");
				} else {
					header("Location: .?do=lihat");
				}
				echo "
						<script type='text/javascript'>
							setTimeout(function () {  
							swal({
								title: 'Pengurus Berhasil dihapus',
								type: 'success',
								timer: 3000,
								showConfirmButton: true
								});
							},10);
							window.setTimeout(function(){
								window.location.replace('.?do=lihat');
							} ,3000);
						</script>
					";
			}
		} else { ?>
			<img src="assets/img/logohimatika.png" alt="Logo HIMATIKA" class="img-logo">
		<?php
		} ?>

		<div class="flex-menu-box">
			<?php
			if (!isset($_GET['do'])) { ?>
			<div class="child-menu-box">
				<a href="?do=tambah"><div class="content">TAMBAH</div></a>
			</div>
			<div class="child-menu-box">
				<a href="?do=lihat"><div class="content">LIHAT</div></a>
			</div>
			<?php } else { ?>
			<div class="child-menu-box">
				<a href="."><div class="content">KEMBALI</div></a>
			</div>
			<?php } ?>

		</div>

	</div>
	
	<script src="assets/js/sweetalert.min.js"></script>
</body>
</html>