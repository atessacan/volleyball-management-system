<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['role'] != 'conditioner') {
    header("Location: conditioning.php");
    exit();
}

include 'config/db.php';

$players = $conn->query("
    SELECT id, full_name
    FROM players
    ORDER BY full_name
");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $player_id = $_POST['player_id'];
    $program_title = $_POST['program_title'];
    $exercises = $_POST['exercises'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $notes = $_POST['notes'];

    $stmt = $conn->prepare("
        INSERT INTO conditioning_programs
        (player_id, program_title, exercises, start_date, end_date, notes)
        VALUES (?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "isssss",
        $player_id,
        $program_title,
        $exercises,
        $start_date,
        $end_date,
        $notes
    );

    $stmt->execute();

    header("Location: conditioning.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Kondisyon Programı Ekle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

<div class="card shadow">

<div class="card-header bg-secondary text-white">
    <h3>Kondisyon Programı Ekle</h3>
</div>

<div class="card-body">

<form method="POST">

<div class="mb-3">
    <label>Oyuncu</label>

    <select name="player_id" class="form-select" required>

        <option value="">Oyuncu Seçin</option>

        <?php while($player = $players->fetch_assoc()): ?>

        <option value="<?= $player['id'] ?>">
            <?= htmlspecialchars($player['full_name']) ?>
        </option>

        <?php endwhile; ?>

    </select>
</div>

<div class="mb-3">
    <label>Program Başlığı</label>
    <input type="text" name="program_title" class="form-control" required>
</div>

<div class="mb-3">
    <label>Egzersizler</label>
    <textarea name="exercises" class="form-control" rows="4" required></textarea>
</div>

<div class="mb-3">
    <label>Başlangıç Tarihi</label>
    <input type="date" name="start_date" class="form-control" required>
</div>

<div class="mb-3">
    <label>Bitiş Tarihi</label>
    <input type="date" name="end_date" class="form-control" required>
</div>

<div class="mb-3">
    <label>Notlar</label>
    <textarea name="notes" class="form-control"></textarea>
</div>

<div class="d-flex justify-content-between">

    <a href="conditioning.php" class="btn btn-primary">
        Geri Dön
    </a>

    <button type="submit" class="btn btn-secondary">
        Kaydet
    </button>

</div>

</form>

</div>
</div>
</div>

</body>
</html>