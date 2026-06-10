<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'coach') {
    header("Location: trainings.php");
    exit();
}

include 'config/db.php';

$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM trainings WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: trainings.php");
exit();
?>