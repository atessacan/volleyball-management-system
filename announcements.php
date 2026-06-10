<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}



include 'config/db.php';

$result = $conn->query("
    SELECT *
    FROM announcements
    ORDER BY created_at DESC
");
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Duyurular</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1>
            <i class="bi bi-megaphone-fill text-warning"></i>
            Duyurular
        </h1>

        <div>

            <?php if($_SESSION['role'] == 'manager'): ?>

<a href="add_announcement.php"
   class="btn btn-success">

    <i class="bi bi-plus-circle"></i>

    Duyuru Ekle

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

                <thead class="table-warning">

                    <tr>

                        <th>Başlık</th>

                        <th>İçerik</th>

                        <th>Tarih</th>

                        <?php if($_SESSION['role'] == 'manager'): ?>
    <th>İşlemler</th>
<?php endif; ?>

                    </tr>

                </thead>

                <tbody>

                    <?php while($announcement = $result->fetch_assoc()): ?>

                    <tr>

                        <td>
                            <?= htmlspecialchars($announcement['title']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($announcement['content']) ?>
                        </td>

                        <td>
                            <?= date(
                                'd.m.Y H:i',
                                strtotime($announcement['created_at'])
                            ) ?>
                        </td>
<?php if($_SESSION['role'] == 'manager'): ?>
                        <td>

                            <a href="edit_announcement.php?id=<?= $announcement['id'] ?>"
   class="btn btn-warning btn-sm">

    <i class="bi bi-pencil-fill"></i>

</a>
                            <a href="delete_announcement.php?id=<?= $announcement['id'] ?>"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Bu duyuruyu silmek istediğinize emin misiniz?')">

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