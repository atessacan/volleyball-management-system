<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['role'] != 'coach') {
    header("Location: trainings.php");
    exit();
}

include 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $title = $_POST['title'];
    $training_date = $_POST['training_date'];
    $training_time = $_POST['training_time'];
    $location = $_POST['location'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("
        INSERT INTO trainings
        (title, training_date, training_time, location, description)
        VALUES (?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "sssss",
        $title,
        $training_date,
        $training_time,
        $location,
        $description
    );

    $stmt->execute();

    header("Location: trainings.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Antrenman Ekle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

<div class="card shadow">

<div class="card-header bg-success text-white">
    <h3>Antrenman Ekle</h3>
</div>

<div class="card-body">

<form method="POST">

<div class="mb-3">
    <label>Başlık</label>
    <input type="text" name="title" class="form-control" required>
</div>

<div class="mb-3">
    <label>Tarih</label>
    <input type="date" name="training_date" class="form-control" required>
</div>

<div class="mb-3">
    <label>Saat</label>
    <input type="time" name="training_time" class="form-control" required>
</div>

<div class="mb-3">
    <label>Yer</label>
    <input type="text" name="location" class="form-control" required>
</div>

<div class="mb-3">
    <label>Açıklama</label>
    <textarea name="description" class="form-control"></textarea>
</div>

<div class="d-flex justify-content-between">

    <a href="trainings.php" class="btn btn-secondary">
        Geri Dön
    </a>

    <button type="submit" class="btn btn-success">
        Kaydet
    </button>

</div>

</form>

</div>
</div>
</div>

</body>
</html>