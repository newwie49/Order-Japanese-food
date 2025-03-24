<?php
@session_start();
$goodsid = $_GET['id'];
//วนลูปเพื่อเปรียบเทียบค่าใน session กับ id
for ($i = 0; $i < count($_SESSION['invgoodsid']); $i++) {
    if ($_SESSION['invgoodsid'][$i] == $goodsid) {
        $_SESSION['invgoodsid'][$i] = "";
    }
}
header("refresh:0, url=addinv.php"); //เป็นคำสั่งให้ย้ายหน้า page ไปที่
?>