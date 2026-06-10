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
    cp.id,
    p.full_name,
    cp.program_title,
    cp.exercises,
    cp.start_date,
    cp.end_date,
    cp.notes
FROM conditioning_programs cp
JOIN players p ON cp.player_id = p.id
ORDER BY cp.start_date DESC
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kondisyon Programları</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1>
            <i class="bi bi-activity text-secondary"></i>
            Kondisyon Programları
        </h1>

        <div>

            <?php if($role == 'conditioner'): ?>

            <a href="add_conditioning.php"
               class="btn btn-secondary">

                <i class="bi bi-plus-circle"></i>

                Program Ekle

            </a>

            <?php endif; ?>

            <a href="dashboard.php"
               class="btn btn-primary">

                Dashboard

            </a>

        </div>

    </div>

    <div class="card shadow">

        <div class="card-body">

            <table class="table table-hover">

                <thead class="table-secondary">

                    <tr>

                        <th>Oyuncu</th>
                        <th>Program</th>
                        <th>Egzersizler</th>
                        <th>Başlangıç</th>
                        <th>Bitiş</th>
                        <th>Notlar</th>

                        <?php if($role == 'conditioner'): ?>
                            <th>İşlemler</th>
                        <?php endif; ?>

                    </tr>

                </thead>

                <tbody>

                    <?php while($program = $result->fetch_assoc()): ?>

                    <tr>

                        <td><?= htmlspecialchars($program['full_name']) ?></td>

                        <td><?= htmlspecialchars($program['program_title']) ?></td>

                        <td><?= htmlspecialchars($program['exercises']) ?></td>

                        <td><?= date('d.m.Y', strtotime($program['start_date'])) ?></td>

                        <td><?= date('d.m.Y', strtotime($program['end_date'])) ?></td>

                        <td><?= htmlspecialchars($program['notes']) ?></td>

                        <?php if($role == 'conditioner'): ?>

                        <td>

                            <a href="edit_conditioning.php?id=<?= $program['id'] ?>"
                               class="btn btn-warning btn-sm">

                                <i class="bi bi-pencil-fill"></i>

                            </a>

                            <a href="delete_conditioning.php?id=<?= $program['id'] ?>"
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