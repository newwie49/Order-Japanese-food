<?php
@session_start();
$_SESSION['mode'] = "add";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>adduser</title>
    <?php include ('../center/linkcss.php'); ?>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <?php include ('../center/menu.php'); ?>
                    <h1 class="text-center">เพิ่มข้อมูล</h1>
                    <form action="saveuser.php" method="post">
                     <div class="row">
                        <div class="col-4 offset-4">
                        <div class="input-group mt-3">
                            <span class="input-group-text" id="basic-addon1">รหัสผู้ใช้</span>
                            <input type="text" class="form-control" placeholder="" name="userid" id="userid" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4 offset-4">
                        <div class="input-group mt-3">
                            <span class="input-group-text" id="basic-addon1">ชื่อผู้ใช้</span>
                            <input type="text" class="form-control" placeholder="" name="username" id="userid" >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4 offset-4">
                        <div class="input-group mt-3">
                            <span class="input-group-text" id="basic-addon1">รหัสผ่าน</span>
                            <input type="text" class="form-control" placeholder="" name="userpass" id="userpass" value= "password1" >
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
                    <div class="row mt-1">
                        <div class="col-4 offset-4">
                        
                        <input type="submit" value="บันทึกข้อมูล" class = " btn btn-primary ">
                        <a href="manageuser.php" class = " btn btn-secondary ">ย้อนกลับ</a>
                        
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
                    url:'getposition.php',
                    method: 'post',
                    date: '',
                    success: function(result) {
                        $("#positionid").html(result)
                    } 
                });
                $.ajax({
                    url:'getstatus.php',
                    method: 'post',
                    date: '',
                    success: function(result) {
                        $("#statusid").html(result)
                    } 
                });
            });
        </script>
</body>
</html>