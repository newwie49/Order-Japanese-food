<?php
session_start();
include '../db/linkdb.php'; // รวมไฟล์เชื่อมต่อฐานข้อมูล

// ตรวจสอบว่าได้ส่ง ID มาหรือไม่
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // ใช้ prepared statements เพื่อลบข้อมูล
    $stmt = $conn->prepare("DELETE FROM tbrmt WHERE rmtid = ?");
    $stmt->bind_param("i", $id); // bind parameter

    // รันคำสั่งลบ
    if ($stmt->execute()) {
        // หากลบสำเร็จ จะกลับไปหน้าจัดการ
        header("Location: managermt.php");
    } else {
        // หากเกิดข้อผิดพลาดในการลบ
        echo "Error: " . $stmt->error;
    }

    $stmt->close(); // ปิด statement
} else {
    // หากไม่มี ID ที่ส่งมา
    echo "ไม่พบข้อมูลที่จะลบ";
}

$conn->close(); // ปิดการเชื่อมต่อฐานข้อมูล
?>
