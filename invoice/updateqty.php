<?php 
@session_start();

$goodsid = $_POST['goodsid'];
$goodsqty = $_POST['goodsqty'];

// echo '<pre>',print_r($_POST),'</pre>'; exit();

$granditem = $grandtotal = $totalitem = 0;
for($i=0; $i < count($_SESSION['invgoodsid']); $i++) {
    if($_SESSION['invgoodsid'][$i] != "") {
        if($_SESSION['invgoodsid'][$i] == $goodsid) {
            $_SESSION['invgoodsqty'][$i] = $goodsqty;
        }
        $granditem += $_SESSION['invgoodsqty'][$i];
        $total = $_SESSION['invprice'][$i] * $_SESSION['invgoodsqty'][$i];
        $grandtotal += $total;
        // echo  $_SESSION['invcost'][$i]." $cost $grandtotal <br>";
    }
}
$result = array(
    "granditem"=>$granditem,
    "grandtotal"=>$grandtotal
);
// echo $grandtotal;
echo json_encode($result);
?>