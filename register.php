<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    if ($stmt->execute([$name, $email, $password])) {
        header("Location: login.php");
        exit;
    } else {
        echo "Kayıt başarısız!";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kayıt Ol - Aşı Takip Sistemi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .register-container {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }
        .register-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .register-header i {
            font-size: 3rem;
            color: #0d6efd;
            margin-bottom: 1rem;
        }
        .form-control {
            padding: 0.8rem;
            margin-bottom: 1rem;
        }
        .btn-register {
            width: 100%;
            padding: 0.8rem;
            font-size: 1.1rem;
        }
        .login-link {
            text-align: center;
            margin-top: 1rem;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-header">
            <i class="fas fa-user-plus"></i>
            <h2>Yeni Hesap Oluştur</h2>
            <p class="text-muted">Aşı takip sistemine kayıt olun</p>
        </div>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="mb-3">
                <input type="text" class="form-control" name="name" placeholder="Adınız Soyadınız" required>
            </div>
            <div class="mb-3">
                <input type="email" class="form-control" name="email" placeholder="E-posta adresiniz" required>
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" name="password" placeholder="Şifreniz" required>
            </div>
            <button type="submit" class="btn btn-primary btn-register">Kayıt Ol</button>
        </form>
        <div class="login-link">
            <p>Zaten hesabınız var mı? <a href="login.php">Giriş Yapın</a></p>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
