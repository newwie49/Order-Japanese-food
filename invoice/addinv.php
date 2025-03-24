<?php
@session_start();
$_SESSION['mode'] = "add";



if (isset($_SESSION['customerid']) && $_SESSION['customerid'] != "") {
    $customerid = $_SESSION['customerid'];
} else {
    $customerid = "";
}
if (isset($_SESSION['invdate']) && $_SESSION['invdate'] != "") {
    $invdate = $_SESSION['invdate'];
} else {
    $invdate = new DateTime(date('Y-m-d'));
    $invdate = date_format($invdate,'d-m-Y');
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
                <h1 class="text-center">เพิ่มใบขาย</h1>
                <form action="saveinvoice.php" method="post">
                    <div class="row">
                        <div class="col-3 offset-9">
                            <div class="input-group mt-3">
                                <span class="input-group-text" id="basic-addon1">เลขที่</span>
                                <input type="text" class="form-control" placeholder="" name="invid" id="invid" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="input-group mt-3">
                                <span class="input-group-text" id="basic-addon1">ลูกค้า</span>
                                <select name="customerid" id="customerid" class="form-control" required></select>
                            </div>
                        </div>
                        <div class="col-3 offset-5">
                            <div class="input-group mt-3">
                                <span class="input-group-text" id="basic-addon1">วันที่</span>
                                <input type="text" class="form-control" placeholder="" name="invdate" id="invdate" value="<?php echo $invdate; ?>" required readonly>
                            </div>
                        </div>
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
                                <th width="10%">รหัสสินค้า</th>
                                <th width="30%">ชื่อสินค้า</th>
                                <th width="10%">หน่วย</th>
                                <th width="10%">ราคาขาย</th>
                                <th width="10%">คงเหลือ</th>
                                <th width="10%">จำนวน</th>
                                <th width="10%">เป็นเงิน</th>
                                <th width="10%">ลบ</th>
                            </thead>
                            <tbody>
                                <?php
                                $item = 0;
                                $granditem = $grandtotal = 0;
                                if (isset($_SESSION['invgoodsid']) && count($_SESSION['invgoodsid']) > 0) {
                                    for ($i = 0; $i < count($_SESSION['invgoodsid']); $i++) {
                                        if ($_SESSION['invgoodsid'][$i] != "") {
                                            $goodsid = $_SESSION['invgoodsid'][$i];
                                            $goodsname = $_SESSION['invgoodsname'][$i];
                                            $unitname = $_SESSION['invunitname'][$i];
                                            $price = $_SESSION['invprice'][$i];
                                            $balance = $_SESSION['invbalance'][$i];
                                            $goodsqty = $_SESSION['invgoodsqty'][$i];
                                            $total = $price * $goodsqty;
                                            $item++;
                                            $granditem += $goodsqty;
                                            $grandtotal += $total;
                                ?>
                                            <tr>
                                                <td><?php echo $item; ?></td>
                                                <td><?php echo $goodsid; ?></td>
                                                <td><?php echo $goodsname; ?></td>
                                                <td><?php echo $unitname; ?></td>
                                                <td class="text-center"><input style="text-align: right;" goodsid="<?php echo $goodsid; ?>" class="form-control price" type="number" name="price[]" id="price<?php echo $i; ?>" key="<?php echo $i; ?>" min="1" step=".01" value="<?php echo number_format($price, 2); ?>"></td>
                                                <td class="text-center"><span id="balance<?php echo $i; ?>"><?php echo number_format($balance,0); ?></span></td>
                                                <td class="text-center"><input style="text-align: right;" goodsid="<?php echo $goodsid; ?>" type="number" class="form-control goodsqty" name="goodsqty[]" id="goodsqty<?php echo $i; ?>" key="<?php echo $i; ?>" min="1" max="<?php echo $balance; ?>" value="<?php echo number_format($goodsqty, 0); ?>"></td>
                                                <td class="text-end"><span id="total<?php echo $i; ?>"><?php echo number_format($total, 2); ?></span></td>
                                                <td><a href="removeitem.php?id=<?php echo $goodsid; ?>" class="text-danger"><i class="fa-solid fa-trash"></i></a></td>
                                            </tr>
                                <?php

                                        }
                                    }
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5"><?php echo "รวม " . $item . " รายการ"; ?></td>
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
                            <a href="manageinvoice.php" class="btn btn-secondary">ย้อนกลับ</a>

                        </div>
                    </div>




                </form>

            </div>
        </div>
    </div>
    <?php include '../center/linkjs.php'; ?>
    <script>
        $(document).ready(function() {
            $("#invdate").datepicker({
                dateFormat: 'dd-mm-yy',
                changeMonth: true,
                changeYear: true
            });
            $.ajax({
                url:'getstatus.php',
                method: 'post',
                date: '',
                success: function(result) {
                    $("#statusid").html(result)
                } 
            });
            $.ajax({
                url: 'getcustomer.php',
                method: 'post',
                data: '',
                success: function(result) {
                    $("#customerid").html(result)
                }
            });
            
            $(".price").click(function() {
                $(this).select();
            });
            $(".price").change(function() {
                var key = $(this).attr("key");
                // console.log(key)
                var price = $("#price" + key).val();
                var goodsqty = $("#goodsqty" + key).val();
                // console.log("key : " + key + " price : " + price + " qty : " + goodsqty);
                var total = parseFloat(price) * parseFloat(goodsqty);
                $("#total" + key).text(total);
                var goodsid = $(this).attr("goodsid");
                $.ajax({
                    url: 'updateprice.php',
                    method: 'post',
                    data: ({
                        goodsid: goodsid,
                        price: price
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
            $(".goodsqty").change(function() {
                var key = $(this).attr("key");
                // console.log(key)
                var price = $("#price" + key).val();
                var goodsqty = $("#goodsqty" + key).val();
                // console.log("key : " + key + " price : " + price + " qty : " + goodsqty);
                var total = parseFloat(price) * parseFloat(goodsqty);
                $("#total" + key).text(total);
                var goodsid = $(this).attr("goodsid");
                granditem += goodsqty;
                $.ajax({
                    url: 'updateqty.php',
                    method: 'post',
                    data: ({
                        goodsid: goodsid,
                        goodsqty: goodsqty
                    }),
                    success: function(result) {
                        var obj = $.parseJSON(result)
                        var granditem = parseInt(obj.granditem)
                        var grandtotal = parseFloat(obj.grandtotal)
                        grandtotal = grandtotal.toLocaleString(undefined, {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        })
                        $("#granditem").text(granditem)
                        $("#grandtotal").text(grandtotal)
                    }
                });
            });
            $("#customerid").change(function() {
                var customerid = $("#customerid").val()
                $.ajax({
                    url: 'changecustomerid.php',
                    method: 'post',
                    data: ({
                        customerid: customerid
                    }),
                    success: function() {}
                });
            });
            var customerid = "<?php echo $customerid; ?>"
            $.ajax({
                url: 'getcustomer.php',
                method: 'post',
                data: ({
                    customerid: customerid
                }),
                success: function(result) {
                    // console.log(result)
                    $("#customerid").html(result)
                }
            });
            $("#invdate").change(function() {
                let invdate = $("#invdate").val()
                $.ajax({
                    url: 'changeinvdate.php',
                    method: 'post',
                    data: ({
                        invdate: invdate
                    }),
                    success: function() {}
                });
            });
        });
    </script>
</body>

</html>