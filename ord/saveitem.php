<?php
@session_start();
include '../db/linkdb.php';

// echo '<pre>',print_r($_POST),'<pre>'; exit();

if(isset($_POST['selecteditem'])){
    $found = -1;
    $selecteditem = $_POST['selecteditem'];
    for($i=0; $i < count($selecteditem); $i++){
        $rmid = $selecteditem[$i];
        if(isset($_SESSION['ordrmid'])) {
         for($j=0; $j < count($_SESSION['ordrmid']); $j++){
            if($rmid == $_SESSION['ordrmid'][$j]) {
                $_SESSION['ordrmqty'][$j]++;
                $found = $j;
                break;
            }
        }
        if($found < 0){
            $sql = "SELECT rm.rmname,rt.rmtname,rm.rmprice
                        FROM tbrm rm 
                        LEFT JOIN tbrmt rt ON rm.rmtid = rt.rmtid
                        WHERE rm.rmid = '$rmid'";
            $query = $conn->query($sql);
            $rs = $query->fetch_assoc();
            if(isset($_SESSION['ordrmid'])) {
                $last = count($_SESSION['ordrmid']);
            }else{
                $last = 0;
            }
            $_SESSION['ordrmid'][$last] = $rmid;
            $_SESSION['ordrmname'][$last] = $rs['rmname'];
            $_SESSION['ordrmtname'][$last] = $rs['rmtname'];
            $_SESSION['ordrmprice'][$last] = $rs['rmprice'];
            $_SESSION['ordrmqty'][$last] = 1;
        }
        }else{
            $sql = "SELECT rm.rmname,rt.rmtname,rm.rmprice
                    FROM tbrm rm 
                    LEFT JOIN tbrmt rt ON rm.rmtid = rt.rmtid
                    WHERE rm.rmid = '$rmid'";
            $query = $conn->query($sql);
            $rs = $query->fetch_assoc();
            $last = 0;
            $_SESSION['ordrmid'][$last] = $rmid;
            $_SESSION['ordrmname'][$last] = $rs['rmname'];
            $_SESSION['ordrmtname'][$last] = $rs['rmtname'];
            $_SESSION['ordrmprice'][$last] = $rs['rmprice'];
            $_SESSION['ordrmqty'][$last] = 1;
        }
     
    }

}
header("refresh:0, url=addord.php");
?>