<?php
session_start();
include 'db.php';

// Faqat adminlar kira oladi
if (!isset($_SESSION['user']) || $_SESSION['is_admin'] != 1) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="uz">
<head>
  <meta charset="UTF-8">
  <title>Admin Panel</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f4f4f4;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 800px;
      margin: 50px auto;
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

    h2 {
      color: #333;
      margin-bottom: 30px;
    }

    .btn {
      display: inline-block;
      margin: 15px;
      padding: 12px 25px;
      background-color: #00bcd4;
      color: #fff;
      border: none;
      border-radius: 6px;
      text-decoration: none;
      font-size: 16px;
      transition: background 0.3s ease;
    }

    .btn:hover {
      background-color: #0097a7;
    }

    .logout {
      background-color: #e53935;
    }

    .logout:hover {
      background-color: #c62828;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>👋 Assalawmı alikum, <?= htmlspecialchars($_SESSION['username']) ?> (Admin)</h2>

    <a href="add_news.php" class="btn">➕ Jańalıq qosıw</a>
    <a href="manage_news.php" class="btn">🗂 Jańalıqlardı basqarıw</a>
    <a href="chat_admin.php" class="btn">💬 Paydalanıwshı xabarlar</a>
    <a href="logout.php" class="btn logout">🚪 Shıǵıw</a>
  </div>
</body>
</html>
