<?php
@session_start();
$_SESSION['mode'] = "edit";
include '../db/linkdb.php';

$rmtid = $rmtname = $statusid = '';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Use prepared statements to avoid SQL injection
    $stmt = $conn->prepare("SELECT rt.rmtid, rt.rmtname, rt.statusid, st.statusname
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
        $statusid = $rs['statusid'];
    } else {
        // Handle the case where no rmt is found
        echo "No rmt found with the given ID.";
        exit();
    }
    $stmt->close();
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
            <h1 class="text-center">แก้ไขข้อมูล</h1>
            <form action="savermt.php" method="post">
                <div class="row">
                    <div class="col-4 offset-4">
                        <div class="input-group mt-3">
                            <span class="input-group-text" id="basic-addon1">รหัสประเภท</span>
                            <input type="text" class="form-control" placeholder="" name="rmtid" id="rmtid" value="<?php echo htmlspecialchars($rmtid); ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4 offset-4">
                        <div class="input-group mt-3">
                            <span class="input-group-text" id="basic-addon1">ชื่อประเภท</span>
                            <input type="text" class="form-control" placeholder="" name="rmtname" id="rmtname" value="<?php echo htmlspecialchars($rmtname); ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4 offset-4">
                        <div class="input-group mt-3">
                            <span class="input-group-text" id="basic-addon1">สถานะ</span>
                            <select name="statusid" id="statusid" class="form-control" required></select>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-4 offset-4">
                        <input type="submit" value="บันทึกข้อมูล" class="btn btn-primary">
                        <a href="managermt.php" class="btn btn-secondary">ย้อนกลับ</a>             
                    </div>
                </div>    
            </form>
        </div>
    </div>
</div>
<?php include_once('../center/linkjs.php');?>
<script>
    $(document).ready(function() {
        $.ajax({
            url: 'getstatus.php',
            method: 'post',
            data: '',
            success: function(result) {
                $("#statusid").html(result);
                $("#statusid").val("<?php echo htmlspecialchars($statusid); ?>"); // Set the selected value
            }
        });
    });
</script>
</body>
</html>
