<?php
session_start();
$role = $_SESSION['role'];
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'config/db.php';

$sql = "SELECT * FROM players";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oyuncu Listesi</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <span class="navbar-brand">
            🏐 Voleybol Takım Yönetim Sistemi
        </span>

        <div class="text-white">
            Hoş geldin, <?php echo $_SESSION['username']; ?>
        </div>
    </div>
</nav>

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>
            <i class="bi bi-people-fill"></i>
            Oyuncu Listesi
        </h2>

        <div>
            <?php if($_SESSION['role'] == 'manager'): ?>

<a href="add_player.php"
   class="btn btn-success">

    <i class="bi bi-person-plus-fill"></i>

    Oyuncu Ekle

</a>

<?php endif; ?>

            <a href="dashboard.php" class="btn btn-secondary">
                Dashboard
            </a>
        </div>

    </div>

    <div class="card shadow">

        <div class="card-body">

            <table class="table table-striped table-hover align-middle">

                <thead class="table-primary">

                    <tr>
                        <th>Ad Soyad</th>
                        <th>Pozisyon</th>
                        <th>Forma No</th>
                        <th>Boy</th>
                        <th>Doğum Tarihi</th>
                        <?php if($_SESSION['role'] == 'manager'): ?>
    <th>İşlemler</th>
<?php endif; ?>
                    </tr>

                </thead>

                <tbody>

                <?php while ($player = $result->fetch_assoc()) { ?>

                    <tr>


                        <td><?php echo $player['full_name']; ?></td>

                        <td><?php echo $player['position']; ?></td>

                        <td><?php echo $player['jersey_number']; ?></td>

                        <td><?php echo $player['height']; ?> cm</td>

                        <td><?php echo $player['birth_date']; ?></td>

                        <?php if($role == 'manager'): ?>

<td>

    <a href="edit_player.php?id=<?= $player['id'] ?>"
       class="btn btn-warning btn-sm">
        Düzenle
    </a>

    <a href="delete_player.php?id=<?= $player['id'] ?>"
       class="btn btn-danger btn-sm"
       onclick="return confirm('Emin misiniz?')">
        Sil
    </a>

</td>

<?php endif; ?>
                    </tr>

                <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

</body>
</html>