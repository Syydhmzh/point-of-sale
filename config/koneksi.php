<?php
$hostname = "localhost";
$hostusername = "root";
$hostpassword = "";
$database = "lms_angkatan_2";

$config = mysqli_connect($hostname, $hostusername, $hostpassword, $database);
if (!$config) {
    echo "Koneksi Gagal";
}

?>