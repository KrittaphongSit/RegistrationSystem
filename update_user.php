<?php
session_start();
require_once 'config/db.php';

// ตรวจสอบว่าผู้ใช้เข้าสู่ระบบในฐานะผู้ดูแลระบบหรือไม่
if (!isset($_SESSION['admin_login'])) {
    header('location: index.php');
    exit();
}

// ตรวจสอบว่ามีการส่งข้อมูลการอัปเดตผู้ใช้หรือไม่
if (isset($_POST['update'])) {
    // รับข้อมูลที่แก้ไขจากฟอร์ม
    $user_id = $_POST['user_id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // เตรียมคำสั่ง SQL สำหรับอัปเดตข้อมูล
    if (!empty($password)) {
        // หากกรอกรหัสผ่าน ให้ทำการแฮชและอัปเดต
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $update_stmt = $conn->prepare("UPDATE users 
                                       SET firstname = :firstname, 
                                           lastname = :lastname, 
                                           email = :email,
                                           password = :password 
                                       WHERE id = :user_id");
        $update_stmt->bindParam(":password", $password_hash);
    } else {
        // หากไม่กรอกรหัสผ่าน อัปเดตเฉพาะข้อมูลส่วนตัว
        $update_stmt = $conn->prepare("UPDATE users 
                                       SET firstname = :firstname, 
                                           lastname = :lastname, 
                                           email = :email 
                                       WHERE id = :user_id");
    }

    $update_stmt->bindParam(":firstname", $firstname);
    $update_stmt->bindParam(":lastname", $lastname);
    $update_stmt->bindParam(":email", $email);
    $update_stmt->bindParam(":user_id", $user_id);
    $update_stmt->execute();

    // หากอัปเดตข้อมูลสำเร็จ ให้ redirect กลับไปยังหน้า admin.php
    header('location: admin.php');
    exit();
} else {
    // หากไม่มีการส่งข้อมูลการอัปเดตผู้ใช้ ให้ redirect กลับไปยังหน้า admin.php
    header('location: admin.php');
    exit();
}
?>

