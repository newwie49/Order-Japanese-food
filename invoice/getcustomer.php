<?php
@session_start();
include '../db/linkdb.php';
if(isset($_POST['customerid'])) {
  $customerid = $_POST['customerid'];
}
$sql = "SELECT customerid,customername 
            FROM tbcustomer 
            WHERE statusid IN ('10')";
$query = $conn->query($sql);
// echo $sql; exit();
$opt = '<option value="">--- เลือกลูกค้า ---</option>';

if($query->num_rows > 0) {
    while ($rs = $query->fetch_assoc()) {
      if($customerid == $rs['customerid']) {
        $selected = " selected ";
      } else {
        $selected = "";
      }
      $opt .= '<option value="'.$rs['customerid'].'" '.$selected.'>'.$rs['customername'].'</option>';  
    }
}
echo $opt;
?>