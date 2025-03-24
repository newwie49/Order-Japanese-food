<?php
if (!isset($_SESSION)) {
    session_start();
}
include '../db/linkdb.php';
$today = new DateTime(date('Y-m-d'));
$sql = "SELECT g.goodsid,g.goodsname,un.unitname,g.balance 
            FROM tbgoods g 
            LEFT JOIN tbunit un ON g.unitid = un.unitid 
            WHERE g.balance > 0";
// echo $sql; exit();
$query = $conn->query($sql);
$goodsidList = $goodsnameList = $unitnameList = $balanceList = array();
if ($query->num_rows > 0) {
    while ($rs = $query->fetch_assoc()) {
        array_push($goodsidList, $rs["goodsid"]);
        array_push($goodsnameList, $rs["goodsname"]);
        array_push($unitnameList, $rs["unitname"]);
        array_push($balanceList, $rs["balance"]);
    }
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
    <div class="container-flulid">
        <div class="row">
            <?php include '../center/menu.php'; ?>
            <h1 class="text-center">รายงานสินค้าคงเหลือ</h1>
            <h4 class="text-center"><?php echo 'ณ วันที่ ' . date_format($today, 'd-m-Y'); ?> </h4>
        </div>
    </div>
    <table id="tbl" class="table table-striped">
        <thead class="table-primary">
            <th width="10%;">#</th>
            <th width="10%;">รหัสสินค้า</th>
            <th width="40%;">ชื่อสินค้า</th>
            <th width="10%;">หน่วยนับ</th>
            <th width="10%;">คงเหลือ</th>
        </thead>
        <tbody>
            <?php
            $item = 0;
            for ($i = 0; $i < count($goodsidList); $i++) {
                $item++;
                $goodsid = $goodsidList[$i];
                $goodsname = $goodsnameList[$i];
                $unitname = $unitnameList[$i];
                $balance = $balanceList[$i];
            ?>
                <tr>
                    <td><?php echo $item; ?></td>
                    <td><?php echo $goodsid; ?></td>
                    <td><?php echo $goodsname; ?></td>
                    <td><?php echo $unitname; ?></td>
                    <td><?php echo number_format($balance, 0); ?></td>
                </tr>
            <?php
            }

            ?>

        </tbody>
    </table>


    <?php include '../center/linkjs.php'; ?>
    <script>
        $(document).ready(function() {
            $("#tbl").dataTable({
                "oLanguage": {
                    "sEmptyTable": "My Custom Message On Empty Table"
                },
                "language": {
                    "emptyTable": "ไม่มีข้อมูล"

                }
            });
        });
    </script>
</body>

</html>