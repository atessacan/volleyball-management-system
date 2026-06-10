<?php
session_start();



if ($_SESSION['role'] != 'manager') {
    header("Location: dashboard.php");
    exit();
}

include 'config/db.php';

if (!isset($_GET['id'])) {
    header("Location: announcements.php");
    exit();
}

$id = $_GET['id'];

$stmt = $conn->prepare("
    SELECT *
    FROM announcements
    WHERE id = ?
");

$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("Location: announcements.php");
    exit();
}

$announcement = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    $stmt = $conn->prepare("
        UPDATE announcements
        SET title = ?, content = ?
        WHERE id = ?
    ");

    $stmt->bind_param(
        "ssi",
        $title,
        $content,
        $id
    );

    if ($stmt->execute()) {

        header("Location: announcements.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Duyuru Düzenle</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-header bg-warning">

            <h2>
                <i class="bi bi-pencil-fill"></i>
                Duyuru Düzenle
            </h2>

        </div>

        <div class="card-body">

            <form method="POST">

                <div class="mb-3">

                    <label class="form-label">
                        Duyuru Başlığı
                    </label>

                    <input type="text"
                           name="title"
                           class="form-control"
                           value="<?= htmlspecialchars($announcement['title']) ?>"
                           required>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Duyuru İçeriği
                    </label>

                    <textarea name="content"
                              class="form-control"
                              rows="5"
                              required><?= htmlspecialchars($announcement['content']) ?></textarea>

                </div>

                <button type="submit"
                        class="btn btn-warning">

                    <i class="bi bi-check-circle"></i>

                    Güncelle

                </button>

                <a href="announcements.php"
                   class="btn btn-secondary">

                    Geri Dön

                </a>

            </form>

        </div>

    </div>

</div>

</body>
</html>