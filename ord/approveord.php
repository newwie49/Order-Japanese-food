<?php
@session_start();
$_SESSION['mode'] = "approve";
include '../db/linkdb.php';

$ordid = $_GET['id'];

$sqlH = "SELECT oh.ordid,oh.orddate,oh.supplierid,su.suppliername,oh.shipmentid,oh.shipmentdate,oh.statusid,st.statusname 
            FROM tbordheader oh
            LEFT JOIN tbsupplier su ON oh.supplierid = su.supplierid
            LEFT JOIN tbstatus st ON oh.statusid = st.statusid
            WHERE oh.ordid = '$ordid'";
// echo $sqlH; exit();            
$queryH = $conn->query($sqlH);
$rsH = $queryH->fetch_assoc();
$orddate = new DateTime($rsH['orddate']);
$supplierid = $rsH['supplierid'];
$suppliername = $rsH['suppliername'];
$statusid = $rsH['statusid'];
$statusname = $rsH['statusname'];

$sqlD = "SELECT od.rmid,rm.rmname,un.rmtname,od.rmprice,od.rmqty 
            FROM tborddetail od
            LEFT JOIN tbrm rm ON od.rmid = rm.rmid
            LEFT JOIN tbrmt un ON rm.rmtid = un.rmtid 
            WHERE od.ordid = '$ordid'";
// echo $sqlH; exit();            
$queryD = $conn->query($sqlD);
$rmidList=$rmnameList=$rmtnameList=$rmpriceList=$rmqtyList=array();
while($rsD = $queryD->fetch_assoc()) {
    array_push($rmidList,$rsD['rmid']);
    array_push($rmnameList,$rsD['rmname']);
    array_push($rmtnameList,$rsD['rmtname']);
    array_push($rmpriceList,$rsD['rmprice']);
    array_push($rmqtyList,$rsD['rmqty']);
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>addrmt</title>
    <?php include ('../center/linkcss.php'); ?>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <?php include ('../center/menu.php'); ?>
                   <h1 class="text-center">อนุมัติใบสั่งซื้อ</h1>
                   <form action="saveord.php" method="post">
                     <div class="row">
                        <div class="col-3 offset-9">
                        <div class="input-group mt-3">
                            <span class="input-group-text" id="basic-addon1">เลขที่</span>
                            <input type="text" class="form-control" placeholder="" name="ordid" id="ordid" value="<?php echo $ordid; ?>"readonly>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-4 ">
                        <div class="input-group mt-3">
                            <span class="input-group-text" id="basic-addon1">ผู้ขาย</span>
                            <input type="text" name="supplierid" id="supplierid" value="<?php echo $suppliername; ?> " readonly>
                        </div>
                        </div>
                        <div class="col-3 offset-5">
                        <div class="input-group mt-3">
                            <span class="input-group-text" id="basic-addon1">วันที่</span>
                            <input type="date" class="form-control" placeholder="" name="orddate" date="orddate" value= "<?php echo date_format($orddate,'Y-m-d'); ?>" required>
                            </div>
                        </div>
                    </div>    
                    <div class="row">
                    <div class="d-grid justify-content-md-end">
                    <!-- <a href="additem.php"class ="btn btn-primary">เพิ่มรายการ</a> -->
                    </div>
                        </div>
                    </div>    
                    <table class="table">
                        <thead>
                            <th width = "10%">#</th>
                            <th width = "10%">รหัสสินค้า</th>
                            <th width = "40%">ชื่อสินค้า</th>
                            <th width = "10%">หน่วย</th>
                            <th width = "10%">ราคาซื้อ</th>
                            <th width = "10%">จำนวน</th>
                            <th width = "10%">เป็นเงิน</th>
                            <!-- <th width = "10%">ลบ</th> -->
                        </thead>
                        <tbody>
                            <?php
                                    $item=0; $granditem =$grandtotal = 0;
                               
                                    for($i=0; $i < count($rmidList); $i++){
                                       
                                            $rmid =$rmidList[$i];
                                            $rmname =$rmnameList[$i];
                                            $rmtname =$rmtnameList[$i];
                                            $rmprice =$rmpriceList[$i];
                                            $rmqty =$rmqtyList[$i];
                                            $total = $rmprice*$rmqty;
                                            $item++;
                                            $granditem += $rmqty;
                                            $grandtotal += $total;
                                            ?>
                                                <tr>
                                                    <td><?php echo $item; ?></td>
                                                    <td><?php echo $rmid; ?></td>
                                                    <td><?php echo $rmname; ?></td>
                                                    <td><?php echo $rmtname; ?></td>
                                                    <td class = "text-end"><span><?php echo number_format($rmprice,2); ?></span></td>
                                                    <td class = "text-end"><span><?php echo number_format($rmqty,0); ?></span></td>
                                                    <td class = "text-end"><span ><?php echo number_format($total,2); ?></span></td>
                                                    <!-- <td><a href="removeitem.php?id=<?php echo $rmid; ?>"class="text-danger"><i class="fa-solid fa-trash"></i></a> -->                                                                                                        
                                                </tr>
                                            <?php
                                            }                                       
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan = "5"><?php echo "รวม".$item."รายการ"; ?></td>
                                <td><span id ="granditem"><?php echo number_format($granditem,0); ?></span></td>
                                <td><span id ="grandtotal"><?php echo number_format($grandtotal,2); ?></span></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                    </div>
                    <div class="row mt-3">
                        <div class="col-4">                       
                            <select name="approveid" id="approveid" class= "form-control">
                                <option value="">--- ยืนยันการจัดส่ง ---</option>
                                <option value="62">--- จัดส่งสำเร็จ ---</option>
                                <!-- <option value="22">--- ไม่อนุมัติใบสั่งซื้อ ---</option> -->

                            </select>
                        
                        </div>
                    </div>    
                    <div class="row mt-3">
                        <div class="col-4 offset-4">
                        
                        <input type="submit" value="บันทึกข้อมูล" class = " btn btn-primary ">
                        <a href="manageorders.php" class = " btn btn-secondary ">ย้อนกลับ</a>
                        
                        </div>
                    </div>    
                </form>
                   
            </div>
        </div>
    </div>
    
        <?php include ('../center/linkjs.php'); ?>
        
</body>
</html>