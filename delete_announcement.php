<?php
session_start();



if ($_SESSION['role'] != 'manager') {
    header("Location: dashboard.php");
    exit();
}

include 'config/db.php';

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $stmt = $conn->prepare("
        DELETE FROM announcements
        WHERE id = ?
    ");

    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {

        header("Location: announcements.php");
        exit();
    }
}

header("Location: announcements.php");
exit();
?>