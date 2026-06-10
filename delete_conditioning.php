<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'conditioner') {
    header("Location: conditioning.php");
    exit();
}

include 'config/db.php';

$id = $_GET['id'];

$stmt = $conn->prepare("
    DELETE FROM conditioning_programs
    WHERE id = ?
");

$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: conditioning.php");
exit();
?>