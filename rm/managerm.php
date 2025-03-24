<?php
@session_start();
include '../db/linkdb.php';
$sql = "SELECT rm.rmid , rm.rmname, rt.rmtname , un.unitname , rm.rmprice ,rm.rmquantity ,st.statusname
            FROM tbrm rm
            LEFT JOIN tbrmt rt ON rm.rmtid = rt.rmtid 
            LEFT JOIN tbstatus st ON rm.statusid = st.statusid
            LEFT JOIN tbunit un ON rm.unitid = un.unitid
            ORDER BY rm.rmid*1 DESC";
$query = $conn->query($sql);
// echo $sql; exit;  
$rmidList=$rmnameList=$rmtnameList=$unitnameList=$rmpriceList=$rmquantityList=$statusnameList=array();
if($query->num_rows > 0) {
    while ($rs = $query ->fetch_assoc()) {
        array_push($rmidList,$rs['rmid']);
        array_push($rmnameList,$rs['rmname']);
        array_push($rmtnameList,$rs['rmtname']);
        array_push($unitnameList,$rs['unitname']);
        array_push($rmpriceList,$rs['rmprice']);
        array_push($rmquantityList,$rs['rmquantity']);
        array_push($statusnameList,$rs['statusname']);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>rm</title>
    
     <?php include ('../center/linkcss.php'); ?>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <?php include ('../center/menu.php'); ?>
                    <h1 class = "text-center">จัดการวัตถุดิบ</h1>
                <div class="d-grid justify-content-md-end">
                <a href="addrm.php"class ="btn btn-primary">เพิ่มข้อมูล</a>
                </div>
                    <table class = "table table-striped"    >
                        <thead class = "bg-primary text-white" >
                            <th>#</th>
                            <th>ชื่อวัตถุดิบ</th>
                            <th>จำนวน</th>
                            <th>หน่วยวัด</th>
                            <th>ราคา</th>
                            <th>แก้ไข</th>
                            <!-- <th>แสดง</th> -->
                            <th>ยกเลิก</th>
                        </thead>
                        <tbody>
                            <?php
                            if(count($rmidList) > 0) {
                                for($i=0; $i < count($rmidList); $i++) {
                                    $item=$i+1;
                                    $rmid = $rmidList[$i];
                                    $rmname = $rmnameList[$i];
                                    $rmquantity = $rmquantityList[$i];
                                    // $rmtname = $rmtnameList[$i];
                                    $unitname = $unitnameList[$i];
                                    $rmprice = $rmpriceList[$i];
                                    $statusname = $statusnameList[$i];


                                    ?>
                                    <tr>
                                        <td><?php echo $item; ?></td>
                                        <td><?php echo $rmname; ?></td>
                                        <td><?php echo $rmquantity; ?></td>
                                        <td><?php echo $unitname; ?></td>
                                        <td><?php echo $rmprice; ?></td>
                                        <td><a class="btn btn-success" href="editrm.php?id=<?php echo $rmid; ?>"><i class="fa-solid fa-pen-to-square"></i></a></td>
                                        <!-- <td><a class="btn btn-info" href="viewrm.php?id=<?php echo $rmid; ?>"><i class="fa-solid fa-eye"></i></a></td> -->
                                        <td><a class="btn btn-danger" href="cancelrm.php?id=<?php echo $rmid; ?>"><i class="bi bi-trash"></i></a></td>
                                        
                                    </tr>

                                <?php }
                                
                            } else {
                                ?>
                                <tr>
                                    <td colspan="8" class ="text-center" >ไม่มีข้อมูล</td>
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