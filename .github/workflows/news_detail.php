<?php
session_start();
include "db.php";

$loggedIn = isset($_SESSION['user']);
$username = $loggedIn ? $_SESSION['username'] : null;
$user_email = $loggedIn ? $_SESSION['email'] : null;
$isAdmin = $loggedIn ? $_SESSION['is_admin'] : 0;

$newsId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Yangilikni olish
$stmt = $conn->prepare("SELECT * FROM news WHERE id = ?");
$stmt->bind_param("i", $newsId);
$stmt->execute();
$result = $stmt->get_result();
$news = $result->fetch_assoc();

if (!$news) {
    echo "Jańalıq tawılmadı.";
    exit;
}

// Sharh qo‘shish
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $loggedIn && isset($_POST['comment'])) {
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);
    $commentUser = mysqli_real_escape_string($conn, $username);
    $commentEmail = mysqli_real_escape_string($conn, $user_email);

    $conn->query("INSERT INTO comments (news_id, username, email, comment) VALUES ($newsId, '$commentUser', '$commentEmail', '$comment')");
}

// Sharhlarni olish
$comments = $conn->query("SELECT * FROM comments WHERE news_id = $newsId ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="uz">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($news['title']) ?> – Gazeta.uz</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: #f8f9fa;
      margin: 0;
      padding: 0;
    }
    .navbar {
      background: #0f2027;
      padding: 20px 30px;
      color: white;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .navbar a {
      color: white;
      margin-left: 20px;
      text-decoration: none;
    }
    .logo {
      font-size: 24px;
      font-weight: bold;
      color: #00d9ff;
    }

    .container {
      max-width: 900px;
      margin: auto;
      padding: 40px 20px;
      background: white;
      margin-top: 30px;
      border-radius: 12px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }
    h1 {
      margin-bottom: 20px;
    }
    img {
      max-width: 100%;
      border-radius: 10px;
      margin-bottom: 20px;
    }
    .comment-section {
      margin-top: 40px;
    }
    .comment-section h3 {
      margin-bottom: 10px;
    }
    .comment-form textarea {
      width: 100%;
      padding: 10px;
      border-radius: 8px;
      border: 1px solid #ccc;
      resize: vertical;
    }
    .comment-form button {
      margin-top: 10px;
      padding: 10px 16px;
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }
    .comment-item {
      background: #f1f1f1;
      margin-bottom: 12px;
      padding: 12px;
      border-radius: 8px;
    }
    .comment-item strong {
      color: #333;
    }
    .back-link {
      margin-top: 20px;
      display: inline-block;
      text-decoration: none;
      color: #007bff;
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
      <a href="logout.php">Chiqish</a>
    <?php else: ?>Tizimnen ótiw</a>
      <a href="login.php">Tizimge kiriw</a>
    <?php endif; ?>
  </div>
</div>

<div class="container">
  <h1><?= htmlspecialchars($news['title']) ?></h1>
  <img src="uploads/<?= htmlspecialchars($news['image']) ?>" alt="Rasm">
  <p><?= nl2br(htmlspecialchars($news['content'])) ?></p>

  <div class="comment-section">
    <h3>💬 Komentler</h3>

    <?php if ($loggedIn): ?>
      <form method="post" class="comment-form">
        <textarea name="comment" rows="3" required placeholder="Koment jazıń..."></textarea>
        <br>
        <button type="submit">Jiberiw</button>
      </form>
    <?php else: ?>
      <p>Koment jazıw ushın <a href="login.php">Tizimge kiriw</a>.</p>
    <?php endif; ?>

    <?php while ($row = $comments->fetch_assoc()): ?>
      <div class="comment-item">
        <strong><?= htmlspecialchars($row['username']) ?> (<?= htmlspecialchars($row['email']) ?>)</strong>
        <p><?= htmlspecialchars($row['comment']) ?></p>
      </div>
    <?php endwhile; ?>
  </div>

  <a class="back-link" href="news.php">← Barlıq jańalıqlarǵa qaytıw</a>
</div>

</body>
</html>
