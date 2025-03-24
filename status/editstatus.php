<?php
@session_start();
$_SESSION['mode'] = "edit";
include '../db/linkdb.php';
if(isset($_GET['id'])){
    $id = $statusid = $_GET['id'];
    $sql = "SELECT statusid,statusname
    FROM tbstatus
    WHERE statusid = '$id'";
    //echo $sql; exit(); 
    $query = $conn->query($sql);
    if($query->num_rows > 0) {
        $rs = $query->fetch_assoc();
        $statusname = $rs['statusname'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>status</title>
    <?php include_once('../center/linkcss.php');?>
        <?php include_once('../db/linkdb.php');
        ?>
</head>
<body>
<div class="container-fluid">
        <div class="row">
            <div class="col-12">
            <?php include_once('../center/menu.php');?>
            <h1 class="text-center">แก้ไขข้อมูล</h1>
            <form action="savestatus.php" method="post">
            <div class="row">
                <div class="col-4 offset-4">
                    <div class="input-group mt-3">
                        <span class="input-group-text" id="basic-addon1">รหัสสถานะ</span>
                        <input type="text" class="form-control" placeholder="" name="statusid" id="statusid" value="<?php echo $statusid?>" readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-4 offset-4">
                    <div class="input-group mt-3">
                        <span class="input-group-text" id="basic-addon1">ชื่อสถานะ</span>
                        <input type="text" class="form-control" placeholder="" name="statusname" id="statusname" value="<?php echo $statusname?>">
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-4 offset-4">
                        <input type="submit" value="บันทึกข้อมูล" class="btn btn-primary">
                        <a href="managestatus.php" class="btn btn-secondary">ย้อนกลับ</a>             
                </div>
            </div>    
            </from>
            </div>
        </div>
</div>
    

<?php include_once('../center/linkjs.php');?>
</body>
</html>