<?php
session_start();
include "db.php";

$loggedIn = isset($_SESSION['user']);
$username = $loggedIn ? $_SESSION['username'] : null;
$user_email = $loggedIn ? $_SESSION['email'] : null;
$isAdmin = $loggedIn ? $_SESSION['is_admin'] : 0;

$category = isset($_GET['category']) ? $_GET['category'] : '';
$validCategories = ['Texnologiya', 'Sport', 'Siyosat', 'Eń sońǵı'];

if ($category && in_array($category, $validCategories)) {
    $stmt = $conn->prepare("SELECT * FROM news WHERE category = ? ORDER BY created_at DESC");
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $news = $stmt->get_result();
} else {
    $news = $conn->query("SELECT * FROM news ORDER BY created_at DESC");
}
?>

<!DOCTYPE html>
<html lang="uz">
<head>
  <meta charset="UTF-8">
  <title>Barlıq jańalıqlar – Gazeta.uz</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      background: #f0f4f8;
    }
    .navbar {
      background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
      padding: 20px 30px;
      color: white;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    }
    .navbar a {
      color: white;
      margin-left: 20px;
      text-decoration: none;
      transition: color 0.3s;
    }
    .navbar a:hover {
      color: #00d9ff;
    }
    .logo {
      font-size: 26px;
      font-weight: bold;
      color: #00d9ff;
    }
    .container {
      padding: 40px 30px;
      max-width: 1200px;
      margin: auto;
    }
    .filter-buttons {
      margin-bottom: 30px;
    }
    .filter-buttons a {
      padding: 10px 16px;
      margin-right: 10px;
      text-decoration: none;
      background: #ffffff;
      border: 1px solid #ccc;
      border-radius: 8px;
      color: #333;
      transition: all 0.3s;
      font-weight: 500;
    }
    .filter-buttons a:hover {
      background-color: #00d9ff;
      color: #fff;
    }
    .filter-buttons a.active {
      background-color: #00d9ff;
      color: white;
      border: none;
    }
    .news-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 25px;
    }
    .card {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(4px);
      border-radius: 16px;
      overflow: hidden;
      box-shadow: 0 10px 20px rgba(0,0,0,0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card:hover {
      transform: translateY(-6px);
      box-shadow: 0 14px 28px rgba(0,0,0,0.15);
    }
    .card a {
      text-decoration: none;
      color: inherit;
    }
    .card img {
      width: 100%;
      height: 190px;
      object-fit: cover;
    }
    .card-content {
      padding: 16px;
    }
    .card-content h3 {
      margin: 0 0 10px;
      font-size: 18px;
    }
    .card-content p {
      color: #555;
      font-size: 14px;
    }
    @media (max-width: 600px) {
      .news-grid {
        grid-template-columns: 1fr;
      }
      .card img {
        height: 150px;
      }
    }
  </style>
</head>
<body>

<div class="navbar">
  <a href="index.php" class="logo">Gazeta.uz</a>
  <div>
    <a href="index.php">Bas bet</a>
    <?php if ($loggedIn && !$isAdmin): ?>
      <a href="chat.php">Admin menen baylanısıw</a>
    <?php endif; ?>
    <?php if ($loggedIn): ?>
      <span>👤 <?= htmlspecialchars($username) ?></span>
      <a href="logout.php">Shıǵıw</a>
    <?php else: ?>
      <a href="register.php">Tizimnen ótiw</a>
      <a href="login.php">Tizimgw kiriw</a>
    <?php endif; ?>
  </div>
</div>

<div class="container">
  <h2 style="text-align:center; margin-bottom:30px;">📰 Barlıq jańalıqlar</h2>

  <div class="filter-buttons">
    <a href="news.php" class="<?= $category == '' ? 'active' : '' ?>">🔄 Barlıǵı</a>
    <a href="news.php?category=Texnologiya" class="<?= $category == 'Texnologiya' ? 'active' : '' ?>">💻 Texnologiya</a>
    <a href="news.php?category=Sport" class="<?= $category == 'Sport' ? 'active' : '' ?>">🏅 Sport</a>
    <a href="news.php?category=Siyosat" class="<?= $category == 'Siyasat' ? 'active' : '' ?>">🏛 Siyasat</a>
    <a href="news.php?category=enaqirgi" class="<?= $category == 'Eń sońǵı' ? 'active' : '' ?>">🏛 Eń sońǵı</a>
  </div>

  <div class="news-grid">
    <?php while ($row = $news->fetch_assoc()): ?>
      <div class="card">
        <a href="news_detail.php?id=<?= $row['id'] ?>">
          <img src="uploads/<?= htmlspecialchars($row['image']) ?>" alt="Rasm">
          <div class="card-content">
            <h3><?= htmlspecialchars($row['title']) ?></h3>
            <p><?= mb_substr(strip_tags($row['content']), 0, 100) ?>...</p>
          </div>
        </a>
      </div>
    <?php endwhile; ?>
  </div>
</div>

</body>
</html>
