<?php
@session_start();
include '../db/linkdb.php';
$sql = "SELECT supplierid,suppliername
            FROM tbsupplier
            WHERE statusid IN ('10')";
$query = $conn->query($sql);
//echo $sql; exit();
$opt = '<option value="">--- เลือกผู้ขาย ---</option>';

if($query->num_rows > 0) {
    while ($rs = $query->fetch_assoc()) {
        $opt .= '<option value="'.$rs['supplierid'].'">'.$rs['suppliername'].'</option>';    
    }
}
echo $opt;
?>