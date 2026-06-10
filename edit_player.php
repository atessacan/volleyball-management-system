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

$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $full_name = trim($_POST['full_name']);
$full_name = mb_convert_case(mb_strtolower($full_name, 'UTF-8'), MB_CASE_TITLE, 'UTF-8');
    $position = $_POST['position'];
    $jersey_number = $_POST['jersey_number'];
    $height = $_POST['height'];
    $birth_date = $_POST['birth_date'];

    $sql = "UPDATE players 
            SET full_name = ?, 
                position = ?, 
                jersey_number = ?, 
                height = ?, 
                birth_date = ?
            WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "ssiisi",
        $full_name,
        $position,
        $jersey_number,
        $height,
        $birth_date,
        $id
    );

    $stmt->execute();

    header("Location: players.php");
    exit();
}

$sql = "SELECT * FROM players WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$player = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oyuncu Düzenle</title>

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

                <div class="card-header bg-warning">
                    <h3 class="mb-0">
                        <i class="bi bi-pencil-fill"></i>
                        Oyuncu Düzenle
                    </h3>
                </div>

                <div class="card-body">

                    <form method="POST">

                        <div class="mb-3">
                            <label class="form-label">Ad Soyad</label>

                            <input type="text"
                                   class="form-control"
                                   name="full_name"
                                   value="<?php echo htmlspecialchars($player['full_name']); ?>"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Pozisyon</label>

                            <select class="form-select"
                                    name="position"
                                    required>

                                <option value="Pasör" <?php if($player['position'] == 'Pasör') echo 'selected'; ?>>Pasör</option>

                                <option value="Smaçör" <?php if($player['position'] == 'Smaçör') echo 'selected'; ?>>Smaçör</option>

                                <option value="Orta Oyuncu" <?php if($player['position'] == 'Orta Oyuncu') echo 'selected'; ?>>Orta Oyuncu</option>

                                <option value="Libero" <?php if($player['position'] == 'Libero') echo 'selected'; ?>>Libero</option>

                                <option value="Pasör Çaprazı" <?php if($player['position'] == 'Pasör Çaprazı') echo 'selected'; ?>>Pasör Çaprazı</option>

                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Forma Numarası</label>

                            <input type="number"
                                   class="form-control"
                                   name="jersey_number"
                                   value="<?php echo $player['jersey_number']; ?>"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Boy (cm)</label>

                            <input type="number"
                                   class="form-control"
                                   name="height"
                                   value="<?php echo $player['height']; ?>"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Doğum Tarihi</label>

                            <input type="date"
                                   class="form-control"
                                   name="birth_date"
                                   value="<?php echo $player['birth_date']; ?>"
                                   required>
                        </div>

                        <div class="d-flex justify-content-between">

                            <a href="players.php"
                               class="btn btn-secondary">

                                Geri Dön

                            </a>

                            <button type="submit"
                                    class="btn btn-warning">

                                <i class="bi bi-check-circle-fill"></i>
                                Güncelle

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