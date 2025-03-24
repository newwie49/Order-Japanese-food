<?php
@session_start();
$_SESSION['mode'] = "add";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>addunit</title>
    <?php include ('../center/linkcss.php'); ?>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <?php include ('../center/menu.php'); ?>
                    <h1>เพิ่มข้อมูล</h1>
                    <form action="saveunit.php" method="post">
                     <div class="row">
                        <!-- <div class="col-4 offset-4">
                            <div class="input-group mt-3">
                                <span class="input-group-text" id="basic-addon1">รหัสหน่วยนับ</span>
                                <input type="text" class="form-control" placeholder="" name="unitid" id="unitid" readonly>
                            </div>
                        </div> -->
                    </div>
                    <div class="row">
                        <div class="col-4 offset-4">
                        <div class="input-group mt-3">
                            <span class="input-group-text" id="basic-addon1">ชื่อหน่วยนับ</span>
                            <input type="text" class="form-control" placeholder="" name="unitname" id="unitid" >
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
                        <a href="manageunit.php" class = " btn btn-secondary ">ย้อนกลับ</a>
                        
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
            });
        </script>
</body>
</html>