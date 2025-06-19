<?php
ob_clean();
require_once 'vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf();
$idprint = $_GET['print'];
$querytransaction = mysqli_query($config, "SELECT * FROM transactions WHERE id = '$idprint'");
$rowtransaction = mysqli_fetch_assoc($querytransaction);




$html = "
<h1>{$rowtransaction['no_transaction']}</h1>";

$mpdf->WriteHTML($html);
$mpdf->Output();