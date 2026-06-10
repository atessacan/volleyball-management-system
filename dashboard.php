<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$role = $_SESSION['role'];

$role_names = [
    'manager' => 'Takım Menajeri',
    'coach' => 'Antrenör',
    'statistician' => 'İstatistikçi',
    'physiotherapist' => 'Fizyoterapist',
    'conditioner' => 'Kondisyoner',
    'dietitian' => 'Diyetisyen'
];

include 'config/db.php';
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <span class="navbar-brand">
            🏐 Voleybol Takım Yönetim Sistemi
        </span>

        <div class="text-white text-end">
    <div>
        Hoş geldin,
        <strong><?= htmlspecialchars($_SESSION['username']) ?></strong>
    </div>

    <small>
        <?= $role_names[$role] ?>
    </small>
</div>
    </div>
</nav>

<div class="container mt-5">

    <div class="card shadow mb-4 border-0">

        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">
                <i class="bi bi-person-circle"></i>
                Profil Bilgileri
            </h4>
        </div>

        <div class="card-body">

            <div class="row align-items-center">

                <div class="col-md-6">

                    <h6 class="text-muted">
                        Kullanıcı Adı
                    </h6>

                    <h5>
                        <?= htmlspecialchars($_SESSION['username']) ?>
                    </h5>

                </div>

                <div class="col-md-6">

                    <h6 class="text-muted">
                        Görev
                    </h6>

                    <h5 class="text-primary">
                        <?= $role_names[$role] ?>
                    </h5>

                </div>

            </div>

        </div>

    </div>

    <div class="row g-4">

        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body text-center">

                    <i class="bi bi-people-fill fs-1 text-primary"></i>

                    <h4 class="mt-3">Oyuncular</h4>

                    <p>Oyuncuları görüntüleyin ve yönetin.</p>

                    <a href="players.php" class="btn btn-primary">
                        Oyuncuları Görüntüle
                    </a>

                </div>
            </div>
        </div>

        <?php if($role == 'manager'): ?>

<div class="col-md-6">
    <div class="card shadow">
        <div class="card-body text-center">

            <i class="bi bi-people-fill fs-1 text-dark"></i>

            <h4 class="mt-3">
                Personel Yönetimi
            </h4>

            <p>
                Personelleri görüntüleyin ve yönetin.
            </p>

            <a href="staff.php"
               class="btn btn-dark">

                Personeller

            </a>

        </div>
    </div>
</div>

<?php if($role == 'manager'): ?>

<div class="col-md-6">
    <div class="card shadow">
        <div class="card-body text-center">

            <i class="bi bi-person-plus-fill fs-1 text-success"></i>

            <h4 class="mt-3">
                Oyuncu Ekle
            </h4>

            <p>
                Sisteme yeni oyuncu ekleyin.
            </p>

            <a href="add_player.php"
               class="btn btn-success">

                Oyuncu Ekle

            </a>

        </div>
    </div>
</div>

<?php endif; ?>

<?php endif; ?>


        

<?php if(
    $role == 'manager' ||
    $role == 'statistician' ||
    $role == 'physiotherapist' ||
    $role == 'coach' ||
    $role == 'conditioner' ||
    $role == 'dietitian'
): ?>

<div class="col-md-6">
    <div class="card shadow">
        <div class="card-body text-center">

            <i class="bi bi-megaphone-fill fs-1 text-warning"></i>

            <h4 class="mt-3">
                Duyurular
            </h4>

            <p>
                Takım duyurularını görüntüleyin.
            </p>

            <a href="announcements.php"
               class="btn btn-warning text-dark">

                Duyurular

            </a>

        </div>
    </div>
</div>

<?php endif; ?>

<div class="col-md-6">
    <div class="card shadow">
        <div class="card-body text-center">

            <i class="bi bi-calendar-check-fill fs-1 text-primary"></i>

            <h4 class="mt-3">
                Antrenman Programı
            </h4>

            <p>
                Antrenman programlarını görüntüleyin.
            </p>

            <a href="trainings.php"
               class="btn btn-primary">

                Antrenmanlar

            </a>

        </div>
    </div>
