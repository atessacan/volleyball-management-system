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

$players = $conn->query("
    SELECT id, full_name
    FROM players
    ORDER BY full_name
");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $player_id = $_POST['player_id'];
    $injury_type = $_POST['injury_type'];
    $injury_date = $_POST['injury_date'];
    $treatment_plan = $_POST['treatment_plan'];
    $expected_return_date = $_POST['expected_return_date'];
    $status = $_POST['status'];
    $notes = $_POST['notes'];

    $stmt = $conn->prepare("
        INSERT INTO injuries
        (player_id, injury_type, injury_date,
         treatment_plan, expected_return_date,
         status, notes)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "issssss",
        $player_id,
        $injury_type,
        $injury_date,
        $treatment_plan,
        $expected_return_date,
        $status,
        $notes
    );

    $stmt->execute();

    header("Location: injuries.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sakatlık Ekle</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-header bg-danger text-white">
            <h3>Sakatlık Ekle</h3>
        </div>

        <div class="card-body">

            <form method="POST">


        <div class="mb-3">
    <label class="form-label">
        Oyuncu
    </label>

    <select name="player_id"
            class="form-select"
            required>

        <option value="">
            Oyuncu Seçin
        </option>

        <?php while($player = $players->fetch_assoc()): ?>

            <option value="<?= $player['id'] ?>">

                <?= htmlspecialchars($player['full_name']) ?>

            </option>

        <?php endwhile; ?>

    </select>
</div>

<div class="mb-3">
    <label class="form-label">
        Sakatlık Türü
    </label>

    <input type="text"
           name="injury_type"
           class="form-control"
           required>
</div>

<div class="mb-3">
    <label class="form-label">
        Sakatlık Tarihi
    </label>

    <input type="date"
           name="injury_date"
           class="form-control"
           required>
</div>

<div class="mb-3">
    <label class="form-label">
        Tedavi Planı
    </label>

    <textarea name="treatment_plan"
              class="form-control"
              rows="3"></textarea>
</div>

<div class="mb-3">
    <label class="form-label">
        Tahmini Dönüş Tarihi
    </label>

    <input type="date"
           name="expected_return_date"
           class="form-control">
</div>

<div class="mb-3">
    <label class="form-label">
        Durum
    </label>

    <select name="status"
            class="form-select"
            required>

        <option value="devam ediyor">
            Devam Ediyor
        </option>

        <option value="iyileşti">
            İyileşti
        </option>

    </select>
</div>

<div class="mb-3">
    <label class="form-label">
        Notlar
    </label>

    <textarea name="notes"
              class="form-control"
              rows="3"></textarea>
</div>

<div class="d-flex justify-content-between">

    <a href="injuries.php"
       class="btn btn-secondary">

        Geri Dön

    </a>

    <button type="submit"
            class="btn btn-danger">

        Sakatlık Ekle

    </button>

</div>

            </form>

        </div>

    </div>

</div>

</body>
</html>