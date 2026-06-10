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

    $full_name = trim($_POST['full_name']);
    $role = $_POST['role'];
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    $stmt = $conn->prepare("
        INSERT INTO staff (
            full_name,
            role,
            email,
            phone
        )
        VALUES (?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "ssss",
        $full_name,
        $role,
        $email,
        $phone
    );

    if ($stmt->execute()) {

        echo "<script>
                alert('Personel başarıyla eklendi!');
                window.location.href='staff.php';
              </script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personel Ekle</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-header bg-success text-white">

            <h2>
                <i class="bi bi-person-plus-fill"></i>
                Personel Ekle
            </h2>

        </div>

        <div class="card-body">

            <form method="POST">

                <div class="mb-3">

                    <label class="form-label">
                        Ad Soyad
                    </label>

                    <input type="text"
                           name="full_name"
                           class="form-control"
                           required>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Rol
                    </label>

                    <select name="role"
                            class="form-select"
                            required>

                        <option value="">Rol Seçiniz</option>

                        <option value="coach">
                            Antrenör
                        </option>

                        <option value="statistician">
                            İstatistikçi
                        </option>

                        <option value="physiotherapist">
                            Fizyoterapist
                        </option>

                        <option value="conditioner">
                            Kondisyoner
                        </option>

                        <option value="dietitian">
                            Diyetisyen
                        </option>

                    </select>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        E-posta
                    </label>

                    <input type="email"
                           name="email"
                           class="form-control">

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Telefon
                    </label>

                    <input type="text"
                           name="phone"
                           class="form-control">

                </div>

                <button type="submit"
                        class="btn btn-success">

                    Personel Ekle

                </button>

                <a href="staff.php"
                   class="btn btn-secondary">

                    Geri Dön

                </a>

            </form>

        </div>

    </div>

</div>

</body>
</html>