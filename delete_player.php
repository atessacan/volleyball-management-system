<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['role'] != 'manager') {
    header("Location: players.php");
    exit();
}

include 'config/db.php';

$id = $_GET['id'];

// Oyuncuya ait istatistikleri sil
$stmt = $conn->prepare("DELETE FROM player_statistics WHERE player_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

// Oyuncuya ait sakatlık kayıtlarını sil
$stmt = $conn->prepare("DELETE FROM injuries WHERE player_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

// Oyuncuya ait beslenme programlarını sil
$stmt = $conn->prepare("DELETE FROM nutrition_plans WHERE player_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

// Oyuncuya ait kondisyon programlarını sil
$stmt = $conn->prepare("DELETE FROM conditioning_programs WHERE player_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

// Son olarak oyuncuyu sil
$stmt = $conn->prepare("DELETE FROM players WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: players.php");
exit();
?>