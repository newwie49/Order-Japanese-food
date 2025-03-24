<?php
if (!isset($_SESSION)) {
    session_start();
}
include '../db/linkdb.php';
include '../center/text.php';

$today = new DateTime(date('Y-m-d'));
$day = date_format($today,'j');
$month = $monthThai[date_format($today,'n')];
$year = date_format($today,'Y')+543;

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
ob_start();
require_once '../vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf([
    'default_font_size' => 16,
    'default_font' => 'thsarabunnew',
    'mode' => 'utf-8',
    'format' => 'A4'
]);
$mpdf->SetHTMLFooter('
<table width="100%">
    <tr>
        <td width="50%">{DATE j-m-Y H:i:s}</td>
        <td width="50%" align="center">{PAGENO}/{nbpg}</td>
    </tr>
</table>');
$mpdf->SetTitle("รายงานสินค้าคงเหลือ");
$html = '
<h1 style="text-align:center;">รายงานสินค้าคงเหลือ</h1>
<h4 class="text-center">ณ วันที่ ' . $day. ' '.$month . ' พ.ศ.'. $year.'</h4>

<table id="tbl" style="border-collaspe: collaspe;">
    <thead>
        <tr>
            <th width="10%;"  style="border-top: 1px solid #000; border-bottom: 1px solid #000;">#</th>
            <th width="10%;"  style="border-top: 1px solid #000; border-bottom: 1px solid #000;">รหัสสินค้า</th>
            <th width="40%;"  style="border-top: 1px solid #000; border-bottom: 1px solid #000;">ชื่อสินค้า</th>
            <th width="10%;"  style="border-top: 1px solid #000; border-bottom: 1px solid #000;">หน่วยนับ</th>
            <th width="10%;"  style="border-top: 1px solid #000; border-bottom: 1px solid #000;">คงเหลือ</th>
        </tr>

    </thead>
    <tbody>';
        $item = $total = 0;
        for ($i = 0; $i < count($goodsidList); $i++) {
            $item++;
            $goodsid = $goodsidList[$i];
            $goodsname = $goodsnameList[$i];
            $unitname = $unitnameList[$i];
            $balance = $balanceList[$i];
            $total += $balance;
        $html .= '
            <tr>
                <td>'.$item.'</td>
                <td>'.$goodsid.'</td>
                <td>'.$goodsname.'</td>
                <td>'.$unitname.'</td>
                <td style="text-align: right;">'.number_format($balance, 0).'</td>
            </tr>';
        }
        $html .= '
    </tbody>
    <tfoot>
        <tr >
            <td style="border-top: 1px solid #000; border-bottom: 1px solid #000;" colspan="4">รวม '.$item.' รายการ</td>
            <td style="text-align:right; border-top: 1px solid #000; border-bottom: 1px solid #000;">'.number_format($total,0).'</td>
        </tr>
    </tfoot>
</table>';

ob_end_clean();
$mpdf->WriteHTML($html);
$mpdf->Output();

?>