<?php
@session_start();
include '../db/linkdb.php';
$sql = "SELECT unitid,unitname
            FROM tbunit
            WHERE statusid IN ('10')";
$query = $conn->query($sql);
//echo $sql; exit();
$opt = '<option value="">--- เลือกหน่วยวัด ---</option>';

if($query->num_rows > 0) {
    while ($rs = $query->fetch_assoc()) {
        $opt .= '<option value="'.$rs['unitid'].'">'.$rs['unitname'].'</option>';    
    }
}
echo $opt;
?>