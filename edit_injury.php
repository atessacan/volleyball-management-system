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
    SELECT *
    FROM injuries
    WHERE id = ?
");

$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$injury = $result->fetch_assoc();

if (!$injury) {
    header("Location: injuries.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $injury_type = $_POST['injury_type'];
    $injury_date = $_POST['injury_date'];
    $treatment_plan = $_POST['treatment_plan'];
    $expected_return_date = $_POST['expected_return_date'];
    $status = $_POST['status'];
    $notes = $_POST['notes'];

    $stmt = $conn->prepare("
        UPDATE injuries
        SET injury_type = ?,
            injury_date = ?,
            treatment_plan = ?,
            expected_return_date = ?,
            status = ?,
            notes = ?
        WHERE id = ?
    ");

    $stmt->bind_param(
        "ssssssi",
        $injury_type,
        $injury_date,
        $treatment_plan,
        $expected_return_date,
        $status,
        $notes,
        $id
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
    <title>Sakatlık Düzenle</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-header bg-warning">
            <h3>Sakatlık Kaydını Düzenle</h3>
        </div>

        <div class="card-body">

            <form method="POST">
        
        <div class="mb-3">
    <label class="form-label">Sakatlık Türü</label>

    <input type="text"
           name="injury_type"
           class="form-control"
           value="<?= htmlspecialchars($injury['injury_type']) ?>"
           required>
</div>

<div class="mb-3">
    <label class="form-label">Sakatlık Tarihi</label>

    <input type="date"
           name="injury_date"
           class="form-control"
           value="<?= $injury['injury_date'] ?>"
           required>
</div>

<div class="mb-3">
    <label class="form-label">Tedavi Planı</label>

    <textarea name="treatment_plan"
              class="form-control"
              rows="3"><?= htmlspecialchars($injury['treatment_plan']) ?></textarea>
</div>

<div class="mb-3">
    <label class="form-label">Tahmini Dönüş Tarihi</label>

    <input type="date"
           name="expected_return_date"
           class="form-control"
           value="<?= $injury['expected_return_date'] ?>">
</div>

<div class="mb-3">
    <label class="form-label">Durum</label>

    <select name="status"
            class="form-select"
            required>

        <option value="devam ediyor"
            <?= ($injury['status'] == 'devam ediyor') ? 'selected' : '' ?>>
            Devam Ediyor
        </option>

        <option value="iyileşti"
            <?= ($injury['status'] == 'iyileşti') ? 'selected' : '' ?>>
            İyileşti
        </option>

    </select>
</div>

<div class="mb-3">
    <label class="form-label">Notlar</label>

    <textarea name="notes"
              class="form-control"
              rows="3"><?= htmlspecialchars($injury['notes']) ?></textarea>
</div>

<div class="d-flex justify-content-between">

    <a href="injuries.php"
       class="btn btn-secondary">
        Geri Dön
    </a>

    <button type="submit"
            class="btn btn-warning">
        Güncelle
    </button>

</div>

            </form>

        </div>

    </div>

</div>

</body>
</html>