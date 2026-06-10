<?php
session_start();
if ($_SESSION['role'] != 'statistician') {
    header("Location: statistics.php");
    exit();
}
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'config/db.php';

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $stmt = $conn->prepare("
        DELETE FROM player_statistics
        WHERE id = ?
    ");

    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {

        header("Location: statistics.php");
        exit();

    }
}
?>

