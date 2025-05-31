<?php
session_start();
include "db.php";

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $errors[] = "Email hám paroldi toltırıń.";
    } else {
        $stmt = $conn->prepare("SELECT id, username, password, is_admin FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            $stmt->bind_result($id, $username, $hashed, $is_admin);
            $stmt->fetch();

            if (password_verify($password, $hashed)) {
                $_SESSION['user'] = $email;
                $_SESSION['username'] = $username;
                $_SESSION['is_admin'] = $is_admin;

                // ✅ Admin bo‘lsa admin panelga, oddiy foydalanuvchi bo‘lsa indexga
                if ($is_admin == 1) {
                    header("Location: admin_dashboard.php");
                } else {
                    header("Location: index.php");
                }
                exit;
            } else {
                $errors[] = "Parol qáte.";
            }
        } else {
            $errors[] = "Bunday paydalanıwshı tawılmadı.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="uz">
<head>
  <meta charset="UTF-8">
  <title>Tizimga kirish</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      color: #fff;
    }

    .login-box {
      background: rgb(67, 67, 70);
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

    p {
      text-align: center;
      margin-top: 15px;
    }

    p a {
      color: #00d9ff;
      text-decoration: underline;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-10px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>

<div class="login-box">
  <h2>Tizimge kiriw</h2>

  <?php if (!empty($errors)): ?>
    <div class="errors">
      <?php foreach ($errors as $error): ?>
        <div><?= htmlspecialchars($error) ?></div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <form method="POST">
    <input type="email" name="email" placeholder="Email poshtańız" required>
    <input type="password" name="password" placeholder="Parol" required>
    <button type="submit">Kiriw</button>

    <p>Tizimnen ótpedińizbe? <a href="register.php">Tizimnen ótiw</a></p>
  </form>
</div>

</body>
</html>
