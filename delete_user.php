<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['admin_login'])) {
    header('location: index.php');
    exit();
}

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM users WHERE id = :user_id");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header('location: admin.php');
        exit();
    } else {
        echo "Failed to delete user";
    }
} else {
    header('location: admin.php');
    exit();
}
?>