<?php
@session_start();
include '../db/linkdb.php';
$sql = "SELECT ih.invid,ih.invdate,cu.customername,ih.statusid,st.statusname 
            FROM tbinvheader ih 
            LEFT JOIN tbcustomer cu ON ih.customerid = cu.customerid 
            LEFT JOIN tbstatus st ON ih.statusid = st.statusid  
            ORDER BY ih.invid*1 DESC";
$query = $conn->query($sql);
// echo $sql; exit();
$ordidList = $orddateList = $customernameList = $statusidList = $statusnameList = array();
if ($query->num_rows > 0) {
    while ($rs = $query->fetch_assoc()) {
        array_push($ordidList, $rs['invid']);
        array_push($orddateList, $rs['invdate']);
        array_push($customernameList, $rs['customername']);
        array_push($statusidList, $rs['statusid']);
        array_push($statusnameList, $rs['statusname']);
    }
}
unset($_SESSION['customerid']);
unset($_SESSION['invdate']);
unset($_SESSION['invgoodsid']);
unset($_SESSION['invgoodsname']);
unset($_SESSION['invunitname']);
unset($_SESSION['invprice']);
unset($_SESSION['invbalance']);
unset($_SESSION['invgoodsqty']);
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
                <h1 class="text-center">ใบขาย</h1>
                <div class="d-grid justify-content-md-end">
                    <a href="addinv.php" class="btn btn-primary">เพิ่มใบขาย</a>
                </div>
                <table id="mytbl" class="table table-striped">
                    <thead class="table-primary">
                        <th>#</th>
                        <th>เลขที่ใบขาย</th>
                        <th>วันที่</th>
                        <th>ลูกค้า</th>
                        <th>สถานะ</th>
                        <!-- <th>แก้ไข</th> -->
                        <th>เรียกดู</th>
                        <!-- <th>ยกเลิก</th> -->
                    </thead>
                    <tbody>
                        <?php
                        if (count($ordidList) > 0) {
                            for ($i = 0; $i < count($ordidList); $i++) {
                                $item = $i + 1;
                                $invid = $ordidList[$i];
                                $invdate = new DateTime($orddateList[$i]);

                                $customername = $customernameList[$i];
                                $statusid = $statusidList[$i];
                                $statusname = $statusnameList[$i];
                        ?>
                                <tr>
                                    <td><?php echo $item; ?></td>
                                    <td><?php echo $invid; ?></td>
                                    <td><?php echo date_format($invdate, 'd-m-Y'); ?></td>
                                    <td><?php echo $customername; ?></td>
                                    <td><?php echo $statusname; ?></td>
                                    <!-- <td><a class="btn btn-success" href="editinv.php?id=<?php echo $invid; ?>"><i class="fa-solid fa-pen-to-square"></i></a></td> -->
                                    <td><a class="btn btn-info" href="viewinv.php?id=<?php echo $invid; ?>"><i class="fa-regular fa-eye"></i></a></td>
                                    <!-- <td><a class="btn btn-danger" href="cancelinv.php?id=<?php echo $invid; ?>"><i class="fa-solid fa-x"></i></a></td> -->

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
            let $mytbl = $("#mytbl");
            $mytbl.dataTable({
                
            });
        });
    </script>
</body>

</html>