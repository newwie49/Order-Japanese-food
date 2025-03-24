<?php
@session_start();
include '../db/linkdb.php';
$sql = "SELECT su.supplierid , su.suppliername ,st.statusname
            FROM tbsupplier su
            LEFT JOIN tbstatus st ON su.statusid = st.statusid
            ORDER BY su.supplierid*1 DESC";
$query = $conn->query($sql);
// echo $sql; exit;  
$supplieridList=$suppliernameList=$statusnameList=array();
if($query->num_rows > 0) {
    while ($rs = $query ->fetch_assoc()) {
        array_push($supplieridList,$rs['supplierid']);
        array_push($suppliernameList,$rs['suppliername']);
        array_push($statusnameList,$rs['statusname']);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>supplier</title>
    
     <?php include ('../center/linkcss.php'); ?>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <?php include ('../center/menu.php'); ?>
                    <h1 class = "text-center">จัดการผู้ขาย</h1>
                <div class="d-grid justify-content-md-end">
                <a href="addsupplier.php"class ="btn btn-primary">เพิ่มข้อมูล</a>
                </div>
                    <table class = "table table-striped"    >
                        <thead class = "bg-primary text-white" >
                            <th>#</th>
                            <th>รหัสผู้ขาย</th>
                            <th>ชื่อผู้ขาย</th>
                            <th>สถานะ</th>
                            <th>แก้ไข</th>
                            <th>แสดง</th>
                        </thead>
                        <tbody>
                            <?php
                            if(count($supplieridList) > 0) {
                                for($i=0; $i < count($supplieridList); $i++) {
                                    $item=$i+1;
                                    $supplierid = $supplieridList[$i];
                                    $suppliername = $suppliernameList[$i];
                                    $statusname = $statusnameList[$i];


                                    ?>
                                    <tr>
                                        <td><?php echo $item; ?></td>
                                        <td><?php echo $supplierid; ?></td>
                                        <td><?php echo $suppliername; ?></td>
                                        <td><?php echo $statusname; ?></td>
                                        <td><a class="btn btn-success" href="editsupplier.php?id=<?php echo $supplierid; ?>"><i class="fa-solid fa-pen-to-square"></i></a></td>
                                        <td><a class="btn btn-info" href="viewsupplier.php?id=<?php echo $supplierid; ?>"><i class="fa-solid fa-eye"></i></a></td>
                                        
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