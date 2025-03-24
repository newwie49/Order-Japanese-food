<?php 
@session_start();

$goodsid = $_POST['goodsid'];
$price = $_POST['price'];

// echo '<pre>',print_r($_POST),'</pre>'; exit();

$granditem = $grandtotal = 0;
for($i=0; $i < count($_SESSION['invgoodsid']); $i++) {
    if($_SESSION['invgoodsid'][$i] != "") {
        if($_SESSION['invgoodsid'][$i] == $goodsid) {
            $_SESSION['invprice'][$i] = $price;
        }
        $granditem++;
        $total = $_SESSION['invprice'][$i] * $_SESSION['invgoodsqty'][$i];
        $grandtotal += $total;
        // echo  $_SESSION['invprice'][$i]." $price $grandtotal <br>";
    }
}
$result = array(
    'granditem'=>$granditem,
    'grandtotal'=>$grandtotal
);
// echo $grandtotal;
echo json_encode($result);
?>