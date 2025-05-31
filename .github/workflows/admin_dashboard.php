<?php
session_start();
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
      font-family: Arial, sans-serif;
      background: #f1f1f1;
      margin: 0;
      padding: 0;
    }

    .header {
      background: #0d47a1;
      color: white;
      padding: 20px 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .header h2 {
      margin: 0;
    }

    .container {
      padding: 40px;
    }

    .card-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
    }

    .card {
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      text-align: center;
      transition: transform 0.3s ease;
    }

    .card:hover {
      transform: translateY(-5px);
    }

    .card a {
      text-decoration: none;
      color: #0d47a1;
      font-size: 18px;
      font-weight: bold;
    }

    .logout {
      background: #e53935;
      color: white;
      padding: 10px 20px;
      border-radius: 6px;
      text-decoration: none;
      font-weight: bold;
    }

    .logout:hover {
      background: #c62828;
    }
  </style>
</head>
<body>

  <div class="header">
    <h2>👨‍💼 Admin Panel</h2>
    <a class="logout" href="logout.php">🚪 Shıǵıw</a>
  </div>

  <div class="container">
    <div class="card-grid">
      <div class="card">
        <a href="add_news.php">➕ Jańalıq qosıw</a>
      </div>
      <div class="card">
        <a href="manage_news.php">📰 Jańalıqlardı basqarıw</a>
      </div>
      <div class="card">
        <a href="chat_admin.php">💬 Chatdı kóriw</a>
      </div>
      <div class="card">
        <a href="index.php">🏠 Saytqa qaytıw</a>
      </div>
    </div>
  </div>

</body>
</html>
