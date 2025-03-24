<?php
@session_start();
$goodsid = $_GET['id'];
// วนลูปเพื่อเปรียบเทียบค่าใน session กับ id
for ($i = 0; $i < count($_SESSION['ordgoodsid']); $i++){
    if ($_SESSION['ordgoodsid'][$i] == $goodsid) {
        $_SESSION['ordgoodsid'][$i] = "";
    }
}
header("refresh:0, url=addord.php"); //เป้นคำสั่งให้ย้ายหน้า page ไปที่ managegoods.php
?>