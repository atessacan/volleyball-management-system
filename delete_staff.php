<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['role'] != 'manager') {
    header("Location: dashboard.php");
    exit();
}

include 'config/db.php';

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $stmt = $conn->prepare("
        DELETE FROM staff
        WHERE id = ?
    ");

    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {

        header("Location: staff.php");
        exit();
    }
}
?>