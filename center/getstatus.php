<?php 
    include '../db/linkdb.php'; 
    $sql = "SELECT statusid,statusname 
                FROM tbstatus 
                WHERE statusid IN ('10','90') ";
    $query = $conn->query($sql);
    $opt = '<option value="">--- เลือกสถานะ ---</option>';
    if($query->num_rows > 0) {
        while($rs = $query->fetch_assoc()) {
            $statusid = $rs['statusid'];
            $statusname = $rs['statusname'];

            $opt .= '<option value="'.$statusid.'">'.$statusname.'</option>';
        }
    }
    echo $opt;
?>