<?php
    @session_start();
    $mode = $_SESSION['mode'];
    include_once('../db/linkdb.php');

    // echo '<pre>',print_r($_POST),'</pre>';

    if($mode == "add") {
        $sqlLastid = "SELECT customerid 
                        FROM tbcustomer 
                        ORDER BY customerid*1 DESC LIMIT 1";
        $queryLastid = $conn->query($sqlLastid);
        if($queryLastid->num_rows > 0) {
            $rsLastid = $queryLastid->fetch_assoc();
            $customerid = $rsLastid['customerid'] + 1;
        } else {
            $customerid = 1;
        }

        $customername = $_POST['customername'];
        $statusid = $_POST['statusid'];

        $sql = "INSERT INTO tbcustomer(customerid,customername,statusid) 
        VALUES('$customerid','$customername','$statusid')";

        $query = $conn->query($sql);
        header("refresh:0,url=managecustomer.php");
    }
    if($mode == "edit") {
        $customerid = $_POST['customerid'];
        $customername = $_POST['customername'];
        $statusid = $_POST['statusid'];

        $sql = "UPDATE tbcustomer SET 
                    customername = '$customername',
                    statusid = '$statusid' 
                    WHERE customerid = '$customerid'";

        $query = $conn->query($sql);
        header("refresh:0,url=managecustomer.php");
    }


?>