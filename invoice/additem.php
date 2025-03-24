<?php
@session_start();
include '../db/linkdb.php';
$sql = "SELECT g.goodsid,g.goodsname,un.unitname,st.statusname  
            FROM tbgoods g 
            LEFT JOIN tbunit un ON g.unitid = un.unitid 
            LEFT JOIN tbstatus st ON g.statusid = st.statusid  
            WHERE g.statusid IN ('10') AND g.balance > 0  
            ORDER BY g.goodsid*1 DESC";
$query = $conn->query($sql);
// echo $sql; exit();
$goodsidList = $goodsnameList = $unitnameList = $statusnameList = array();
if ($query->num_rows > 0) {
    while ($rs = $query->fetch_assoc()) {
        array_push($goodsidList, $rs['goodsid']);
        array_push($goodsnameList, $rs['goodsname']);
        array_push($unitnameList, $rs['unitname']);
        array_push($statusnameList, $rs['statusname']);
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
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <?php include '../center/menu.php'; ?>
                <h1 class="text-center">เลือกสินค้า</h1>
                <form action="saveitem.php" method="post">
                    <table class="table table-striped">
                        <thead class="table-primary">
                            <th>#</th>
                            <th>รหัสสินค้า</th>
                            <th>ชื่อสินค้า</th>
                            <th>หน่วยนับ</th>
                            <th>เลือก</th>
                        </thead>
                        <tbody>
                            <?php
                            if (count($goodsidList) > 0) {
                                for ($i = 0; $i < count($goodsidList); $i++) {
                                    $item = $i + 1;
                                    $goodsid = $goodsidList[$i];
                                    $goodsname = $goodsnameList[$i];
                                    $unitname = $unitnameList[$i];
                                    $statusname = $statusnameList[$i];
                            ?>
                                    <tr>
                                        <td><?php echo $item; ?></td>
                                        <td><?php echo $goodsid; ?></td>
                                        <td><?php echo $goodsname; ?></td>
                                        <td><?php echo $unitname; ?></td>
                                        <td><input type="checkbox" name="selecteditem[]" id="" value="<?php echo $goodsid; ?>"></td>

                                    </tr>

                                <?php }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="7" class="text-center">ไม่มีข้อมูล</td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <div class="row mt-1">
                        <div class="col-4 offset-4">

                            <input type="submit" value="บันทึกข้อมูล" class="btn btn-primary">
                            <a href="addinv.php" class="btn btn-secondary">ย้อนกลับ</a>

                        </div>
                    </div>
                </form>

            </div>
        </div>

    </div>
    <?php include '../center/linkjs.php'; ?>
</body>

</html>