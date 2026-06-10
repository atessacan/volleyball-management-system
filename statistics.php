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
    ps.id,
    p.full_name,
    ps.opponent,
    ps.match_date,
    ps.aces,
    ps.attack_kills,
    ps.kill_blocks,
    ps.successful_digs
FROM player_statistics ps
JOIN players p ON ps.player_id = p.id
ORDER BY ps.match_date DESC
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İstatistikler</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1>
            <i class="bi bi-bar-chart-fill text-info"></i>
            İstatistikler
        </h1>

        <div>

            <?php if($role == 'statistician'): ?>

<a href="add_statistics.php" class="btn btn-success">
    <i class="bi bi-plus-circle"></i>
    İstatistik Ekle
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

           <thead class="table-primary">

    <tr>

        <th>Oyuncu</th>
        <th>Rakip</th>
        <th>Tarih</th>
        <th>Ace</th>
        <th>Atak Sayısı</th>
        <th>Blok Sayısı</th>
        <th>Dig</th>
        <?php if($role == 'statistician'): ?>
    <th>İşlemler</th>
<?php endif; ?>

    </tr>

</thead>

            <tbody>

                <?php while($row = $result->fetch_assoc()): ?>

                    <tr>

                        <td><?= htmlspecialchars($row['full_name']) ?></td>

                        <td><?= htmlspecialchars($row['opponent']) ?></td>

                        <td><?= date('d.m.Y', strtotime($row['match_date'])) ?></td>

                        <td><?= $row['aces'] ?></td>

                        <td><?= $row['attack_kills'] ?></td>

                        <td><?= $row['kill_blocks'] ?></td>

                        <td><?= $row['successful_digs'] ?></td>

                        <?php if($role == 'statistician'): ?>

<td>
    <a href="edit_statistics.php?id=<?= $row['id'] ?>"
       class="btn btn-warning btn-sm">
        Düzenle
    </a>

    <a href="delete_statistics.php?id=<?= $row['id'] ?>"
       class="btn btn-danger btn-sm"
       onclick="return confirm('Emin misiniz?')">
        Sil
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