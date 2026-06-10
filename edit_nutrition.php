<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'dietitian') {
    header("Location: nutrition.php");
    exit();
}

include 'config/db.php';

$id = $_GET['id'];

$stmt = $conn->prepare("
    SELECT *
    FROM nutrition_plans
    WHERE id = ?
");

$stmt->bind_param("i", $id);
$stmt->execute();

$nutrition = $stmt->get_result()->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $plan_title = $_POST['plan_title'];
    $meal_plan = $_POST['meal_plan'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $notes = $_POST['notes'];

    $stmt = $conn->prepare("
        UPDATE nutrition_plans
        SET plan_title=?,
            meal_plan=?,
            start_date=?,
            end_date=?,
            notes=?
        WHERE id=?
    ");

    $stmt->bind_param(
        "sssssi",
        $plan_title,
        $meal_plan,
        $start_date,
        $end_date,
        $notes,
        $id
    );

    $stmt->execute();

    header("Location: nutrition.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beslenme Programı Düzenle</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-header bg-warning text-dark">
            <h3>Beslenme Programını Düzenle</h3>
        </div>

        <div class="card-body">

            <form method="POST">

                <div class="mb-3">
                    <label>Program Başlığı</label>

                    <input type="text"
                           name="plan_title"
                           class="form-control"
                           value="<?= htmlspecialchars($nutrition['plan_title']) ?>"
                           required>
                </div>

                <div class="mb-3">
                    <label>Beslenme Planı</label>

                    <textarea name="meal_plan"
                              class="form-control"
                              rows="4"
                              required><?= htmlspecialchars($nutrition['meal_plan']) ?></textarea>
                </div>

                <div class="mb-3">
                    <label>Başlangıç Tarihi</label>

                    <input type="date"
                           name="start_date"
                           class="form-control"
                           value="<?= $nutrition['start_date'] ?>"
                           required>
                </div>

                <div class="mb-3">
                    <label>Bitiş Tarihi</label>

                    <input type="date"
                           name="end_date"
                           class="form-control"
                           value="<?= $nutrition['end_date'] ?>"
                           required>
                </div>

                <div class="mb-3">
                    <label>Notlar</label>

                    <textarea name="notes"
                              class="form-control"
                              rows="3"><?= htmlspecialchars($nutrition['notes']) ?></textarea>
                </div>

                <div class="d-flex justify-content-between">

                    <a href="nutrition.php"
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