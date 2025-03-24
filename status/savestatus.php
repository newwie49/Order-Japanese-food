<?php
    @session_start();
    $mode = $_SESSION['mode'];
    include_once('../db/linkdb.php');

    // echo '<pre>' ,print_r($_POST),'</pre>'; 

    if($mode == "add") {
        
        $statusid = $_POST['statusid'];
        $statusname = $_POST['statusname'];
    
        $sql = "INSERT INTO tbstatus(statusid,statusname)
        VALUES ('$statusid','$statusname')";
    
        $query = $conn->query($sql);
        header("refresh:0, url=managestatus.php");
    }
    if($mode == "edit") {
        
        $statusid = $_POST['statusid'];
        $statusname = $_POST['statusname'];
    
        $sql = "UPDATE tbstatus SET
                    statusname = '$statusname'
                    WHERE statusid = '$statusid'";
    
        $query = $conn->query($sql);
        header("refresh:0, url=managestatus.php");
    }


    ?>