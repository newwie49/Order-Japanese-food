<?php
@session_start();
include '../db/linkdb.php';
$sql = "SELECT statusid,statusname
            FROM tbstatus
            WHERE statusid IN ('10','12')";
$query = $conn->query($sql);
//echo $sql; exit();
$opt = '<option value="">--- เลือกสถานะ ---</option>';

if($query->num_rows > 0) {
    while ($rs = $query->fetch_assoc()) {
        $opt .= '<option value="'.$rs['statusid'].'">'.$rs['statusname'].'</option>';    
    }
}
echo $opt;
?>