<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$role = $_SESSION['role'];

include 'config/db.php';

$sql = "
SELECT *
FROM trainings
ORDER BY training_date DESC, training_time DESC
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Antrenman Programları</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1>
            <i class="bi bi-calendar-check-fill text-primary"></i>
            Antrenman Programları
        </h1>

        <div>

            <?php if($role == 'coach'): ?>

            <a href="add_training.php"
               class="btn btn-success">

                <i class="bi bi-plus-circle"></i>

                Antrenman Ekle

            </a>

            <?php endif; ?>

            <a href="dashboard.php"
               class="btn btn-secondary">

                Dashboard

            </a>

        </div>

    </div>

    <div class="card shadow">

        <div class="card-body">

            <table class="table table-hover">

                <thead class="table-primary">

                    <tr>

                        <th>Başlık</th>
                        <th>Tarih</th>
                        <th>Saat</th>
                        <th>Yer</th>
                        <th>Açıklama</th>

                        <?php if($role == 'coach'): ?>
                            <th>İşlemler</th>
                        <?php endif; ?>

                    </tr>

                </thead>

                <tbody>

                <?php while($training = $result->fetch_assoc()): ?>

<tr>

    <td><?= htmlspecialchars($training['title']) ?></td>

    <td><?= date('d.m.Y', strtotime($training['training_date'])) ?></td>

    <td><?= date('H:i', strtotime($training['training_time'])) ?></td>

    <td><?= htmlspecialchars($training['location']) ?></td>

    <td><?= htmlspecialchars($training['description']) ?></td>

    <?php if($role == 'coach'): ?>

    <td>

        <a href="edit_training.php?id=<?= $training['id'] ?>"
           class="btn btn-warning btn-sm">

            <i class="bi bi-pencil-fill"></i>

        </a>

        <a href="delete_training.php?id=<?= $training['id'] ?>"
           class="btn btn-danger btn-sm"
           onclick="return confirm('Bu antrenmanı silmek istediğinize emin misiniz?')">

            <i class="bi bi-trash-fill"></i>

        </a>

    </td>

    <?php endif; ?>

</tr>

<?php endwhile; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

</body>
</html>