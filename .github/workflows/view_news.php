<?php
session_start();
include "db.php";

if (!isset($_GET['id'])) {
    echo "Yangilik topilmadi.";
    exit;
}

$news_id = (int)$_GET['id'];

// Yangilikni olish
$stmt = $conn->prepare("SELECT * FROM news WHERE id = ?");
$stmt->bind_param("i", $news_id);
$stmt->execute();
$result = $stmt->get_result();
$news = $result->fetch_assoc();

if (!$news) {
    echo "Jańalıq tabılmadı.";
    exit;
}

// Koment qo‘shish
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user'])) {
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);
    $user_id = $_SESSION['user'];
    $insert = $conn->prepare("INSERT INTO comments (news_id, user_id, comment) VALUES (?, ?, ?)");
    $insert->bind_param("iis", $news_id, $user_id, $comment);
    $insert->execute();
}

// Kommentlarni olish
$comments = $conn->prepare("
    SELECT c.comment, c.created_at, u.username
    FROM comments c
    JOIN users u ON c.user_id = u.id
    WHERE c.news_id = ?
    ORDER BY c.created_at DESC
");
$comments->bind_param("i", $news_id);
$comments->execute();
$commentResults = $comments->get_result();
?>

<!DOCTYPE html>
<html lang="uz">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($news['title']) ?> – Gazeta.uz</title>
  <style>
    body {
      font-family: sans-serif;
      margin: 0;
      background: #f4f4f4;
    }

    .container {
      max-width: 800px;
      margin: 40px auto;
      background: #fff;
      padding: 20px 30px;
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    h1 {
      color: #333;
    }

    .content {
      margin: 20px 0;
    }

    img {
      max-width: 100%;
      margin-bottom: 20px;
      border-radius: 5px;
    }

    .comments {
      margin-top: 40px;
    }

    .comment {
      background: #f9f9f9;
      padding: 15px;
      margin-bottom: 15px;
      border-radius: 6px;
    }

    .comment strong {
      color: #007acc;
    }

    textarea {
      width: 100%;
      height: 100px;
      padding: 10px;
      border-radius: 6px;
      border: 1px solid #ccc;
      resize: vertical;
    }

    .btn {
      margin-top: 10px;
      padding: 10px 16px;
      background-color: #00b0cc;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .btn:hover {
      background-color: #0092aa;
    }
  </style>
</head>
<body>

<div class="container">
  <h1><?= htmlspecialchars($news['title']) ?></h1>
  <img src="<?= htmlspecialchars($news['image']) ?>" alt="Rasm">
  <div class="content"><?= nl2br(htmlspecialchars($news['content'])) ?></div>

  <div class="comments">
    <h3>💬 Fikrlar</h3>

    <?php if (isset($_SESSION['user'])): ?>
      <form method="POST">
        <textarea name="comment" placeholder="Pikiringizdi jazıń..." required></textarea>
        <button type="submit" class="btn">Jiberiw</button>
      </form>
    <?php else: ?>
      <p>Komentariya jazıw ushın <a href="login.php">Tizimge kiriń</a>.</p>
    <?php endif; ?>

    <?php while ($row = $commentResults->fetch_assoc()): ?>
      <div class="comment">
        <strong><?= htmlspecialchars($row['username']) ?></strong> – <small><?= $row['created_at'] ?></small>
        <p><?= nl2br(htmlspecialchars($row['comment'])) ?></p>
      </div>
    <?php endwhile; ?>
  </div>
</div>

</body>
</html>
