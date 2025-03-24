<?php
@session_start();
$_SESSION['mode'] = "view";
include '../db/linkdb.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Use prepared statements to avoid SQL injection
    $stmt = $conn->prepare("SELECT rm.rmid , rm.rmname, rt.rmtname , un.unitname , rm.rmprice ,rm.rmquantity ,st.statusname
                            FROM tbrm rm
                            LEFT JOIN tbrmt rt ON rm.rmtid = rt.rmtid 
                            LEFT JOIN tbstatus st ON rm.statusid = st.statusid
                            LEFT JOIN tbunit un ON rm.unitid = un.unitid
                             WHERE rm.rmid = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $rs = $result->fetch_assoc();
        $rmid = $rs['rmid'];
        $rmname = $rs['rmname'];
        $rmtname = $rs['rmtname'];
        $unitname = $rs['unitname'];
        $rmprice = $rs['rmprice'];
        $rmquantity = $rs['rmquantity'];
        $statusname = $rs['statusname'];
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>rm</title>
    <?php include_once('../center/linkcss.php');?>
</head>
<body>
<div class="container-fluid">
        <div class="row">
            <div class="col-12">
            <?php include_once('../center/menu.php');?>
            <h1 class="text-center">แสดงข้อมูล</h1>
            <form action="saverm.php" method="post">
            <div class="row">
                <div class="col-4 offset-4">
                    <div class="input-group mt-3">
                        <span class="input-group-text" id="basic-addon1">รหัสสินค้า</span>
                        <input type="text" class="form-control" placeholder="" name="rmid" id="rmid" value="<?php echo $rmid?>" readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-4 offset-4">
                    <div class="input-group mt-3">
                        <span class="input-group-text" id="basic-addon1">ชื่อสินค้า</span>
                        <input type="text" class="form-control" placeholder="" name="rmname" id="rmname" value="<?php echo $rmname?>"readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-4 offset-4">
                    <div class="input-group mt-3">
                        <span class="input-group-text" id="basic-addon1">ประเภท</span>
                        <input type="text" class="form-control" placeholder="" name="rmtname" id="rmtname" value="<?php echo $rmtname?>"readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-4 offset-4">
                    <div class="input-group mt-3">
                        <span class="input-group-text" id="basic-addon1">หน่วยวัด</span>
                        <input type="text" class="form-control" placeholder="" name="unitname" id="unitname" value="<?php echo $unitname?>"readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-4 offset-4">
                    <div class="input-group mt-3">
                        <span class="input-group-text" id="basic-addon1">ราคา</span>
                        <input type="text" class="form-control" placeholder="" name="rmprice" id="rmprice" value="<?php echo $rmprice?>"readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-4 offset-4">
                    <div class="input-group mt-3">
                        <span class="input-group-text" id="basic-addon1">จำนวน</span>
                        <input type="text" class="form-control" placeholder="" name="rmquantity" id="rmquantity" value="<?php echo $rmquantity?>"readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-4 offset-4">
                    <div class="input-group mt-3">
                        <span class="input-group-text" id="basic-addon1">สถานะ</span>
                        <input type="text" class="form-control" placeholder="" name="statusname" id="statusname" value="<?php echo $statusname?>"readonly>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-4 offset-4">
                        <a href="managerm.php" class="btn btn-secondary">ย้อนกลับ</a>             
                </div>
            </div>    
            </from>

            </div>
        </div>
    </div>
</body>
</html>