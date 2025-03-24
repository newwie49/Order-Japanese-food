<?php
@session_start();
include '../db/linkdb.php';
$sql = "SELECT rm.rmid , rm.rmname, rt.rmtname ,st.statusname
            FROM tbrm rm
            LEFT JOIN tbrmt rt ON rm.rmtid = rt.rmtid
            LEFT JOIN tbstatus st ON rm.statusid = st.statusid
            WHERE rm.statusid IN ('10')
            ORDER BY rm.rmid*1 DESC";
$query = $conn->query($sql);
// echo $sql; exit;  
$rmidList=$rmnameList=$rmtnameList=$statusnameList=array();
if($query->num_rows > 0) {
    while ($rs = $query ->fetch_assoc()) {
        array_push($rmidList,$rs['rmid']);
        array_push($rmnameList,$rs['rmname']);
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
    <title>rm</title>
    
     <?php include ('../center/linkcss.php'); ?>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <?php include ('../center/menu.php'); ?>
                    <h1 class = "text-center">เลือกสินค้า</h1>
                    <form action="saveitem.php" method="post">
                        <table class = "table table-striped"    >
                            <thead class = "bg-primary text-white" >
                                <th>#</th>
                                <th>รหัสสินค้า</th>
                                <th>ชื่อสินค้า</th>
                                <th>หน่วยนับ</th>
                                <th>เลือก</th>
                              
                            </thead>
                            <tbody>
                                <?php
                                if(count($rmidList) > 0) {
                                    for($i=0; $i < count($rmidList); $i++) {
                                        $item=$i+1;
                                        $rmid = $rmidList[$i];
                                        $rmname = $rmnameList[$i];
                                        $rmtname = $rmtnameList[$i];
    
    
                                        ?>
                                        <tr>
                                            <td><?php echo $item; ?></td>
                                            <td><?php echo $rmid; ?></td>
                                            <td><?php echo $rmname; ?></td>
                                            <td><?php echo $rmtname; ?></td>
                                            
                                            <td><input type="checkbox" name="selecteditem[]" id="" value="<?php echo $rmid; ?> "></td>
                                        </tr>
    
                                    <?php }
                                    
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="5" class ="text-center" >ไม่มีข้อมูล</td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                        <div class="row mt-1">
                        <div class="col-4 offset-4">
                        
                        <input type="submit" value="บันทึกข้อมูล" class = " btn btn-primary ">
                        <a href="addsupplier.php" class = " btn btn-secondary ">ย้อนกลับ</a>
                        
                        </div>
                    </div>

                    </form>
                <div class="d-grid justify-content-md-end">
                </div>
            </div>

        </div>
    
    </div>
    
    
    <?php include ('../center/linkjs.php'); ?>    
</body>
</html>