<?php
@session_start();
$_SESSION['mode'] = "view";
include '../db/linkdb.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Use prepared statements to avoid SQL injection
    $stmt = $conn->prepare("SELECT un.userid, un.username, st.statusid, po.positionid, un.userpass
                             FROM tbuser un
                             LEFT JOIN tbstatus st ON un.statusid = st.statusid
                             LEFT JOIN tbposition po ON un.positionid = po.positionid
                             WHERE un.userid = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $rs = $result->fetch_assoc();
        $userid = $rs['userid'];
        $username = $rs['username'];
        $userpass = $rs['userpass'];
        $statusid = $rs['statusid'];      
        $positionid = $rs['positionid'];
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <?php include_once('../center/linkcss.php');?>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <?php include_once('../center/menu.php');?>
            <h1 class="text-center">แก้ไขข้อมูล</h1>
            <form action="saveuser.php" method="post">
                <div class="row">
                    <div class="col-4 offset-4">
                        <div class="input-group mt-3">
                            <span class="input-group-text" id="basic-addon1">รหัสผู้ใช้</span>
                            <input type="text" class="form-control" name="userid" id="userid" value="<?php echo htmlspecialchars($userid); ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4 offset-4">
                        <div class="input-group mt-3">
                            <span class="input-group-text" id="basic-addon1">ชื่อผู้ใช้</span>
                            <input type="text" class="form-control" name="username" id="username" value="<?php echo htmlspecialchars($username); ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4 offset-4">
                        <div class="input-group mt-3">
                            <span class="input-group-text" id="basic-addon1">รหัสผ่าน</span>
                            <input type="text" class="form-control" name="userpass" id="userpass" value="<?php echo htmlspecialchars($userpass); ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4 offset-4">
                        <div class="input-group mt-3">
                            <span class="input-group-text" id="basic-addon1">ตำแหน่ง</span>
                            <select name="positionid" id="positionid" class="form-control" required></select>
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
                        <a href="manageuser.php" class="btn btn-secondary">ย้อนกลับ</a>             
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
            url: 'getposition.php',
            method: 'post',
            dataType: 'html',
            success: function(result) {
                $("#positionid").html(result);
                $("#positionid").val("<?php echo htmlspecialchars($positionid); ?>"); 
            }
        });

        $.ajax({
            url: 'getstatus.php',
            method: 'post',
            dataType: 'html',
            success: function(result) {
                $("#statusid").html(result);
                $("#statusid").val("<?php echo htmlspecialchars($statusid); ?>"); 
            }
        });
    });
</script>
</body>
</html>
