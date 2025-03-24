<?php
@session_start();
$_SESSION['mode'] = "edit";
include '../db/linkdb.php';

// Get order ID from query parameters
$ordid = $_GET['id'] ?? '';

// Prepare and execute SQL query for order header
$sqlH = "SELECT oh.orddate, oh.supplierid, su.suppliername, oh.statusid, st.statusname 
         FROM tbordheader oh 
         LEFT JOIN tbsupplier su ON oh.supplierid = su.supplierid 
         LEFT JOIN tbstatus st ON oh.statusid = st.statusid 
         WHERE oh.ordid = ?";
$stmtH = $conn->prepare($sqlH);
$stmtH->bind_param('s', $ordid);
$stmtH->execute();
$rsH = $stmtH->get_result()->fetch_assoc();

// Extract data from query result
$orddate = new DateTime($rsH['orddate']);
$supplierid = $rsH['supplierid'];
$suppliername = $rsH['suppliername'];
$statusid = $rsH['statusid'];
$statusname = $rsH['statusname'];

// Prepare and execute SQL query for order details
$sqlD = "SELECT od.goodsid, g.goodsname, un.unitname, od.cost, od.goodsqty 
         FROM tborddetail od 
         LEFT JOIN tbgoods g ON od.goodsid = g.goodsid 
         LEFT JOIN tbunit un ON g.unitid = un.unitid 
         WHERE od.ordid = ?";
$stmtD = $conn->prepare($sqlD);
$stmtD->bind_param('s', $ordid);
$stmtD->execute();
$queryD = $stmtD->get_result();

$goodsidList = $goodsnameList = $unitnameList = $costList = $goodsqtyList = [];
while ($rsD = $queryD->fetch_assoc()) {
    $goodsidList[] = $rsD['goodsid'];
    $goodsnameList[] = $rsD['goodsname'];
    $unitnameList[] = $rsD['unitname'];
    $costList[] = $rsD['cost'];
    $goodsqtyList[] = $rsD['goodsqty'];
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
                <h1 class="text-center">อนุมัติใบสั่งซื้อ</h1>
                <form action="saveord.php" method="post">
                    <div class="row">
                        <div class="col-3 offset-9">
                            <div class="input-group mt-3">
                                <span class="input-group-text">เลขที่</span>
                                <input type="text" class="form-control" name="ordid" id="ordid" value="<?php echo htmlspecialchars($ordid); ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="input-group mt-3">
                                <span class="input-group-text">ผู้ขาย</span>
                                <input type="text" name="supplierid" id="supplierid" value="<?php echo htmlspecialchars($suppliername); ?>" readonly>
                            </div>
                        </div>
                        <div class="col-3 offset-5">
                            <div class="input-group mt-3">
                                <span class="input-group-text">วันที่</span>
                                <input type="text" class="form-control" name="orddate" id="orddate" value="<?php echo htmlspecialchars($orddate->format('d-m-Y')); ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>รหัสสินค้า</th>
                                    <th>ชื่อสินค้า</th>
                                    <th>หน่วย</th>
                                    <th>ราคาซื้อ</th>
                                    <th>จำนวน</th>
                                    <th>เป็นเงิน</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $item = 0; 
                                $granditem = $grandtotal = 0;
                                for ($i = 0; $i < count($goodsidList); $i++) {
                                    $goodsid = $goodsidList[$i];
                                    $goodsname = $goodsnameList[$i];
                                    $unitname = $unitnameList[$i];
                                    $cost = $costList[$i];
                                    $goodsqty = $goodsqtyList[$i];
                                    $total = $cost * $goodsqty;
                                    $item++;
                                    $granditem += $goodsqty;
                                    $grandtotal += $total;
                                    ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($item); ?></td>
                                        <td><?php echo htmlspecialchars($goodsid); ?></td>
                                        <td><?php echo htmlspecialchars($goodsname); ?></td>
                                        <td><?php echo htmlspecialchars($unitname); ?></td>
                                        <td class="text-end"><?php echo htmlspecialchars(number_format($cost, 2)); ?></td>
                                        <td class="text-end"><?php echo htmlspecialchars(number_format($goodsqty, 0)); ?></td>
                                        <td class="text-end"><?php echo htmlspecialchars(number_format($total, 2)); ?></td>
                                    </tr>
                                    <?php 
                                }
                            ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5">รวม <?php echo htmlspecialchars($item); ?> รายการ</td>
                                    <td class="text-end" id="granditem"><?php echo htmlspecialchars(number_format($granditem, 0)); ?></td>
                                    <td class="text-end" id="grandtotal"><?php echo htmlspecialchars(number_format($grandtotal, 2)); ?></td>
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
                            <a href="manageorders.php" class="btn btn-secondary">ย้อนกลับ</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php include '../center/linkjs.php'; ?>
    <script>
        $(document).ready(function() {
            var supplierid = "<?php echo $supplierid; ?>"
            $.ajax({
                url: 'getsupplier.php',
                method: 'post',
                data: ({supplierid: supplierid}),
                success: function(result) {
                    $("#supplierid").html(result)
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
