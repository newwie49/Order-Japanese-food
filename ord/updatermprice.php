<?php 
@session_start();

$rmid = $_POST['rmid'];
$rmprice = $_POST['rmprice'];

// echo '<pre>',print_r($_POST),'</pre>'; exit();

$granditem = $grandtotal = 0;
for($i=0; $i < count($_SESSION['ordrmid']); $i++) {
    if($_SESSION['ordrmid'][$i] != "") {
        if($_SESSION['ordrmid'][$i] == $rmid) {
            $_SESSION['ordrmprice'][$i] = $rmprice;
        }
        $granditem++;
        $total = $_SESSION['ordrmprice'][$i] * $_SESSION['ordrmqty'][$i];
        $grandtotal += $total;
        // echo  $_SESSION['ordrmprice'][$i]." $rmprice $grandtotal <br>";
    }
}
$result = array(
    'granditem'=>$granditem,
    'grandtotal'=>$grandtotal
);
// echo $grandtotal;
echo json_encode($result);
?>