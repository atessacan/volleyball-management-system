<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'conditioner') {
    header("Location: conditioning.php");
    exit();
}

include 'config/db.php';

$id = $_GET['id'];

$stmt = $conn->prepare("
    SELECT *
    FROM conditioning_programs
    WHERE id = ?
");

$stmt->bind_param("i", $id);
$stmt->execute();

$program = $stmt->get_result()->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $program_title = $_POST['program_title'];
    $exercises = $_POST['exercises'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $notes = $_POST['notes'];

    $stmt = $conn->prepare("
        UPDATE conditioning_programs
        SET program_title=?,
            exercises=?,
            start_date=?,
            end_date=?,
            notes=?
        WHERE id=?
    ");

    $stmt->bind_param(
        "sssssi",
        $program_title,
        $exercises,
        $start_date,
        $end_date,
        $notes,
        $id
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kondisyon Programı Düzenle</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-header bg-warning text-dark">
            <h3>Kondisyon Programını Düzenle</h3>
        </div>

        <div class="card-body">

            <form method="POST">

                <div class="mb-3">
                    <label>Program Başlığı</label>

                    <input type="text"
                           name="program_title"
                           class="form-control"
                           value="<?= htmlspecialchars($program['program_title']) ?>"
                           required>
                </div>

                <div class="mb-3">
                    <label>Egzersizler</label>

                    <textarea name="exercises"
                              class="form-control"
                              rows="4"
                              required><?= htmlspecialchars($program['exercises']) ?></textarea>
                </div>

                <div class="mb-3">
                    <label>Başlangıç Tarihi</label>

                    <input type="date"
                           name="start_date"
                           class="form-control"
                           value="<?= $program['start_date'] ?>"
                           required>
                </div>

                <div class="mb-3">
                    <label>Bitiş Tarihi</label>

                    <input type="date"
                           name="end_date"
                           class="form-control"
                           value="<?= $program['end_date'] ?>"
                           required>
                </div>

                <div class="mb-3">
                    <label>Notlar</label>

                    <textarea name="notes"
                              class="form-control"
                              rows="3"><?= htmlspecialchars($program['notes']) ?></textarea>
                </div>

                <div class="d-flex justify-content-between">

                    <a href="conditioning.php"
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