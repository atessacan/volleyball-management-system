<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['role'] != 'physiotherapist') {
    header("Location: injuries.php");
    exit();
}

include 'config/db.php';

$id = $_GET['id'];

$stmt = $conn->prepare("
    DELETE FROM injuries
    WHERE id = ?
");

$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: injuries.php");
exit();
?>