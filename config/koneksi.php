<?php
$hostname = "localhost";
$hostusername = "root";
$hostpassword = "";
$database = "point_of_sales_2";

$config = mysqli_connect($hostname, $hostusername, $hostpassword, $database);
if (!$config) {
    echo "Koneksi Gagal";
}

?>