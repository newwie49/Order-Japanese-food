<?php
@session_start();
include '../db/linkdb.php';

$userid = $_POST['userid'];
$userpass = $_POST['userpass'];

$sql = "SELECT u.username,u.positionid,po.positionname,u.statusid
            FROM tbuser u
            LEFT JOIN tbposition po ON u.positionid = po.positionid
            WHERE userid = '$userid' AND userpass = '$userpass'";
$query = $conn->query($sql);
if($query->num_rows > 0 ) {
    $rs = $query->fetch_assoc();
    $_SESSION['userid'] = $userid;
    $_SESSION['username'] = $rs['username'];
    $_SESSION['positionid'] = $rs['positionid'];
    $_SESSION['positionname'] = $rs['positionname'];

     header("refresh:0, url=/index.php");
} else {
    $_SESSION['userid'] = "";
    $_SESSION['username'] = "";
    $_SESSION['positionid'] = "";
    $_SESSION['positionname'] = "";

    header("refresh:0, url=login.php");
    
}

?>