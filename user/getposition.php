<?php
@session_start();
include '../db/linkdb.php';
// if(isset($_POST['positionid'])){
//     $positionid = $_POST['positionid']
// }

$sql = "SELECT positionid,positionname
            FROM tbposition
            WHERE statusid IN ('10')";
$query = $conn->query($sql);
// echo $sql; exit();
$opt = '<option value="">--- เลือกตำแหน่ง ---</option>';

if($query->num_rows > 0) {
    while ($rs = $query->fetch_assoc()) {
        // if($positionid == $rs['positionid']) {
        //     $selected = "selected";
        // } else {
        //     $selected = "";
        // }
        $opt .= '<option value="'.$rs['positionid'].'">'.$rs['positionname'].'</option>';    
    }
}
echo $opt;
?>