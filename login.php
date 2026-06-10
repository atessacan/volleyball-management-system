<?php
include 'config/db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows == 1) {

        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            header("Location: dashboard.php");
            exit();

        } else {
            echo "<p style='color:red;'>Şifre yanlış!</p>";
        }

    } else {
        echo "<p style='color:red;'>Kullanıcı bulunamadı!</p>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Yap</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="bg-light">

<div class="container vh-100 d-flex justify-content-center align-items-center">

    <div class="card shadow p-4" style="width: 400px;">

        <div class="text-center mb-4">

            <i class="bi bi-trophy-fill text-primary" style="font-size: 50px;"></i>

            <h2 class="mt-3">VolleyStats</h2>

            <p class="text-muted">
                Voleybol Takım Yönetim Sistemi
            </p>

        </div>

        <form method="POST">

            <div class="mb-3">

                <label class="form-label">
                    E-posta
                </label>

                <input type="email"
                       name="email"
                       class="form-control"
                       required>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Şifre
                </label>

                <input type="password"
                       name="password"
                       class="form-control"
                       required>

            </div>

            <button type="submit"
                    class="btn btn-primary w-100">

                <i class="bi bi-box-arrow-in-right"></i>

                Giriş Yap

            </button>

        </form>

        <div class="text-center mt-3">

            <p class="mb-0">

                Hesabın yok mu?

                <a href="register.php">
                    Kayıt Ol
                </a>

            </p>

        </div>

    </div>

</div>

</body>
</html>