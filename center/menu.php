<?php
@session_start();
?>

<nav class="navbar navbar-expand-lg bg-body-tertiar " style="background-color: #E78F81;">
  <div class="container-fluid">
    <a class="navbar-brand" href="/index.php">Ikkyuya Sushisen</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <!-- <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/index.php">Home</a>
        </li> -->
        
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            สั่งซื้อ
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="../ord/manageorders.php">ใบสั่งซื้อ</a></li>
            <li><a class="dropdown-item" href="../supplier/managesupplier.php">รายชื่อผู้จัดจำหน่าย</a></li>
          </ul>
        </li>
          
          
        <!-- <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            ขาย
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="../customer/managecustomer.php">จัดการข้อมูลลูกค้า</a></li>
            <li><a class="dropdown-item" href="../invoice/manageinvoice.php">ใบขาย</a></li>
          </ul>
        </li> -->
           
        <!-- <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            รายงาน
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="../report/stockbalance.php">รายงานสินค้าคงเหลือ</a></li>
            <li><a class="dropdown-item" href="../report/reportorders.php">*----------*</a></li>
          </ul>
        </li> -->

        <!-- <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            ซัพพลายเออร์
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#"></a></li>
            <li><a class="dropdown-item" href="#"></a></li>
          </ul>
        </li> -->
            
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            ข้อมูลระบบ
          </a>  
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="../status/managestatus.php">จัดการสถานะ</a></li>
            <li><a class="dropdown-item" href="../rmt/managermt.php">จัดการประเภท</a></li>
            <li><a class="dropdown-item" href="../rm/managerm.php">จัดการข้อมูลวัตุดิบ</a></li>
            <li><a class="dropdown-item" href="../unit/manageunit.php">จัดการข้อมูลหน่วยวัด</a></li> 
            <li><a class="dropdown-item" href="../user/manageuser.php">จัดการผู้ใช้ระบบ</a></li>
            <li><a class="dropdown-item" href="../position/manageposition.php">จัดการตำแหน่ง</a></li> 
          </ul>
        </li>

        <!-- <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            ผู้จัดจำหน่าย
          </a>  
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="../status/managestatus.php">จัดการสถานะ</a></li>
            <li><a class="dropdown-item" href="../rmt/managermt.php">จัดการประเภท</a></li>
            <li><a class="dropdown-item" href="../rm/managerm.php">จัดการสินค้า</a></li>
            <li><a class="dropdown-item" href="..">จัดการข้อมูลหน่วยวัด</a></li> 
            <li><a class="dropdown-item" href="../user/manageuser.php">จัดการผู้ใช้ระบบ</a></li>
            <li><a class="dropdown-item" href="../position/manageposition.php">จัดการตำแหน่ง</a></li> 
          </ul>
        </li> -->
        
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            User
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="../user/logout.php">ออกจากระบบ</a></li>
          </ul>
        </li>
      </ul>
    </div>
    <span><?php echo $_SESSION['username']."<br> ตำแหน่ง : ".$_SESSION['positionname']; ?></span>
  </div>
</nav>