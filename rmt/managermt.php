<?php
@session_start();
include '../db/linkdb.php';
$sql = "SELECT rt.rmtid , rt.rmtname ,st.statusname
            FROM tbrmt rt
            LEFT JOIN tbstatus st ON rt.statusid = st.statusid
            ORDER BY rt.rmtid*1 DESC";
$query = $conn->query($sql);
// echo $sql; exit;  
$rmtidList=$rmtnameList=$statusnameList=array();
if($query->num_rows > 0) {
    while ($rs = $query ->fetch_assoc()) {
        array_push($rmtidList,$rs['rmtid']);
        array_push($rmtnameList,$rs['rmtname']);
        array_push($statusnameList,$rs['statusname']);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>rmt</title>
    
     <?php include ('../center/linkcss.php'); ?>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <?php include ('../center/menu.php'); ?>
                    <h1 class = "text-center">จัดการประเภท</h1>
                <div class="d-grid justify-content-md-end">
                <a href="addrmt.php"class ="btn btn-primary">เพิ่มข้อมูล</a>
                </div>
                    <table class = "table table-striped"    >
                        <thead class = "bg-primary text-white" >
                            <th>#</th>
                            <th>รหัสประเภท</th>
                            <!-- <th>ชื่อประเภท</th> -->
                            <th>สถานะ</th>
                            <th>แก้ไข</th>
                            <!-- <th>แสดง</th> -->
                            <th>ยกเลิก</th>
                        </thead>
                        <tbody>
                            <?php
                            if(count($rmtidList) > 0) {
                                for($i=0; $i < count($rmtidList); $i++) {
                                    $item=$i+1;
                                    $rmtid = $rmtidList[$i];
                                    $rmtname = $rmtnameList[$i];
                                    $statusname = $statusnameList[$i];


                                    ?>
                                    <tr>
                                        <td><?php echo $item; ?></td>
                                        <!-- <td><?php echo $rmtid; ?></td> -->
                                        <td><?php echo $rmtname; ?></td>
                                        <td><?php echo $statusname; ?></td>
                                        <td><a class="btn btn-success" href="editrmt.php?id=<?php echo $rmtid; ?>"><i class="fa-solid fa-pen-to-square"></i></a></td>
                                        <!-- <td><a class="btn btn-info" href="viewrmt.php?id=<?php echo $rmtid; ?>"><i class="fa-solid fa-eye"></i></a></td> -->
                                        <td><a class="btn btn-danger" href="cancelrmt.php?id=<?php echo $rmtid; ?>"><i class="bi bi-trash"></i></a></td>

                                    </tr>

                                <?php }
                                
                            } else {
                                ?>
                                <tr>
                                    <td colspan="6" class ="text-center" >ไม่มีข้อมูล</td>
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