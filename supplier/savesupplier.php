<?php
    @session_start();
    $mode = $_SESSION['mode'];
    include_once('../db/linkdb.php');

    // echo '<pre>' ,print_r($_POST),'</pre>'; 
        
        if($mode == "add") {
            $sqlLastid = "SELECT supplierid 
                            FROM tbsupplier
                            ORDER BY supplierid*1 DESC LIMIT 1";
            $queryLastid = $conn->query($sqlLastid);
            if($queryLastid->num_rows > 0) {
                $rsLastid = $queryLastid->fetch_assoc();
                $supplierid = $rsLastid['supplierid'] + 1;
            } else {
                $supplierid = 1;
            }

        $suppliername = $_POST['suppliername'];
        $statusid = $_POST['statusid'];
    
        $sql = "INSERT INTO tbsupplier(supplierid,suppliername,statusid)
        VALUES ('$supplierid','$suppliername','$statusid')";
    
        $query = $conn->query($sql);
        header("refresh:0, url=managesupplier.php");
    }
    if($mode == "edit") {
        
        $supplierid = $_POST['supplierid'];
        $suppliername = $_POST['suppliername'];
        $statusid = $_POST['statusid'];
    
        $sql = "UPDATE tbsupplier SET
                    suppliername = '$suppliername',
                    statusid = '$statusid'
                    WHERE supplierid = '$supplierid'";
    
        $query = $conn->query($sql);
        header("refresh :0, url=managesupplier.php");
    }


    ?>