</div>

<?php if(
    $role == 'physiotherapist' ||
    $role == 'manager' ||
    $role == 'coach' ||
    $role == 'conditioner' ||
    $role == 'dietitian'
): ?>

<div class="col-md-6">
    <div class="card shadow">
        <div class="card-body text-center">

            <i class="bi bi-heart-pulse-fill fs-1 text-danger"></i>

            <h4 class="mt-3">
                Sakatlık Takibi
            </h4>

            <p>
                Oyuncuların sakatlık durumlarını yönetin.
            </p>

            <a href="injuries.php"
               class="btn btn-danger">

                Sakatlıklar

            </a>

        </div>
    </div>
</div>

<?php endif; ?>

<?php if(
    $role == 'conditioner' ||
    $role == 'manager' ||
    $role == 'coach' ||
    $role == 'physiotherapist' ||
    $role == 'dietitian'
): ?>

<div class="col-md-6">
    <div class="card shadow">
        <div class="card-body text-center">

            <i class="bi bi-activity fs-1 text-secondary"></i>

            <h4 class="mt-3">
                Kondisyon Programları
            </h4>

            <p>
                Oyuncuların kondisyon programlarını görüntüleyin.
            </p>

            <a href="conditioning.php"
               class="btn btn-secondary">

                Kondisyon Programları

            </a>

        </div>
    </div>
</div>

<?php endif; ?>

<?php if(
    $role == 'dietitian' ||
    $role == 'manager' ||
    $role == 'coach' ||
    $role == 'conditioner'
): ?>

<div class="col-md-6">
    <div class="card shadow">
        <div class="card-body text-center">

            <i class="bi bi-egg-fried fs-1 text-success"></i>

            <h4 class="mt-3">
                Beslenme Programları
            </h4>

            <p>
                Oyuncuların beslenme programlarını görüntüleyin.
            </p>

            <a href="nutrition.php"
               class="btn btn-success">

                Beslenme Programları

            </a>

        </div>
    </div>
</div>

<?php endif; ?>

<?php if($role == 'statistician'): ?>

<div class="col-md-6">
    <div class="card shadow">
        <div class="card-body text-center">

            <i class="bi bi-bar-chart-fill fs-1 text-info"></i>

            <h4 class="mt-3">İstatistik Ekle</h4>

            <p>Oyuncuların maç istatistiklerini ekleyin.</p>

            <a href="add_statistics.php" class="btn btn-info text-white">
                İstatistik Ekle
            </a>

        </div>
    </div>
</div>



<?php endif; ?>

<div class="col-md-6">
    <div class="card shadow">
        <div class="card-body text-center">

            <i class="bi bi-clipboard-data-fill fs-1 text-primary"></i>

            <h4 class="mt-3">İstatistikler</h4>

            <p>Oyuncu istatistiklerini görüntüleyin.</p>

            <a href="statistics.php"
               class="btn btn-primary">

                İstatistikleri Görüntüle

            </a>

        </div>
    </div>
</div>

        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body text-center">

                    <i class="bi bi-box-arrow-right fs-1 text-danger"></i>

                    <h4 class="mt-3">Çıkış Yap</h4>

                    <p>Güvenli bir şekilde çıkış yapın.</p>

                    <a href="logout.php" class="btn btn-danger">
                        Çıkış Yap
                    </a>

                </div>
            </div>
        </div>

    </div>

    <?php
$role_names = [
    'manager' => 'Takım Menajeri',
    'coach' => 'Antrenör',
    'statistician' => 'İstatistikçi',
    'physiotherapist' => 'Fizyoterapist',
    'conditioner' => 'Kondisyoner',
    'dietitian' => 'Diyetisyen'
];
?>



</div>

</body>
</html>