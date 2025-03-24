<?php
@session_start();
$mode = $_SESSION['mode'];
// $userid = $_SESSION['userid'];
include_once('../db/linkdb.php');

// echo '<pre>',print_r($_POST),'</pre>'; exit();

if ($mode == "add") {
    $sqlLastid = "SELECT ordid  
                        FROM tbordheader  
                        ORDER BY ordid*1 DESC LIMIT 1";
    $queryLastid = $conn->query($sqlLastid);
    if ($queryLastid->num_rows > 0) {
        $rsLastid = $queryLastid->fetch_assoc();
        $ordid = $rsLastid['ordid'] + 1;
    } else {
        $ordid = 1;
    }

    $supplierid = $_POST['supplierid'];
    $orddate = explode("-", $_POST['orddate']);

    // echo '<pre>',print_r($orddate),'</pre'; exit();
    $day = $orddate[0];
    $month = $orddate[1];
    $year = $orddate[2];
    
    $neworddate = date('Y-m-d', strtotime($year.'-'. $month.'-'. $day));
    // echo $neworddate; exit();

    $statusid = "80";
    $createddate = date('Y-m-d');

    for ($i = 0; $i < count($_SESSION['ordrmid']); $i++) {
        if ($_SESSION['ordrmid'][$i] != "") {
            $rmid = $_SESSION['ordrmid'][$i];
            $rmprice = $_SESSION['ordrmprice'][$i];
            $rmqty = $_SESSION['ordrmqty'][$i];

            $sqlD = "INSERT INTO tborddetail(ordid,rmid,rmprice,rmqty) 
                            VALUES('$ordid','$rmid','$rmprice','$rmqty')";

            $queryD = $conn->query($sqlD);
        }
    }
    $sqlH = "INSERT INTO tbordheader(ordid,orddate,supplierid,statusid) 
                    VALUES('$ordid','$neworddate','$supplierid','$statusid')";
    echo $sqlH; exit();
    $queryH = $conn->query($sqlH);
    header("refresh:0,url=manageorders.php");
}
if ($mode == "edit") {
    $ordid = $_POST['ordid'];
    $rmname = $_POST['rmname'];
    $rmtid = $_POST['rmtid'];
    $statusid = $_POST['statusid'];

    $sql = "UPDATE tbrm SET 
                    rmname = '$rmname',
                    rmtid = '$rmtid',
                    statusid = '$statusid' 
                    WHERE ordid = '$ordid'";

    $query = $conn->query($sql);
    header("refresh:0,url=manageorders.php");
}
if ($mode == "approve") {
    $ordid = $_POST['ordid'];
    $approveid = $_POST['approveid'];

    // กำหนดวันที่ปัจจุบันเป็นวันที่การจัดส่ง
    $shipmentDate = date('Y-m-d');

    $sql = "UPDATE tbordheader SET
                statusid = '$approveid',
                shipmentdate = '$shipmentDate' 
            WHERE ordid = '$ordid'";
    
    $query = $conn->query($sql);

    if ($approveid == "62") {
        $sql = "SELECT od.rmid, od.rmprice, od.rmqty 
                FROM tborddetail od 
                WHERE od.ordid = '$ordid'";
        $query = $conn->query($sql);
        
        while ($rs = $query->fetch_assoc()) {
            $rmid = $rs['rmid'];
            $rmprice = $rs['rmprice'];
            $rmqty = $rs['rmqty'];

            $sqlD = "UPDATE tbrm SET 
                        rmprice = '$rmprice',
                        rmquantity = rmquantity + '$rmqty' 
                     WHERE rmid = '$rmid'";
            $queryD = $conn->query($sqlD);
        }
    }
    
    header("refresh:0,url=manageorders.php");
}

