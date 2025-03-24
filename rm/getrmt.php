<?php
@session_start();
include '../db/linkdb.php';
$sql = "SELECT rmtid,rmtname
            FROM tbrmt
            WHERE statusid IN ('10')";
$query = $conn->query($sql);
//echo $sql; exit();
$opt = '<option value="">--- เลือกประเภท ---</option>';

if($query->num_rows > 0) {
    while ($rs = $query->fetch_assoc()) {
        $opt .= '<option value="'.$rs['rmtid'].'">'.$rs['rmtname'].'</option>';    
    }
}
echo $opt;
?>