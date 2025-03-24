<?php
@session_start();
include '../db/linkdb.php';

// echo '<pre>',print_r($_POST),'</pre>'; exit();

if (isset($_POST['selecteditem'])) {
    $found = -1;
    $selecteditem = $_POST['selecteditem'];
    for ($i = 0; $i < count($selecteditem); $i++) {
        $goodsid = $selecteditem[$i];
        if (isset($_SESSION['invgoodsid'])) {
            for ($j = 0; $j < count($_SESSION['invgoodsid']); $j++) {
                if ($goodsid == $_SESSION['invgoodsid'][$j]) {
                    $_SESSION['invgoodsqty'][$j]++;
                    $found = $j;
                    break;
                }
            }
            if ($found < 0) {
                $sql = "SELECT g.goodsname,un.unitname,g.price,g.balance  
                        FROM tbgoods g 
                        LEFT JOIN tbunit un ON g.unitid = un.unitid 
                        WHERE g.goodsid = '$goodsid'";
                $query = $conn->query($sql);
                $rs = $query->fetch_assoc();
                if (isset($_SESSION['invgoodsid'])) {
                    $last = count($_SESSION['invgoodsid']);
                } else {
                    $last = 0;
                }
                $_SESSION['invgoodsid'][$last] = $goodsid;
                $_SESSION['invgoodsname'][$last] = $rs['goodsname'];
                $_SESSION['invunitname'][$last] = $rs['unitname'];
                $_SESSION['invprice'][$last] = $rs['price'];
                $_SESSION['invbalance'][$last] = $rs['balance'];
                $_SESSION['invgoodsqty'][$last] = 1;
            }
        } else {
            $sql = "SELECT g.goodsname,un.unitname,g.price,g.balance  
                        FROM tbgoods g 
                        LEFT JOIN tbunit un ON g.unitid = un.unitid 
                        WHERE g.goodsid = '$goodsid'";
            $query = $conn->query($sql);
            $rs = $query->fetch_assoc();
            $last = 0;
            $_SESSION['invgoodsid'][$last] = $goodsid;
            $_SESSION['invgoodsname'][$last] = $rs['goodsname'];
            $_SESSION['invunitname'][$last] = $rs['unitname'];
            $_SESSION['invprice'][$last] = $rs['price'];
            $_SESSION['invbalance'][$last] = $rs['balance'];
            $_SESSION['invgoodsqty'][$last] = 1;
        }
    }
}
header("refresh:0, url=addinv.php");
