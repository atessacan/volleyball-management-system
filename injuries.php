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
    i.id,
    p.full_name,
    i.injury_type,
    i.injury_date,
    i.expected_return_date,
    i.status
FROM injuries i
JOIN players p ON i.player_id = p.id
ORDER BY i.injury_date DESC
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sakatlık Takibi</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1>
            <i class="bi bi-heart-pulse-fill text-danger"></i>
            Sakatlık Takibi
        </h1>

        <div>

            <?php if($role == 'physiotherapist'): ?>

            <a href="add_injury.php" class="btn btn-danger">
                <i class="bi bi-plus-circle"></i>
                Sakatlık Ekle
            </a>

            <?php endif; ?>

            <a href="dashboard.php" class="btn btn-secondary">
                Dashboard
            </a>

        </div>

    </div>

    <div class="card shadow">

        <div class="card-body">

            <table class="table table-hover">

                <thead class="table-danger">

                    <tr>

                        <th>Oyuncu</th>
                        <th>Sakatlık Türü</th>
                        <th>Başlangıç Tarihi</th>
                        <th>Tahmini Dönüş</th>
                        <th>Durum</th>

                        <?php if($role == 'physiotherapist'): ?>
                            <th>İşlemler</th>
                        <?php endif; ?>

                    </tr>

                </thead>

                <tbody>

                <?php while($injury = $result->fetch_assoc()): ?>

<tr>

    <td><?= htmlspecialchars($injury['full_name']) ?></td>

    <td><?= htmlspecialchars($injury['injury_type']) ?></td>

    <td><?= date('d.m.Y', strtotime($injury['injury_date'])) ?></td>

    <td><?= date('d.m.Y', strtotime($injury['expected_return_date'])) ?></td>

    <td>

        <?php if($injury['status'] == 'iyileşti'): ?>

            <span class="badge bg-success">
                İyileşti
            </span>

        <?php else: ?>

            <span class="badge bg-warning text-dark">
                Devam Ediyor
            </span>

        <?php endif; ?>

    </td>

    <?php if($role == 'physiotherapist'): ?>

    <td>

        <a href="edit_injury.php?id=<?= $injury['id'] ?>"
           class="btn btn-warning btn-sm">

            <i class="bi bi-pencil-fill"></i>

        </a>

        <a href="delete_injury.php?id=<?= $injury['id'] ?>"
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