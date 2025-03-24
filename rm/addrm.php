<?php
@session_start();
$_SESSION['mode'] = "add";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>addraw material</title>
    <?php include ('../center/linkcss.php'); ?>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <?php include ('../center/menu.php'); ?>
                    <h1>เพิ่มข้อมูล</h1>
                    <form action="saverm.php" method="post">
                     <div class="row">
                        <div class="col-4 offset-4">
                        <div class="input-group mt-3">
                            <span class="input-group-text" id="basic-addon1">รหัสสินค้า</span>
                            <input type="text" class="form-control" placeholder="" name="rmid" id="rmid" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4 offset-4">
                        <div class="input-group mt-3">
                            <span class="input-group-text" id="basic-addon1">ชื่อสินค้า</span>
                            <input type="text" class="form-control" placeholder="" name="rmname" id="rmid" >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4 offset-4">
                        <div class="input-group mt-3">
                            <span class="input-group-text" id="basic-addon1">ประเภท</span>
                            <select name="rmtid" id="rmtid" class="form-control" required></select>
                        </div>
                        </div>
                    </div>    
                    <div class="row">
                        <div class="col-4 offset-4">
                        <div class="input-group mt-3">
                            <span class="input-group-text" id="basic-addon1">หน่วยวัด</span>
                            <select name="unitid" id="unitid" class="form-control" required></select>
                        </div>
                        </div>
                    </div>    
                    <div class="row">
                        <div class="col-4 offset-4">
                        <div class="input-group mt-3">
                            <span class="input-group-text" id="basic-addon1">ราคา</span>
                            <td class="text-center"><input style="text-align: right;" rmid="<?php echo $rmid; ?>" class="form-control rmprice" type="number" name="rmprice" id="rmprice<?php echo $i; ?>" key="<?php echo $i; ?>" min="1" step=".01" value="<?php echo number_format($rmprice, 2); ?>" required></td>
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
                    <div class="row mt-1">
                        <div class="col-4 offset-4">
                        
                        <input type="submit" value="บันทึกข้อมูล" class = " btn btn-primary ">
                        <a href="managerm.php" class = " btn btn-secondary ">ย้อนกลับ</a>
                        
                        </div>
                    </div>    
                    </form>
                   
            </div>
        </div>
    </div>
    
        <?php include ('../center/linkjs.php'); ?>
        <script>
            $(document).ready(function() {
                $.ajax({
                    url:'getstatus.php',
                    method: 'post',
                    date: '',
                    success: function(result) {
                        $("#statusid").html(result)
                    } 
                });
            
                $.ajax({
                    url:'getrmt.php',
                    method: 'post',
                    date: '',
                    success: function(result) {
                        $("#rmtid").html(result)
                    } 
                });

                $.ajax({
                    url:'getunit.php',
                    method: 'post',
                    date: '',
                    success: function(result) {
                        $("#unitid").html(result)
                    } 
                });
            });
            
        </script>
</body>
</html>