<?php
@session_start();
$_SESSION['mode'] = "add";



if (isset($_SESSION['supplierid']) && $_SESSION['supplierid'] != "") {
    $supplierid = $_SESSION['supplierid'];
} else {
    $supplierid = "";
}
// if (isset($_SESSION['orddate']) && $_SESSION['orddate'] != "") {
//     $orddate = $_SESSION['orddate'];
// } else {
//     $orddate = new DateTime(date('Y-m-d'));
//     $orddate = date_format($orddate,'d-m-Y');
// }
if (isset($_SESSION['shipmentdate']) && $_SESSION['shipmentdate'] != "") {
    $shipmentdate = $_SESSION['shipmentdate'];
} else {
    $shipmentdate = new DateTime(date('Y-m-d'));
    $shipmentdate = date_format($shipmentdate,'d-m-Y');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php include '../center/linkcss.php'; ?>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <?php include '../center/menu.php'; ?>
                <h1 class="text-center">เพิ่มใบสั่งซื้อ</h1>
                <form action="saveorders.php" method="post">
                    <!-- <div class="row">
                        <div class="col-3 offset-9">
                            <div class="input-group mt-3">
                                <span class="input-group-text" id="basic-addon1">เลขที่</span>
                                <input type="text" class="form-control" placeholder="" name="ordid" id="ordid" readonly>
                            </div>
                        </div>
                    </div> -->
                    <div class="row">
                        <div class="col-4 ">
                            <div class="input-group mt-3">
                                <span class="input-group-text" id="basic-addon1">ชื่อวัตุดิบ</span>
                                <input type="text" class="form-control" placeholder="ค้นหา..." name="ordid" id="ordid">
                                <button class="btn" type="button" id="searchBtn"><i class="bi bi-search"></i></button>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="input-group mt-3">
                                <span class="input-group-text" id="basic-addon1">ผู้ขาย</span>
                                <select name="supplierid" id="supplierid" class="form-control" required></select>
                            </div>
                        </div>
                        <!-- <div class="col-3 ">
                            <div class="input-group mt-3">
                                <span class="input-group-text" id="basic-addon1">วันที่จัดส่ง</span>
                                <input type="text" class="form-control" placeholder="" name="shipmentdate" id="shipmentdate" value="<?php echo $shipmentdate; ?>" required readonly>
                            </div>
                        </div> -->
                    </div>
                    <div class="row">
                        <div class="d-grid justify-content-md-end">
                            <a href="additem.php" class="btn btn-primary">เพิ่มรายการ</a>
                        </div>
                    </div>
                    <div class="row">
                        <table class="table">
                            <thead>
                                <th width="10%">#</th>
                                <!-- <th width="10%">รหัสสินค้า</th> -->
                                <th width="30%">ชื่อสินค้า</th>
                                <!-- <th width="10%">หน่วย</th> -->
                                <th width="10%">ราคา</th>
                                <th width="10%">จำนวน</th>
                                <!-- <th width="10%">เป็นเงิน</th> -->
                                <!-- <th width="10%">ลบ</th> -->
                            </thead>
                            <tbody>
                                <?php
                                $item = 0;
                                $granditem = $grandtotal = 0;
                                if (isset($_SESSION['ordrmid']) && count($_SESSION['ordrmid']) > 0) {
                                    for ($i = 0; $i < count($_SESSION['ordrmid']); $i++) {
                                        if ($_SESSION['ordrmid'][$i] != "") {
                                            $rmid = $_SESSION['ordrmid'][$i];
                                            $rmname = $_SESSION['ordrmname'][$i];
                                            $rmtname = $_SESSION['ordrmtname'][$i];
                                            $rmprice = $_SESSION['ordrmprice'][$i];
                                            $rmqty = $_SESSION['ordrmqty'][$i];
                                            $total = $rmprice * $rmqty;
                                            $item++;
                                            $granditem += $rmqty;
                                            $grandtotal += $total;
                                ?>
                                            <tr>
                                                <td><?php echo $item; ?></td>
                                                <!-- <td><?php echo $rmid; ?></td> -->
                                                <td><?php echo $rmname; ?></td>
                                                <!-- <td><?php echo $rmtname; ?></td> -->
                                                <td class="text-center"><?php echo $rmprice; ?></td>
                                                <!-- <td class="text-center"><input  goodsid="<?php echo $goodsid; ?>" class="form-control cost" type="number" name="cost[]" id="cost<?php echo $i; ?>" key="<?php echo $i; ?>" min="1" step=".01" value="<?php echo number_format($cost, 2); ?>"></td> -->
                                                <td class="text-center"><input style="text-align: right;" rmid="<?php echo $rmid; ?>" type="number" class="form-control rmqty" name="rmqty[]" id="rmqty<?php echo $i; ?>" key="<?php echo $i; ?>" min="1" value="<?php echo number_format($rmqty, 0); ?>"></td>
                                                <!-- <td class="text-end"><span id="total<?php echo $i; ?>"><?php echo number_format($total, 2); ?></span></td> -->
                                                <!-- <td><a href="removeitem.php?id=<?php echo $rmid; ?>" class="text-danger"><i class="fa-solid fa-trash"></i></a></td> -->
                                                
                                            </tr>
                                <?php

                                        }
                                    }
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan=""><?php echo "รวม " . $item . " รายการ"; ?></td>
                                    <td class="text-end"><span id="granditem"><?php echo number_format($granditem, 0); ?></span></td>
                                    <td class="text-end"><span id="grandtotal"><?php echo number_format($grandtotal, 2); ?></span></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="row mt-1">
                        <div class="col-4 offset-4">

                            <input type="submit" value="บันทึกข้อมูล" class="btn btn-primary">
                            <a href="manageorders.php" class="btn btn-secondary">ย้อนกลับ</a>

                        </div>
                    </div>




                </form>

            </div>
        </div>
    </div>
    <?php include '../center/linkjs.php'; ?>
    <script>
        $(document).ready(function() {
            $("#shipmentdate").datepicker({
                dateFormat: 'dd-mm-yy',
                changeMonth: true,
                changeYear: true
            });
            $.ajax({
                url: 'getsupplier.php',
                method: 'post',
                data: '',
                success: function(result) {
                    $("#supplierid").html(result)
                }
            });
            $.ajax({
                url: 'getstatus.php',
                method: 'post',
                data: '',
                success: function(result) {
                    $("#statusid").html(result)
                }
            });
            $(".rmprice").change(function() {
                var key = $(this).attr("key");
                // console.log(key)
                var rmprice = $("#rmprice" + key).val();
                var rmqty = $("#rmqty" + key).val();
                // console.log("key : " + key + " rmprice : " + rmprice + " qty : " + rmqty);
                var total = parseFloat(rmprice) * parseFloat(rmqty);
                $("#total" + key).text(total);
                var rmid = $(this).attr("rmid");
                $.ajax({
                    url: 'updatermprice.php',
                    method: 'post',
                    data: ({
                        rmid: rmid,
                        rmprice: rmprice
                    }),
                    success: function(result) {
                        var obj = $.parseJSON(result)
                        var granditem = parseInt(obj.granditem)
                        var grandtotal = parseFloat(obj.grandtotal)
                        // console.log(grandtotal)
                        grandtotal = grandtotal.toLocaleString(undefined, {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        })
                        $("#grandtotal").text(grandtotal)
                    }
                });
            });
            $(".rmqty").change(function() {
                var key = $(this).attr("key");
                // console.log(key)
                var rmprice = $("#rmprice" + key).val();
                var rmqty = $("#rmqty" + key).val();
                // console.log("key : " + key + " rmprice : " + rmprice + " qty : " + rmqty);
                var total = parseFloat(rmprice) * parseFloat(rmqty);
                $("#total" + key).text(total);
                var rmid = $(this).attr("rmid");
                // granditem += rmqty;
                $.ajax({
                    url: 'updateqty.php',
                    method: 'post',
                    data: ({
                        rmid: rmid,
                        rmqty: rmqty
                    }),
                    success: function(result) {
                        var obj = $.parseJSON(result)
                        var granditem = parseInt(obj.granditem)
                        var grandtotal = parseFloat(obj.grandtotal)
                        // console.log(grandtotal)
                        grandtotal = grandtotal.toLocaleString(undefined, {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        })
                        $("#granditem").text(granditem)
                        $("#grandtotal").text(grandtotal)
                    }
                });
            });
            $("#supplierid").change(function() {
                var supplierid = $("#supplierid").val()
                $.ajax({
                    url: 'changesupplierid.php',
                    method: 'post',
                    data: ({
                        supplierid: supplierid
                    }),
                    success: function() {}
                });
            });
            var supplierid = "<?php echo $supplierid; ?>"
            $.ajax({
                url: 'getsupplier.php',
                method: 'post',
                data: ({
                    supplierid: supplierid
                }),
                success: function(result) {
                    // console.log(result)
                    $("#supplierid").html(result)
                }
            });
            $("#orddate").change(function() {
                let orddate = $("#orddate").val()
                $.ajax({
                    url: 'changeorddate.php',
                    method: 'post',
                    data: ({
                        orddate: orddate
                    }),
                    success: function() {}
                });
            });
            $("#shipmentdate").change(function() {
                let shipmentdate = $("#shipmentdate").val()
                $.ajax({
                    url: 'changeshipmentdate.php',
                    method: 'post',
                    data: ({
                        shipmentdate: shipmentdate
                    }),
                    success: function() {}
                });
            });
        });
    </script>
</body>

</html>