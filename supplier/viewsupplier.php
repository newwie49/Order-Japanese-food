<?php
@session_start();
$_SESSION['mode'] = "view";
include '../db/linkdb.php';

$supplierid = $suppliername = $statusname = $statusid = '';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Use prepared statements to avoid SQL injection
    $stmt = $conn->prepare("SELECT un.supplierid, un.suppliername, un.statusid, st.statusname
                             FROM tbsupplier un
                             JOIN tbstatus st ON un.statusid = st.statusid
                             WHERE un.supplierid = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $rs = $result->fetch_assoc();
        $supplierid = $rs['supplierid'];
        $suppliername = $rs['suppliername'];
        $statusid = $rs['statusid'];
        $statusname = $rs['statusname'];
    } else {
        // Handle the case where no supplier is found
        echo "No supplier found with the given ID.";
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
    <title>Supplier</title>
    <?php include_once('../center/linkcss.php');?>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <?php include_once('../center/menu.php');?>
            <h1 class="text-center">แสดงข้อมูล</h1>
            <form action="savesupplier.php" method="post">
                <div class="row">
                    <div class="col-4 offset-4">
                        <div class="input-group mt-3">
                            <span class="input-group-text" id="basic-addon1">รหัสผู้ขาย</span>
                            <input type="text" class="form-control" placeholder="" name="supplierid" id="supplierid" value="<?php echo htmlspecialchars($supplierid); ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4 offset-4">
                        <div class="input-group mt-3">
                            <span class="input-group-text" id="basic-addon1">ชื่อผู้ขาย</span>
                            <input type="text" class="form-control" placeholder="" name="suppliername" id="suppliername" value="<?php echo htmlspecialchars($suppliername); ?>"readonly>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-4 offset-4">
                        <a href="managesupplier.php" class="btn btn-secondary">ย้อนกลับ</a>             
                    </div>
                </div>    
            </form>
        </div>
    </div>
</div>
<?php include_once('../center/linkjs.php');?>
</body>
</html>
