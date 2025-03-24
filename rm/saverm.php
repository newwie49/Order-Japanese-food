<?php
    @session_start();
    $mode = $_SESSION['mode'];
    include_once('../db/linkdb.php');

    // echo '<pre>' ,print_r($_POST),'</pre>'; 
        
        if($mode == "add") {
            $sqlLastid = "SELECT rmid 
                            FROM tbrm
                            ORDER BY rmid*1 DESC LIMIT 1";
            $queryLastid = $conn->query($sqlLastid);
            if($queryLastid->num_rows > 0) {
                $rsLastid = $queryLastid->fetch_assoc();
                $rmid = $rsLastid['rmid'] + 1;
            } else {
                $rmid = 1;
            }

        $rmname = $_POST['rmname'];
        $rmtid = $_POST['rmtid'];
        $unitid = $_POST['unitid'];
        $rmprice = $_POST['rmprice'];
        $rmquantity = $_POST['rmquantity'];
        $statusid = $_POST['statusid'];
    
        $sql = "INSERT INTO tbrm(rmid,rmname,unitid,rmtid,rmprice,rmquantity,statusid)
        VALUES ('$rmid','$rmname','$unitid','$rmtid','$rmprice','$rmquantity','$statusid')";
    
        $query = $conn->query($sql);
        header("refresh:0, url=managerm.php");
    }
    if($mode == "edit") {
        $rmid = $_POST['rmid'];
        $rmname = $_POST['rmname'];
        $rmtid = $_POST['rmtid'];
        $unitid = $_POST['unitid'];
        $rmprice = $_POST['rmprice'];
        $rmquantity = $_POST['rmquantity'];
        $statusid = $_POST['statusid'];
        $stmt = $conn->prepare("UPDATE tbrm
                                SET rmname = ?,
                                    rmtid = ?,
                                    unitid = ?,
                                    rmprice = ?,
                                    rmquantity = ?,
                                    statusid = ? 
                                WHERE rmid = ?");
        $stmt->bind_param("ssssssi", $rmname, $rmtid, $unitid, $rmprice, $rmquantity, $statusid, $rmid);
    
        if ($stmt->execute()) {
            header("Location: managerm.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $conn->close();
      }
    ?>