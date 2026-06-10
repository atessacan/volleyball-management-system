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

if (!isset($_GET['id'])) {
    header("Location: staff.php");
    exit();
}

$id = $_GET['id'];

$stmt = $conn->prepare("
    SELECT *
    FROM staff
    WHERE id = ?
");

$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("Location: staff.php");
    exit();
}

$staff = $result->fetch_assoc();
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $full_name = trim($_POST['full_name']);
    $role = $_POST['role'];
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    $stmt = $conn->prepare("
        UPDATE staff
        SET
            full_name = ?,
            role = ?,
            email = ?,
            phone = ?
        WHERE id = ?
    ");

    $stmt->bind_param(
        "ssssi",
        $full_name,
        $role,
        $email,
        $phone,
        $id
    );

    if ($stmt->execute()) {

        echo "<script>
                alert('Personel başarıyla güncellendi!');
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
    <title>Personel Düzenle</title>

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
                Personel Düzenle
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
                           value="<?= htmlspecialchars($staff['full_name']) ?>"
                           required>

                </div>

                <div class="mb-3">

    <label class="form-label">
        Rol
    </label>

    <select name="role"
            class="form-select"
            required>

        <option value="coach"
            <?= ($staff['role'] == 'coach') ? 'selected' : '' ?>>
            Antrenör
        </option>

        <option value="statistician"
            <?= ($staff['role'] == 'statistician') ? 'selected' : '' ?>>
            İstatistikçi
        </option>

        <option value="physiotherapist"
            <?= ($staff['role'] == 'physiotherapist') ? 'selected' : '' ?>>
            Fizyoterapist
        </option>

        <option value="conditioner"
            <?= ($staff['role'] == 'conditioner') ? 'selected' : '' ?>>
            Kondisyoner
        </option>

        <option value="dietitian"
            <?= ($staff['role'] == 'dietitian') ? 'selected' : '' ?>>
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
           class="form-control"
           value="<?= htmlspecialchars($staff['email']) ?>">

</div>

<div class="mb-3">

    <label class="form-label">
        Telefon
    </label>

    <input type="text"
           name="phone"
           class="form-control"
           value="<?= htmlspecialchars($staff['phone']) ?>">

</div>

<button type="submit"
        class="btn btn-warning">

    Güncelle

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