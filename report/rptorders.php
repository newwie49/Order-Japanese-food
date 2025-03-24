<?php 
if(!isset($_SESSION)) {
    session_start();
}
include '../db/linkdb.php';
include '../center/text.php';

$datefrom = explode("-",$_POST['datefrom']);
$dateto = explode("-", $_POST['dateto']);

// echo '<pre>',print_r($_POST),'</pre>'; exit();
$df = date("Y-m-d",strtotime($datefrom[2].'-'.$datefrom[1].'-'.$datefrom[0]));
$dt = date("Y-m-d",strtotime($dateto[2].'-'.$dateto[1].'-'.$dateto[0]));
// echo $df; exit();

$sql = "SELECT od.goodsid,g.goodsname,un.unitname,od.goodsqty,od.cost 
            FROM tborddetail od 
            LEFT JOIN tbgoods g ON od.goodsid = g.goodsid 
            LEFT JOIN tbunit un ON g.unitid = un.unitid 
            LEFT JOIN tbordheader oh ON od.ordid = oh.ordid
            WHERE (oh.orddate >= '$df' AND oh.orddate <= '$dt') ";
echo $sql; exit();

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
                <h1 class="text-center">รายงานการสั่งซื้อ</h1>
            </div>
        </div>
        <form action="rptorders.php" method="post">
            <div class="row">
                <div class="col-8 offset-2">
                    <div class="row">
                        <div class="col-4">
                            <div class="input-group mt-3">
                                <span class="input-group-text" id="basic-addon1">วันที่</span>
                                <input type="text" class="form-control" placeholder="" name="datefrom" id="datefrom" required>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="input-group mt-3">
                                <span class="input-group-text" id="basic-addon1">วันที่</span>
                                <input type="text" class="form-control" placeholder="" name="dateto" id="dateto" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-5">
                        <div class="col-4 offset-2">
                            <input type="submit" value="แสดงรายงาน" class="btn btn-primary">
                            <a href="/index.php" class="btn btn-secondary">ย้อนกลับ</a>

                        </div>
                    </div>
            </div>
        </form>


    </div>

    <?php include '../center/linkjs.php'; ?>
    <script>
        let $datefrom = $("#datefrom");
        let $dateto = $("#dateto");

        $datefrom.datepicker({
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
        });
        $dateto.datepicker({
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
        });
    </script>
</body>

</html>