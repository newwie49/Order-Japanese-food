<?php
session_start();
$_SESSION['mode'] = "edit";
include '../db/linkdb.php';

$rmid = $rmname = $rmtid = $unitid = $rmprice = $rmquantity = $statusid = ""; // Initialize variables

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Use prepared statements to avoid SQL injection
    $stmt = $conn->prepare("SELECT rm.rmid , rm.rmname, rm.rmtid, un.unitid, rm.rmprice, rm.rmquantity, rm.statusid
                             FROM tbrm rm
                             LEFT JOIN tbrmt rt ON rm.rmtid = rt.rmtid
                             LEFT JOIN tbunit un ON rm.unitid = un.unitid
                             LEFT JOIN tbstatus st ON rm.statusid = st.statusid
                             WHERE rm.rmid = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $rs = $result->fetch_assoc();
        $rmid = $rs['rmid'];
        $rmname = $rs['rmname'];
        $rmtid = $rs['rmtid'];
        $unitid = $rs['unitid'];
        $rmprice = $rs['rmprice'];
        $rmquantity = $rs['rmquantity'];
        $statusid = $rs['statusid'];
    }
    $stmt->close();
    $conn->close();
}
// if (isset($rmprice)) {
//     echo "ราคาวัตถุดิบ: " . $rmprice; // Debugging
// }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>editrm</title>
    <?php include_once('../center/linkcss.php'); ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <?php include_once('../center/menu.php'); ?>
            <h1 class="text-center">แก้ไขข้อมูล</h1>
            <form action="saverm.php" method="post">
                <div class="row">
                    <div class="col-4 offset-4">
                        <div class="input-group mt-3">
                            <span class="input-group-text" id="basic-addon1">รหัสวัตถุดิบ</span>
                            <input type="text" class="form-control" name="rmid" id="rmid" value="<?php echo htmlspecialchars($rmid); ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4 offset-4">
                        <div class="input-group mt-3">
                            <span class="input-group-text" id="basic-addon1">ชื่อวัตถุดิบ</span>
                            <input type="text" class="form-control" name="rmname" id="rmname" value="<?php echo htmlspecialchars($rmname); ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4 offset-4">
                        <div class="input-group mt-3">
                            <span class="input-group-text" id="basic-addon1">ประเภท</span>
                            <select name="rmtid" id="rmtid" class="form-control" required>
                                <!-- Options will be populated via AJAX -->
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4 offset-4">
                        <div class="input-group mt-3">
                            <span class="input-group-text" id="basic-addon1">หน่วยวัด</span>
                            <select name="unitid" id="unitid" class="form-control" required>
                                <!-- Options will be populated via AJAX -->
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4 offset-4">
                        <div class="input-group mt-3">
                            <span class="input-group-text" id="basic-addon1">ราคา</span>
                            <input style="text-align: right;" class="form-control rmprice" type="number" name="rmprice" id="rmprice" min="1" step=".01" value="<?php echo $rmprice; ?>" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-4 offset-4">
                        <div class="input-group mt-3">
                            <span class="input-group-text" id="basic-addon1">จำนวน</span>
                            <td class="text-center"><input style="text-align: right;" rmid="<?php echo $rmid; ?>" type="number" class="form-control rmquantity" name="rmquantity" id="rmquantity<?php echo $i; ?>" key="<?php echo $i; ?>" min="1" value="<?php echo number_format($rmquantity, 0); ?>" required></td>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4 offset-4">
                        <div class="input-group mt-3">
                            <span class="input-group-text" id="basic-addon1">สถานะ</span>
                            <select name="statusid" id="statusid" class="form-control" required>
                                <!-- Options will be populated via AJAX -->
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-4 offset-4">
                        <input type="submit" value="บันทึกข้อมูล" class="btn btn-primary">
                        <a href="managerm.php" class="btn btn-secondary">ย้อนกลับ</a>             
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
    // Fetch status options
    $.ajax({
        url: 'getstatus.php',
        method: 'post',
        success: function(result) {
            $("#statusid").html(result);
            $("#statusid").val("<?php echo $statusid; ?>"); // Set the selected value
        }
    });

    // Fetch rmt options
    $.ajax({
        url: 'getrmt.php',
        method: 'post',
        success: function(result) {
            $("#rmtid").html(result);
            $("#rmtid").val("<?php echo $rmtid; ?>"); // Set the selected value
        }
    });

    // Fetch unit options
    $.ajax({
        url: 'getunit.php',  // Assuming you have a file that fetches units
        method: 'post',
        success: function(result) {
            $("#unitid").html(result);
            $("#unitid").val("<?php echo $unitid; ?>"); // Set the selected value
        }
    });
});

</script>
</body>
</html>
