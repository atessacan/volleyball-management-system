<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'coach') {
    header("Location: trainings.php");
    exit();
}

include 'config/db.php';

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM trainings WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$training = $stmt->get_result()->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $title = $_POST['title'];
    $training_date = $_POST['training_date'];
    $training_time = $_POST['training_time'];
    $location = $_POST['location'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("
        UPDATE trainings
        SET title=?,
            training_date=?,
            training_time=?,
            location=?,
            description=?
        WHERE id=?
    ");

    $stmt->bind_param(
        "sssssi",
        $title,
        $training_date,
        $training_time,
        $location,
        $description,
        $id
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Antrenman Düzenle</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-header bg-warning text-dark">
            <h3>Antrenman Düzenle</h3>
        </div>

        <div class="card-body">

            <form method="POST">

                <div class="mb-3">
                    <label>Başlık</label>

                    <input type="text"
                           name="title"
                           class="form-control"
                           value="<?= htmlspecialchars($training['title']) ?>"
                           required>
                </div>

                <div class="mb-3">
                    <label>Tarih</label>

                    <input type="date"
                           name="training_date"
                           class="form-control"
                           value="<?= $training['training_date'] ?>"
                           required>
                </div>

                <div class="mb-3">
                    <label>Saat</label>

                    <input type="time"
                           name="training_time"
                           class="form-control"
                           value="<?= $training['training_time'] ?>"
                           required>
                </div>

                <div class="mb-3">
                    <label>Yer</label>

                    <input type="text"
                           name="location"
                           class="form-control"
                           value="<?= htmlspecialchars($training['location']) ?>"
                           required>
                </div>

                <div class="mb-3">
                    <label>Açıklama</label>

                    <textarea name="description"
                              class="form-control"
                              rows="3"><?= htmlspecialchars($training['description']) ?></textarea>
                </div>

                <div class="d-flex justify-content-between">

                    <a href="trainings.php"
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