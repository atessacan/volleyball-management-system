<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['role'] != 'manager') {
    header("Location: dashboard.php");
    exit();
}

include 'config/db.php';

$result = $conn->query("
    SELECT *
    FROM staff
    ORDER BY full_name
");
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personel Yönetimi</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">

        <span class="navbar-brand">
            👥 Personel Yönetimi
        </span>

        <a href="dashboard.php" class="btn btn-outline-light">
            Dashboard
        </a>

    </div>
</nav>

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>
            Personeller
        </h2>

        <a href="add_staff.php"
           class="btn btn-success">

            <i class="bi bi-person-plus-fill"></i>

            Personel Ekle

        </a>

    </div>

    <div class="card shadow">

        <div class="card-body">

            <table class="table table-hover">

                <thead class="table-dark">

                    <tr>

                        <th>Ad Soyad</th>

                        <th>Rol</th>

                        <th>E-posta</th>

                        <th>Telefon</th>

                        <th>İşlemler</th>

                    </tr>

                </thead>

                <tbody>

                    <?php while($staff = $result->fetch_assoc()): ?>

                    <tr>

                        <td>
                            <?= htmlspecialchars($staff['full_name']) ?>
                        </td>

                        <td>
    <?php
    switch($staff['role']) {

        case 'coach':
            echo 'Antrenör';
            break;

        case 'statistician':
            echo 'İstatistikçi';
            break;

        case 'physiotherapist':
            echo 'Fizyoterapist';
            break;

        case 'conditioner':
            echo 'Kondisyoner';
            break;

        case 'dietitian':
            echo 'Diyetisyen';
            break;

        default:
            echo $staff['role'];
    }
    ?>
</td>

                        <td>
                            <?= htmlspecialchars($staff['email']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($staff['phone']) ?>
                        </td>

                        <td>

                            <a href="edit_staff.php?id=<?= $staff['id'] ?>"
                               class="btn btn-warning btn-sm">

                                <i class="bi bi-pencil-fill"></i>

                            </a>

                            <a href="delete_staff.php?id=<?= $staff['id'] ?>"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Bu personeli silmek istediğinize emin misiniz?')">

                                <i class="bi bi-trash-fill"></i>

                            </a>

                        </td>

                    </tr>

                    <?php endwhile; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

</body>
</html>