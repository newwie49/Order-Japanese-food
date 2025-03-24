<?php
@session_start();
include '../db/linkdb.php';
$sql = "SELECT statusid , statusname
            FROM tbstatus
            ORDER BY statusid*1 DESC";
$query = $conn->query($sql);
// echo $sql; exit;  
$statusidList=$statusnameList=array();
if($query->num_rows > 0) {
    while ($rs = $query ->fetch_assoc()) {
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
    <title>Status</title>
    
     <?php include ('../center/linkcss.php'); ?>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <?php include ('../center/menu.php'); ?>
                    <h1 class = "text-center">จัดการสถานะ</h1>
                <div class="d-grid justify-content-md-end">
                <a href="addstatus.php"class ="btn btn-primary">เพิ่มข้อมูล</a>
                </div>
                    <table class = "table table-striped"    >
                        <thead class = "bg-primary text-white" >
                            <th>#</th>
                            <th>รหัสสถานะ</th>
                            <th>ชื่อสถานะ</th>
                            <th>แก้ไข</th>
                            <!-- <th>แสดง</th> -->
                            <th>ยกเลิก</th>
                        </thead>
                        <tbody>
                            <?php
                            if(count($statusidList) > 0) {
                                for($i=0; $i < count($statusidList); $i++) {
                                    $item=$i+1;
                                    $statusid = $statusidList[$i];
                                    $statusname = $statusnameList[$i];


                                    ?>
                                    <tr>
                                        <td><?php echo $item; ?></td>
                                        <td><?php echo $statusid; ?></td>
                                        <td><?php echo $statusname; ?></td>
                                        <td><a class="btn btn-success" href="editstatus.php?id=<?php echo $statusid; ?>"><i class="fa-solid fa-pen-to-square"></i></a></td>
                                        <!-- <td><a class="btn btn-info" href="viewstatus.php?id=<?php echo $statusid; ?>"><i class="fa-solid fa-eye"></i></a></td> -->
                                        <td><a class="btn btn-danger" href="cancelstatus.php?id=<?php echo $statusid; ?>"><i class="bi bi-trash"></i></a></td>

                                    </tr>

                                <?php }
                                
                            } else {
                                ?>
                                <tr>
                                    <td colspan="3" class ="text-center" >ไม่มีข้อมูล</td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
            </div>

        </div>
    
    </div>
    
    
    <?php include ('../center/linkjs.php'); ?>    
</body>
</html>