<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'dietitian') {
    header("Location: nutrition.php");
    exit();
}

include 'config/db.php';

$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM nutrition_plans WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: nutrition.php");
exit();
?>