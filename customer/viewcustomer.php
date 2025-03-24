<?php
@session_start();
$_SESSION['mode'] = "view";
include '../db/linkdb.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Use prepared statements to avoid SQL injection
    $stmt = $conn->prepare("SELECT cu.customerid, cu.customername, st.statusname
                             FROM tbcustomer cu
                             JOIN tbstatus st ON cu.statusid = st.statusid
                             WHERE cu.customerid = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $rs = $result->fetch_assoc();
        $customerid = $rs['customerid'];
        $customername = $rs['customername'];
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
    <title>customer</title>
    <?php include_once('../center/linkcss.php');?>
</head>
<body>
<div class="container-fluid">
        <div class="row">
            <div class="col-12">
            <?php include_once('../center/menu.php');?>
            <h1 class="text-center">แสดงข้อมูล</h1>
            <form action="savecustomer.php" method="post">
            <div class="row">
                <div class="col-4 offset-4">
                    <div class="input-group mt-3">
                        <span class="input-group-text" id="basic-addon1">รหัสตำแหน่ง</span>
                        <input type="text" class="form-control" placeholder="" name="customerid" id="customerid" value="<?php echo $customerid?>" readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-4 offset-4">
                    <div class="input-group mt-3">
                        <span class="input-group-text" id="basic-addon1">ชื่อตำแหน่ง</span>
                        <input type="text" class="form-control" placeholder="" name="customername" id="customername" value="<?php echo $customername?>"readonly>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-4 offset-4">
                        <a href="managecustomer.php" class="btn btn-secondary">ย้อนกลับ</a>             
                </div>
            </div>    
            </from>

            </div>
        </div>
    </div>
<?php include_once('../center/linkjs.php');?>
</body>
</html>