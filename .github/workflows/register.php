<?php
session_start();
include "db.php";

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    if (empty($username) || empty($email) || empty($password) || empty($confirm)) {
        $errors[] = "Barlıq maydanshanı toltırıń.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email qáte kiritildi.";
    } elseif ($password !== $confirm) {
        $errors[] = "Paroller mas emes.";
    } else {
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $errors[] = "Bul email dan álleqashan tizimnen ótip bolınǵan.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $is_admin = 0;

            $insert = $conn->prepare("INSERT INTO users (username, email, password, is_admin) VALUES (?, ?, ?, ?)");
            $insert->bind_param("sssi", $username, $email, $hash, $is_admin);
            $insert->execute();

            $_SESSION['user'] = $email;
            $_SESSION['username'] = $username;
            $_SESSION['is_admin'] = 0;
            header("Location: index.php");
            exit;
        }
    }
}

?>
<!DOCTYPE html>
<html lang="uz">
<head>
  <meta charset="UTF-8">
  <title>Tizimnen ótiw</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(to right, #141e30, #243b55);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      color: #fff;
    }

    .register-box {
      background:rgb(67, 67, 70);
      padding: 40px 30px;
      border-radius: 12px;
      width: 100%;
      max-width: 400px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.4);
      animation: fadeIn 0.8s ease-in-out;
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border: none;
      border-radius: 6px;
      background: #f0f0f0;
      color: #333;
      font-size: 15px;
      transition: box-shadow 0.3s ease;
    }

    input:focus {
      outline: none;
      box-shadow: 0 0 5px #00d9ff;
    }

    button {
      width: 100%;
      padding: 12px;
      background: #00d9ff;
      color: #1f1f2e;
      border: none;
      border-radius: 6px;
      font-weight: bold;
      font-size: 16px;
      cursor: pointer;
      margin-top: 10px;
      transition: background 0.3s ease;
    }

    button:hover {
      background: #00b8d4;
    }

    .errors {
      background: #ff5e5e;
      color: #fff;
      padding: 10px;
      margin-bottom: 15px;
      border-radius: 6px;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-10px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>

<div class="register-box">
  <h2>Ro‘yxatdan o‘tish</h2>

  <?php if (!empty($errors)): ?>
    <div class="errors">
      <?php foreach ($errors as $error): ?>
        <div><?= htmlspecialchars($error) ?></div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <form method="POST">
  <input type="text" name="username" placeholder="Paydalanıwshı atıńız" required>
  <input type="email" name="email" placeholder="Email poshtańız" required>
  <input type="password" name="password" placeholder="Parol" required>
  <input type="password" name="confirm" placeholder="Paroldi tastıqlań" required>
  <button type="submit">Tizimnen ótiw</button>

  <p style="text-align:center; margin-top: 15px;">
    Siz aldın tizimnen óttińizbe?
    <a href="login.php" style="color: #00d9ff; text-decoration: underline;">Kiriw</a>
  </p>
</form>
</div>

</body>
</html>
