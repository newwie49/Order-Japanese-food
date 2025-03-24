<?php

require_once  '../vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf([
    'default_font_size' => 16,
    'default_font' => 'thsarabunnew',
    'mode' => 'utf-8',
    'format' => 'A4'
]);
$mpdf->WriteHTML('<h1>รายงาน</h1>');
$mpdf->Output();
?>