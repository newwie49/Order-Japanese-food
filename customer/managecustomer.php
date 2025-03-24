<?php
@session_start();
include '../db/linkdb.php';
$sql = "SELECT cu.customerid,cu.customername,st.statusname  
            FROM tbcustomer cu
            LEFT JOIN tbstatus st ON cu.statusid = st.statusid  
            ORDER BY cu.customerid*1 DESC";
$query = $conn->query($sql);
// echo $sql; exit();
$customeridList=$customernameList=$statusnameList=array();
if($query->num_rows > 0) {
    while ($rs = $query->fetch_assoc()) {
        array_push($customeridList,$rs['customerid']);
        array_push($customernameList,$rs['customername']);
        array_push($statusnameList,$rs['statusname']);
    }
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
                <h1 class="text-center">จัดการลูกค้า</h1>
                <div class="d-grid justify-content-md-end">
                    <a href="addcustomer.php" class="btn btn-primary">เพิ่มข้อมูล</a>
                </div>
                <table class="table table-striped">
                    <thead class="table-primary">
                        <th>#</th>
                        <th>รหัสลูกค้า</th>
                        <th>ชื่อลูกค้า</th>
                        <th>สถานะ</th>
                        <th>แก้ไข</th>
                        <th>เรียกดู</th>
                    </thead>
                    <tbody>
                        <?php
                        if(count($customeridList) > 0) {
                            for($i=0; $i < count($customeridList); $i++) {
                                $item=$i+1;
                                $customerid = $customeridList[$i];
                                $customername = $customernameList[$i];
                                $statusname = $statusnameList[$i];
                                ?>
                                <tr>
                                    <td><?php echo $item; ?></td>
                                    <td><?php echo $customerid; ?></td>
                                    <td><?php echo $customername; ?></td>
                                    <td><?php echo $statusname; ?></td>
                                    <td><a class="btn btn-success" href="editcustomer.php?id=<?php echo $customerid; ?>"><i class="fa-solid fa-pen-to-square"></i></a></td>
                                    <td><a class="btn btn-info" href="viewcustomer.php?id=<?php echo $customerid; ?>"><i class="fa-regular fa-eye"></i></a></td>
                                    
                                </tr>
                                
                            <?php }
                        } else {
                            ?>
                            <tr>
                                <td colspan="6" class="text-center">ไม่มีข้อมูล</td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>    
    <?php include '../center/linkjs.php'; ?>
</body>
</html>