<?php
session_start();
if ($_SESSION['role'] != 'manager') {
    header("Location: players.php");
    exit();
}
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $full_name = trim($_POST['full_name']);
$full_name = mb_convert_case(mb_strtolower($full_name, 'UTF-8'), MB_CASE_TITLE, 'UTF-8');
    $position = $_POST['position'];
    $jersey_number = $_POST['jersey_number'];
    $height = $_POST['height'];
    $birth_date = $_POST['birth_date'];
    $created_by = $_SESSION['user_id'];

    $check_sql = "SELECT id FROM players 
              WHERE full_name = ? 
              AND jersey_number = ?";

$check_stmt = $conn->prepare($check_sql);

$check_stmt->bind_param(
    "si",
    $full_name,
    $jersey_number
);

$check_stmt->execute();

$check_result = $check_stmt->get_result();

if ($check_result->num_rows > 0) {

    echo "<script>
            alert('Bu oyuncu zaten kayıtlı!');
            window.location.href='add_player.php';
          </script>";

    exit();
}

    $sql = "INSERT INTO players 
            (full_name, position, jersey_number, height, birth_date, created_by)
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "ssiisi",
        $full_name,
        $position,
        $jersey_number,
        $height,
        $birth_date,
        $created_by
    );

    if ($stmt->execute()) {
        header("Location: players.php");
        exit();
    }
}
?>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oyuncu Ekle</title>

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

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card shadow">

                <div class="card-header bg-success text-white">
                    <h3 class="mb-0">
                        <i class="bi bi-person-plus-fill"></i>
                        Oyuncu Ekle
                    </h3>
                </div>

                <div class="card-body">

                    <form method="POST">

                        <div class="mb-3">
                            <label class="form-label">Ad Soyad</label>

                            <input type="text"
                                   class="form-control"
                                   name="full_name"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Pozisyon</label>

                            <select class="form-select"
                                    name="position"
                                    required>

                                <option value="Pasör">Pasör</option>
                                <option value="Smaçör">Smaçör</option>
                                <option value="Orta Oyuncu">Orta Oyuncu</option>
                                <option value="Libero">Libero</option>
                                <option value="Pasör Çaprazı">Pasör Çaprazı</option>

                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Forma Numarası</label>

                            <input type="number"
                                   class="form-control"
                                   name="jersey_number"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Boy (cm)</label>

                            <input type="number"
                                   class="form-control"
                                   name="height"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Doğum Tarihi</label>

                            <input type="date"
                                   class="form-control"
                                   name="birth_date"
                                   required>
                        </div>

                        <div class="d-flex justify-content-between">

                            <a href="players.php"
                               class="btn btn-secondary">

                                Geri Dön

                            </a>

                            <button type="submit"
                                    class="btn btn-success">

                                <i class="bi bi-check-circle-fill"></i>
                                Oyuncu Ekle

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>