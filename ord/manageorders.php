<?php
@session_start();

unset($_SESSION['ordrmid']);
unset($_SESSION['ordrmname']);
unset($_SESSION['ordrmtname']);
unset($_SESSION['ordrmprice']);
unset($_SESSION['ordrmqty']);

include '../db/linkdb.php';
$sql = "SELECT oh.ordid,oh.orddate,su.suppliername,oh.shipmentid,oh.shipmentdate,oh.statusid,st.statusname 
            FROM tbordheader oh 
            LEFT JOIN tbsupplier su ON oh.supplierid = su.supplierid 
            LEFT JOIN tbstatus st ON oh.statusid = st.statusid  
            ORDER BY oh.ordid*1 DESC";
$query = $conn->query($sql);
// echo $sql; exit();
$ordidList=$orddateList=$suppliernameList=$shipmentdateList=$statusidList=$statusnameList=array();
if($query->num_rows > 0) {
    while ($rs = $query->fetch_assoc()) {
        array_push($ordidList,$rs['ordid']);
        array_push($orddateList,$rs['orddate']);
        array_push($suppliernameList,$rs['suppliername']);
        array_push($shipmentdateList,$rs['shipmentdate']);
        array_push($statusidList,$rs['statusid']);
        array_push($statusnameList,$rs['statusname']);
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ใบสั่งซื้อ</title>
    <?php include '../center/linkcss.php'; ?>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <?php include '../center/menu.php'; ?>
                <h1 class="text-center">จัดการข้อมูลการสั่งซื้อ</h1>
                <div class="d-grid justify-content-md-end">
                    <a href="addord.php" class="btn btn-primary">เพิ่มข้อมูล</a>
                </div>
                <table id="mytbl" class="table table-striped">
                    <thead class="table-primary">
                        <th>#</th>
                        <th>วันที่_ซื้อขาย</th>
                        <th>ร้านจัดจำหน่าย</th>
                        <th>วันที่ส่ง</th>
                        <th>สถานะการจัดส่ง</th>
                        <th>แก้ไข</th>
                        <th>เรียกดู</th>
                        <th>ยกเลิก</th>
                    </thead>
                    <tbody>
                        <?php
                        if(count($ordidList) > 0) {
                            for($i=0; $i < count($ordidList); $i++) {
                                $item=$i+1;
                                $ordid = $ordidList[$i];
                                $orddate = new DateTime($orddateList[$i]);
                                $suppliername = $suppliernameList[$i];
                                $shipmentdate = new DateTime($shipmentdateList[$i]);
                                $statusid = $statusidList[$i];
                                $statusname = $statusnameList[$i];
                                ?>
                                <tr>
                                    <td><?php echo $item; ?></td>
                                    <!-- <td><?php echo $ordid; ?></td> -->
                                    <td><?php echo date_format($orddate,'d-m-Y'); ?></td>
                                    <td><?php echo $suppliername; ?></td>
                                    <?php if ( $statusid == "62") { ?>
                                    <td><?php echo date_format($shipmentdate,'d-m-Y');?></td>
                                    <?php } else { ?> 
                                        <td></td>
                                    <?php } ?>
                                    <td><?php echo $statusname; ?></td>
                                    <?php if($_SESSION['positionid'] == "" && $statusid == "61") { ?>
                                        <td><a class="btn btn-success" href="editord.php?id=<?php echo $ordid; ?>"><i class="fa-solid fa-pen-to-square"></i></a></td>
                                    <?php } else { 
                                        if($_SESSION['positionid'] == "1" && $statusid == "61") {  ?>
                                            <td><a class="btn btn-success" href="approveord.php?id=<?php echo $ordid; ?>"><i class="fa-solid fa-pen-to-square"></i></a></td>
                                    <?php } else { ?> 
                                        <td></td>
                                    <?php } 
                                    } ?>
                                    <td><a class="btn btn-info" href="vieword.php?id=<?php echo $ordid; ?>"><i class="fa-regular fa-eye"></i></a></td>
                                    <td><a class="btn btn-danger" href="cancelord.php?id=<?php echo $ordid; ?>"><i class="bi bi-trash"></i></a></td>
                                </tr>
                                
                            <?php }
                        } 
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>    
    <?php include '../center/linkjs.php'; ?>
    <script>
        $(document).ready(function() {

        });
    </script>
</body>
</html>