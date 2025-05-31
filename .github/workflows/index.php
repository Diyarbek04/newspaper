<?php
session_start();
include "db.php";

// So‘nggi 5 ta yangilikni olish
$news = $conn->query("SELECT * FROM news ORDER BY created_at DESC LIMIT 5");

// Tizimga kirgan foydalanuvchini tekshirish
$loggedIn = isset($_SESSION['user']);
$username = $loggedIn ? $_SESSION['username'] : null;
$isAdmin = $loggedIn ? $_SESSION['is_admin'] : 0;
?>

<!DOCTYPE html>
<html lang="uz">
<head>
  <meta charset="UTF-8">
  <title>Gazeta.uz – Sońǵı jańalıqlar</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background-color: #f4f4f4;
    }

    .navbar {
      background: linear-gradient(90deg, #1f1f2e, #2a2a3d);
      padding: 15px 30px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      color: #fff;
      box-shadow: 0 3px 10px rgba(0,0,0,0.3);
    }

    .navbar .logo {
      font-size: 24px;
      font-weight: bold;
      color: #00d9ff;
      text-decoration: none;
    }

    .navbar .nav-links a {
      color: #fff;
      text-decoration: none;
      margin-left: 20px;
      font-weight: 500;
      position: relative;
      transition: color 0.3s ease;
    }

    .navbar .nav-links a::after {
      content: '';
      position: absolute;
      bottom: -4px;
      left: 0;
      width: 0%;
      height: 2px;
      background: #00d9ff;
      transition: width 0.3s ease;
    }

    .navbar .nav-links a:hover::after {
      width: 100%;
    }

    .navbar .nav-links a:hover {
      color: #00d9ff;
    }

    .container {
      padding: 40px 30px;
    }

    .news-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 20px;
    }

    .card {
      background: white;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      animation: fadeUp 0.8s ease-in;
      text-decoration: none;
      color: inherit;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    }

    .card img {
      width: 100%;
      height: 180px;
      object-fit: cover;
    }

    .card-content {
      padding: 15px;
    }

    .card-content h3 {
      margin: 0 0 10px;
      color: #333;
      font-size: 18px;
    }

    .card-content p {
      margin: 0;
      color: #666;
      font-size: 14px;
    }

    @keyframes fadeUp {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>
</head>
<body>

<div class="navbar">
  <a href="index.php" class="logo">Gazeta.uz</a>
  <div class="nav-links">
    <a href="index.php">Bas bet</a>
    <a href="news.php">Barlıq jańalıqlar</a>

    <?php if ($loggedIn && !$isAdmin): ?>
      <a href="chat.php">Admin menen baylanısıw</a>
    <?php endif; ?>

    <?php if ($loggedIn): ?>
      <?php if ($isAdmin): ?>
        <a href="admin_dashboard.php">🛠 Admin Panel</a>
      <?php endif; ?>
      <span style="margin-left: 20px;">👤 <?= htmlspecialchars($username) ?></span>
      <a href="logout.php">Shıǵıw</a>
    <?php else: ?>
      <a href="register.php">Tizimnen ótiw</a>
      <a href="login.php">Tizimge kiriw</a>
    <?php endif; ?>
  </div>
</div>

<div class="container">
  <h2>📰 Sońǵı Jańalıqlar</h2>
  <div class="news-grid">
    <?php while ($row = mysqli_fetch_assoc($news)): ?>
      <a href="news_detail.php?id=<?= $row['id'] ?>" class="card">
        <img src="uploads/<?= htmlspecialchars($row['image']) ?>" alt="Rasm">
        <div class="card-content">
          <h3><?= htmlspecialchars($row['title']) ?></h3>
          <p><?= mb_substr(strip_tags($row['content']), 0, 100) ?>...</p>
        </div>
      </a>
    <?php endwhile; ?>
  </div>
</div>

</body>
</html>
