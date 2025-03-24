<?php
@session_start();
include '../db/linkdb.php';
if(isset($_POST['statusid'])) {
  $statusid = $_POST['statusid'];
}
$sql = "SELECT statusid,statusname 
            FROM tbstatus 
            WHERE statusid IN ('30')";
$query = $conn->query($sql);
// echo $sql; exit();
$opt = '<option value="">--- เลือกสถานะ ---</option>';

if($query->num_rows > 0) {
    while ($rs = $query->fetch_assoc()) {
      if($statusid == $rs['statusid']) {
        $selected = " selected ";
      } else {
        $selected = "";
      }
      $opt .= '<option value="'.$rs['statusid'].'" '.$selected.'>'.$rs['statusname'].'</option>';  
    }
}
echo $opt;
?>