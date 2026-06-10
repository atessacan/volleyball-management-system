<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$role = $_SESSION['role'];

include 'config/db.php';

$sql = "
SELECT
    np.id,
    p.full_name,
    np.plan_title,
    np.meal_plan,
    np.start_date,
    np.end_date,
    np.notes
FROM nutrition_plans np
JOIN players p ON np.player_id = p.id
ORDER BY np.start_date DESC
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beslenme Programları</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1>
            <i class="bi bi-egg-fried text-success"></i>
            Beslenme Programları
        </h1>

        <div>

            <?php if($role == 'dietitian'): ?>

            <a href="add_nutrition.php"
               class="btn btn-success">

                <i class="bi bi-plus-circle"></i>

                Program Ekle

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

                <thead class="table-success">

                    <tr>

                        <th>Oyuncu</th>
                        <th>Program</th>
                        <th>Beslenme Planı</th>
                        <th>Başlangıç</th>
                        <th>Bitiş</th>
                        <th>Notlar</th>

                        <?php if($role == 'dietitian'): ?>
                            <th>İşlemler</th>
                        <?php endif; ?>

                    </tr>

                </thead>

                <tbody>

                    <?php while($nutrition = $result->fetch_assoc()): ?>

                    <tr>

                        <td><?= htmlspecialchars($nutrition['full_name']) ?></td>

                        <td><?= htmlspecialchars($nutrition['plan_title']) ?></td>

                        <td><?= htmlspecialchars($nutrition['meal_plan']) ?></td>

                        <td><?= date('d.m.Y', strtotime($nutrition['start_date'])) ?></td>

                        <td><?= date('d.m.Y', strtotime($nutrition['end_date'])) ?></td>

                        <td><?= htmlspecialchars($nutrition['notes']) ?></td>

                        <?php if($role == 'dietitian'): ?>

                        <td>

                            <a href="edit_nutrition.php?id=<?= $nutrition['id'] ?>"
                               class="btn btn-warning btn-sm">

                                <i class="bi bi-pencil-fill"></i>

                            </a>

                            <a href="delete_nutrition.php?id=<?= $nutrition['id'] ?>"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Emin misiniz?')">

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