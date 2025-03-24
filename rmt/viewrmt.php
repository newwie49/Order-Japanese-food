<?php
@session_start();
$_SESSION['mode'] = "view";
include '../db/linkdb.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Use prepared statements to avoid SQL injection
    $stmt = $conn->prepare("SELECT rt.rmtid, rt.rmtname, st.statusname
                             FROM tbrmt rt
                             JOIN tbstatus st ON rt.statusid = st.statusid
                             WHERE rt.rmtid = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $rs = $result->fetch_assoc();
        $rmtid = $rs['rmtid'];
        $rmtname = $rs['rmtname'];
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
    <title>rmt</title>
    <?php include_once('../center/linkcss.php');?>
</head>
<body>
<div class="container-fluid">
        <div class="row">
            <div class="col-12">
            <?php include_once('../center/menu.php');?>
            <h1 class="text-center">แสดงข้อมูล</h1>
            <form action="savermt.php" method="post">
            <div class="row">
                <div class="col-4 offset-4">
                    <div class="input-group mt-3">
                        <span class="input-group-text" id="basic-addon1">รหัสหน่วยนับ</span>
                        <input type="text" class="form-control" placeholder="" name="rmtid" id="rmtid" value="<?php echo $rmtid?>" readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-4 offset-4">
                    <div class="input-group mt-3">
                        <span class="input-group-text" id="basic-addon1">ชื่อหน่วยนับ</span>
                        <input type="text" class="form-control" placeholder="" name="rmtname" id="rmtname" value="<?php echo $rmtname?>"readonly>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-4 offset-4">
                        <a href="managermt.php" class="btn btn-secondary">ย้อนกลับ</a>             
                </div>
            </div>    
            </from>

            </div>
        </div>
    </div>
<?php include_once('../center/linkjs.php');?>
</body>
</html>