<?php

include 'config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $sql = "INSERT INTO users (username, email, password, role)
            VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $username, $email, $password, $role);

    if ($stmt->execute()) {
        echo "<p style='color:green;'>Kayıt başarılı!</p>";
    } else {
        echo "<p style='color:red;'>Hata: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kayıt Ol</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="bg-light">

<div class="container vh-100 d-flex justify-content-center align-items-center">

    <div class="card shadow p-4" style="width: 450px;">

        <div class="text-center mb-4">

            <i class="bi bi-person-plus-fill text-success" style="font-size: 50px;"></i>

            <h2 class="mt-3">VolleyStats</h2>

            <p class="text-muted">
                Yeni Hesap Oluştur
            </p>

        </div>

        <form method="POST">

            <div class="mb-3">

                <label class="form-label">
                    Kullanıcı Adı
                </label>

                <input type="text"
                       name="username"
                       class="form-control"
                       required>

            </div>

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

            <div class="mb-3">

                <label class="form-label">
                    Rol
                </label>

                <select name="role"
                        class="form-select"
                        required>

                    <option value="">Rol Seçiniz</option>
                    <option value="coach">Antrenör</option>
                    <option value="statistician">İstatistikçi</option>
                    <option value="manager">Takım Menajeri</option>
                    <option value="physiotherapist">Fizyoterapist</option>
                    <option value="conditioner">Kondisyoner</option>
                    <option value="dietitian">Diyetisyen</option>

                </select>

            </div>

            <button type="submit"
                    class="btn btn-success w-100">

                <i class="bi bi-person-check-fill"></i>

                Kayıt Ol

            </button>

        </form>

        <div class="text-center mt-3">

            <p class="mb-0">

                Zaten hesabın var mı?

                <a href="login.php">
                    Giriş Yap
                </a>

            </p>

        </div>

    </div>

</div>

</body>
</html>