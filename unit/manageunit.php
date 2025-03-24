<?php
@session_start();
include '../db/linkdb.php';
$sql = "SELECT un.unitid , un.unitname ,st.statusname
            FROM tbunit un
            LEFT JOIN tbstatus st ON un.statusid = st.statusid
            ORDER BY un.unitid*1 DESC";
$query = $conn->query($sql);
// echo $sql; exit;  
$unitidList=$unitnameList=$statusnameList=array();
if($query->num_rows > 0) {
    while ($rs = $query ->fetch_assoc()) {
        array_push($unitidList,$rs['unitid']);
        array_push($unitnameList,$rs['unitname']);
        array_push($statusnameList,$rs['statusname']);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>unit</title>
    
    <?php include ('../center/linkcss.php'); ?>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
            <?php include ('../center/menu.php'); ?>
                    <h1 class = "text-center">จัดการหน่วยวัด</h1>
                <div class="d-grid justify-content-md-end">
                <a href="addunit.php"class ="btn btn-primary">เพิ่มข้อมูล</a>
                </div>
                    <table class = "table table-striped"    >
                        <thead class = "bg-primary text-white" >
                            <th>#</th>
                            <!-- <th>รหัสหน่วยวัด</th> -->
                            <th>ชื่อหน่วยวัด</th>
                            <th>สถานะ</th>
                            <th>แก้ไข</th>
                            <!-- <th>แสดง</th> -->
                            <th>ยกเลิก</th>
                        </thead>
                        <tbody>
                            <?php
                            if(count($unitidList) > 0) {
                                for($i=0; $i < count($unitidList); $i++) {
                                    $item=$i+1;
                                    $unitid = $unitidList[$i];
                                    $unitname = $unitnameList[$i];
                                    $statusname = $statusnameList[$i];


                                    ?>
                                    <tr>
                                        <td><?php echo $item; ?></td>
                                        <!-- <td><?php echo $unitid; ?></td> -->
                                        <td><?php echo $unitname; ?></td>
                                        <td><?php echo $statusname; ?></td>
                                        <td><a class="btn btn-success" href="editunit.php?id=<?php echo $unitid; ?>"><i class="fa-solid fa-pen-to-square"></i></a></td>
                                        <!-- <td><a class="btn btn-info" href="viewunit.php?id=<?php echo $unitid; ?>"><i class="fa-solid fa-eye"></i></a></td> -->
                                        <td><a class="btn btn-danger" href="cancelunit.php?id=<?php echo $unitid; ?>"><i class="bi bi-trash"></i></a></td>

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