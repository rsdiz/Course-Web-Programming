<?php

//Inisialisasi
$host = "localhost";
$username = "root";
$password = "";
$database = "db_rosyid";

// Koneksi Database dengan mysqli
$db = mysqli_connect($host, $username, $password, $database);

// Koneksi Database dengan PDO
// $db_pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);

// Cek Koneksi mysqli
// if ($db) {
// 	echo "<b>Koneksi Database Berhasil!</b>";
// } else {
// 	echo "<b>Koneksi Database Gagal!</b>";
// }


// Cek Koneksi PDO
// try {
// 		$db_pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
// 		$db_pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
// 		$db_pdo = null;
// } catch (PDOException $e) {
// 		print "Koneksi atau query bermasalah: " . $e->getMessage() . "<br/>";
// 		die();
// }

?>