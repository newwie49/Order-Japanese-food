<?php
@session_start();
$_SESSION['mode'] = "view";
include '../db/linkdb.php'; 

$invid = $_GET['id'];

$sqlH = "SELECT ih.invdate,ih.customerid,su.customername,ih.statusid,st.statusname 
            FROM tbinvheader ih 
            LEFT JOIN tbcustomer su ON ih.customerid = su.customerid 
            LEFT JOIN tbstatus st ON ih.statusid = st.statusid 
            WHERE ih.invid = '$invid'";
// echo $sqlH; exit();
$queryH = $conn->query($sqlH);
$rsH = $queryH->fetch_assoc();
$invdate = new DateTime($rsH['invdate']);
$customerid = $rsH['customerid'];
$customername = $rsH['customername'];
$statusid = $rsH['statusid'];
$statusname = $rsH['statusname'];

$sqlD = "SELECT id.goodsid,g.goodsname,un.unitname,id.price,id.goodsqty 
            FROM tbinvdetail id 
            LEFT JOIN tbgoods g ON id.goodsid = g.goodsid 
            LEFT JOIN tbunit un ON g.unitid = un.unitid 
            WHERE id.invid = '$invid'";
// echo $sqlD; exit();
$queryD = $conn->query($sqlD);
$goodsidList=$goodsnameList=$unitnameList=$priceList=$goodsqtyList=array();
while($rsD = $queryD->fetch_assoc()) {
    array_push($goodsidList,$rsD['goodsid']);
    array_push($goodsnameList,$rsD['goodsname']);
    array_push($unitnameList,$rsD['unitname']);
    array_push($priceList,$rsD['price']);
    array_push($goodsqtyList,$rsD['goodsqty']);
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php include '../center/linkcss.php'; ?>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <?php include '../center/menu.php'; ?>
                <h1 class="text-center">อนุมัติใบขาย</h1>
                <form action="saveinv.php" method="post">
                    <div class="row">
                        <div class="col-3 offset-9">
                            <div class="input-group mt-3">
                                <span class="input-group-text" id="basic-addon1">เลขที่</span>
                                <input type="text" class="form-control" placeholder="" name="invid" id="invid" value="<?php echo $invid; ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="input-group mt-3">
                                <span class="input-group-text" id="basic-addon1">ผู้ขาย</span>
                                <input type="text" name="customerid" id="customerid" value="<?php echo $customername; ?>" readonly>
                            </div>
                        </div>
                        <div class="col-3 offset-5">
                            <div class="input-group mt-3">
                                <span class="input-group-text" id="basic-addon1">วันที่</span>
                                <input type="text" class="form-control" placeholder="" name="invdate" id="invdate" value="<?php echo date_format($invdate,'d-m-Y'); ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="d-grid justify-content-md-end">
                            <!-- <a href="additem.php" class="btn btn-primary">เพิ่มรายการ</a> -->
                        </div>
                    </div>
                    <div class="row">
                        <table class="table">
                            <thead>
                                <th width="10%">#</th>
                                <th width="10%">รหัสสินค้า</th>
                                <th width="30%">ชื่อสินค้า</th>
                                <th width="10%">หน่วย</th>
                                <th width="10%">ราคาขาย</th>
                                <th width="10%">จำนวน</th>
                                <th width="10%">เป็นเงิน</th>
                                <th width="10%">ลบ</th>
                            </thead>
                            <tbody>
                            <?php 
                                    $item=0; $granditem = $grandtotal = 0;
                                
                                    for($i=0; $i < count($goodsidList); $i++) {
                                     
                                            $goodsid = $goodsidList[$i];
                                            $goodsname = $goodsnameList[$i];
                                            $unitname = $unitnameList[$i];
                                            $price = $priceList[$i];
                                            $goodsqty = $goodsqtyList[$i];
                                            $total = $price*$goodsqty;
                                            $item++;
                                            $granditem += $goodsqty;
                                            $grandtotal += $total;
                                            ?>
                                            <tr>
                                                <td><?php echo $item; ?></td>
                                                <td><?php echo $goodsid; ?></td>
                                                <td><?php echo $goodsname; ?></td>
                                                <td><?php echo $unitname; ?></td>
                                                <td class="text-end"><span><?php echo number_format($price,2); ?></span></td>
                                                <td class="text-end"><span><?php echo number_format($goodsqty,0); ?></span></td>
                                                <td class="text-end"><span><?php echo number_format($total,2); ?></span></td>
                                                <!-- <td><a href="removeitem.php?id=<?php echo $goodsid; ?>" class="text-danger"><i class="fa-solid fa-trash"></i></a></td> -->
                                            </tr>
                                        <?php 
                                        }
                            ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5"><?php echo "รวม ".$item." รายการ"; ?></td>
                                    <td class="text-end"><span id="granditem"><?php echo number_format($granditem,0); ?></span></td>
                                    <td class="text-end"><span id="grandtotal"><?php echo number_format($grandtotal,2); ?></span></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-4 ">
                            <div class="input-group mt-3">
                                <span class="input-group-text">สถานะ</span>
                                <select name="statusid" id="statusid" class="form-control" required></select>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-4 offset-4">
                            <input type="submit" value="บันทึกข้อมูล" class="btn btn-primary">
                            <a href="manageinvoice.php" class="btn btn-secondary">ย้อนกลับ</a>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <?php include '../center/linkjs.php'; ?>
    <script>
        $(document).ready(function() {
            var customerid = "<?php echo $customerid; ?>"
            $.ajax({
                url: 'getcustomer.php',
                method: 'post',
                data: ({customerid: customerid}),
                success: function(result) {
                    $("#customerid").html(result)
                }
            });
            var statusid = "<?php echo $statusid; ?>"
            $.ajax({
                url: 'getstatus.php',
                method: 'post',
                data: ({statusid: statusid}),
                success: function(result) {
                    $("#statusid").html(result)
                }
            });
        });
    </script>
</body>

</html>