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

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    $stmt = $conn->prepare("
        INSERT INTO announcements (
            title,
            content
        )
        VALUES (?, ?)
    ");

    $stmt->bind_param(
        "ss",
        $title,
        $content
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
    <title>Duyuru Ekle</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-header bg-warning">

            <h2>
                <i class="bi bi-megaphone-fill"></i>
                Duyuru Ekle
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
                           required>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Duyuru İçeriği
                    </label>

                    <textarea name="content"
                              class="form-control"
                              rows="5"
                              required></textarea>

                </div>

                <button type="submit"
                        class="btn btn-warning">

                    <i class="bi bi-plus-circle"></i>

                    Duyuru Yayınla

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