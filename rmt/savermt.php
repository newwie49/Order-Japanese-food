<?php
    @session_start();
    $mode = $_SESSION['mode'];
    include_once('../db/linkdb.php');

    // echo '<pre>' ,print_r($_POST),'</pre>'; 
        
        if($mode == "add") {
            $sqlLastid = "SELECT rmtid 
                            FROM tbrmt
                            ORDER BY rmtid*1 DESC LIMIT 1";
            $queryLastid = $conn->query($sqlLastid);
            if($queryLastid->num_rows > 0) {
                $rsLastid = $queryLastid->fetch_assoc();
                $rmtid = $rsLastid['rmtid'] + 1;
            } else {
                $rmtid = 1;
            }

        $rmtname = $_POST['rmtname'];
        $statusid = $_POST['statusid'];
    
        $sql = "INSERT INTO tbrmt(rmtid,rmtname,statusid)
        VALUES ('$rmtid','$rmtname','$statusid')";
    
        $query = $conn->query($sql);
        header("refresh:0, url=managermt.php");
    }
    if($mode == "edit") {
        
        $rmtid = $_POST['rmtid'];
        $rmtname = $_POST['rmtname'];
        $statusid = $_POST['statusid'];
    
        $sql = "UPDATE tbrmt SET
                    rmtname = '$rmtname',
                    statusid = '$statusid'
                    WHERE rmtid = '$rmtid'";
    
        $query = $conn->query($sql);
        header("refresh:0, url=managermt.php");
    }


    ?>