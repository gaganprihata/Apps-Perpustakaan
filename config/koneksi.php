<?php
session_start();

$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_perpus_digital";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}
?>
