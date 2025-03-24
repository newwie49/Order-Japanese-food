<?php
@session_start();
$mode = $_SESSION['mode'];
$userid = $_SESSION['userid'];
include_once('../db/linkdb.php');

// echo '<pre>',print_r($_POST),'</pre>'; exit();

if ($mode == "add") {
    $sqlLastid = "SELECT invid  
                        FROM tbinvheader  
                        ORDER BY invid*1 DESC LIMIT 1";
    $queryLastid = $conn->query($sqlLastid);
    if ($queryLastid->num_rows > 0) {
        $rsLastid = $queryLastid->fetch_assoc();
        $invid = $rsLastid['invid'] + 1;
    } else {
        $invid = 1;
    }

    $customerid = $_POST['customerid'];
    $invdate = explode("-", $_POST['invdate']);

    // echo '<pre>',print_r($invdate),'</pre'; exit();
    $day = $invdate[0];
    $month = $invdate[1];
    $year = $invdate[2];
    
    $newinvdate = date('Y-m-d', strtotime($year.'-'. $month.'-'. $day));
    // echo $newinvdate; exit();

    $statusid = "30";
    $createddate = date('Y-m-d');

    for ($i = 0; $i < count($_SESSION['invgoodsid']); $i++) {
        if ($_SESSION['invgoodsid'][$i] != "") {
            $goodsid = $_SESSION['invgoodsid'][$i];
            $price = $_SESSION['invprice'][$i];
            $goodsqty = $_SESSION['invgoodsqty'][$i];

            $sqlD = "INSERT INTO tbinvdetail(invid,goodsid,price,goodsqty) 
                            VALUES('$invid','$goodsid','$price','$goodsqty')";
            $queryD = $conn->query($sqlD);

            $sqlCST = "UPDATE tbgoods SET 
                            balance = balance - $goodsqty,
                            price = '$price'
                        WHERE goodsid = '$goodsid'";
            $queryCST = $conn->query($sqlCST);
        }
    }
    $sqlH = "INSERT INTO tbinvheader(invid,invdate,customerid,userid,createdby,statusid,createddate) 
                    VALUES('$invid','$newinvdate','$customerid','$userid','$userid','$statusid','$createddate')";
    // echo $sqlH; exit();
    $queryH = $conn->query($sqlH);
    header("refresh:0,url=manageinvoice.php");
}
if ($mode == "edit") {
    $invid = $_POST['invid'];
    $goodsname = $_POST['goodsname'];
    $unitid = $_POST['unitid'];
    $statusid = $_POST['statusid'];

    $sql = "UPDATE tbgoods SET 
                    goodsname = '$goodsname',
                    unitid = '$unitid',
                    statusid = '$statusid' 
                    WHERE invid = '$invid'";

    $query = $conn->query($sql);
    header("refresh:0,url=manageinvoice.php");
}
if ($mode == "approve") {
    $invid = $_POST['invid'];
    $approveid = $_POST['approveid'];

    $sql = "UPDATE tbinvheader SET 
                    statusid = '$approveid' 
                    WHERE invid = '$invid'";
    // echo $sql; exit();
    $query = $conn->query($sql);

    if ($approveid == "30") {
        $sql = "SELECT id.goodsid,id.price,id.goodsqty 
            FROM tbinvdetail od 
            WHERE id.invid = '$invid'";
         // echo $sql; exit();
        $query = $conn->query($sql);
        while ($rs = $query->fetch_assoc()) {
            $goodsid = $rs['goodsid'];
            $price = $rs['price'];
            $goodsqty = $rs['goodsqty'];
            $sqlD = "UPDATE tbgoods SET 
                        price = '$price',
                        balance = balance + '$goodsqty' 
                    WHERE goodsid = '$goodsid'";
            $queryD = $conn->query($sqlD);
        }
    }
    header("refresh:0,url=manageinvoice.php");
}

?>
