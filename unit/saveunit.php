<?php
    @session_start();
    $mode = $_SESSION['mode'];
    include_once('../db/linkdb.php');

    // echo '<pre>' ,print_r($_POST),'</pre>'; 
        
        if($mode == "add") {
            $sqlLastid = "SELECT unitid 
                            FROM tbunit
                            ORDER BY unitid*1 DESC LIMIT 1";
            $queryLastid = $conn->query($sqlLastid);
            if($queryLastid->num_rows > 0) {
                $rsLastid = $queryLastid->fetch_assoc();
                $unitid = $rsLastid['unitid'] + 1;
            } else {
                $unitid = 1;
            }

        $unitname = $_POST['unitname'];
        $statusid = $_POST['statusid'];
    
        $sql = "INSERT INTO tbunit(unitid,unitname,statusid)
        VALUES ('$unitid','$unitname','$statusid')";
    
        $query = $conn->query($sql);
        header("refresh:0, url=manageunit.php");
    }
    if($mode == "edit") {
        
        $unitid = $_POST['unitid'];
        $unitname = $_POST['unitname'];
        $statusid = $_POST['statusid'];
    
        $sql = "UPDATE tbunit SET
                    unitname = '$unitname',
                    statusid = '$statusid'
                    WHERE unitid = '$unitid'";
    
        $query = $conn->query($sql);
        header("refresh:0, url=manageunit.php");
    }


    ?>