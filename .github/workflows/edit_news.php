<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user']) || $_SESSION['is_admin'] != 1) {
    header("Location: login.php");
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Yangilikni olish
$sql = "SELECT * FROM news WHERE id = $id";
$result = mysqli_query($conn, $sql);
$news = mysqli_fetch_assoc($result);

if (!$news) {
    echo "Jańalıqlar tawılmadı.";
    exit;
}

// Tahrirlash formasidan yuborilgan bo‘lsa
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $imagePath = $news['image'];

    // Yangi rasm yuklangan bo‘lsa
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $imageName = time() . "_" . basename($_FILES['image']['name']);
        $targetDir = "uploads/";
        $targetFile = $targetDir . $imageName;
        if (!is_dir($targetDir)) {
            mkdir($targetDir);
        }

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $imagePath = $imageName; // faqat nomi
        }
    }

    // Yangilash
    $updateSql = "UPDATE news SET title='$title', content='$content', category='$category', image='$imagePath' WHERE id=$id";
    if (mysqli_query($conn, $updateSql)) {
        echo "<script>alert('✅ Jańalıqlar jańalandı!'); window.location.href='manage_news.php';</script>";
    } else {
        echo "❌ Qátelik: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="uz">
<head>
  <meta charset="UTF-8">
  <title>Yangilikni tahrirlash</title>
  <style>
    body {
      background: #f5f5f5;
      font-family: sans-serif;
    }

    .form-box {
      max-width: 600px;
      margin: 40px auto;
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    h2 {
      text-align: center;
      color: #333;
    }

    input[type="text"],
    textarea,
    select,
    input[type="file"] {
      width: 100%;
      padding: 10px;
      margin-top: 10px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }

    textarea {
      height: 150px;
      resize: vertical;
    }

    img {
      max-width: 100%;
      margin-top: 15px;
      border-radius: 5px;
    }

    .btn {
      background-color: #2196F3;
      color: white;
      padding: 12px 20px;
      margin-top: 20px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      width: 100%;
      font-size: 16px;
    }

    .btn:hover {
      background-color: #1976D2;
    }
  </style>
</head>
<body>
  <div class="form-box">
    <h2>✏️ Jańalıqlardı tuzetiw</h2>
    <form method="POST" enctype="multipart/form-data">
      <label>Atama:</label>
      <input type="text" name="title" value="<?= htmlspecialchars($news['title']) ?>" required>

      <label>Matn:</label>
      <textarea name="content" required><?= htmlspecialchars($news['content']) ?></textarea>

      <label>Kategoriya:</label>
      <select name="category" required>
        <option value="Texnologiya" <?= $news['category'] == 'Texnologiya' ? 'selected' : '' ?>>Texnologiya</option>
        <option value="Sport" <?= $news['category'] == 'Sport' ? 'selected' : '' ?>>Sport</option>
        <option value="Siyosat" <?= $news['category'] == 'Siyosat' ? 'selected' : '' ?>>Siyasat</option>
      <option value="enaqirgi" <?= $news['category'] == 'Eń aqırǵı' ? 'selected' : '' ?>>Eń sońǵı</option>
      </select>

      <label>Taza suwret (qálewińiz):</label>
      <input type="file" name="image" accept="image/*">

      <?php if ($news['image']): ?>
        <p>📷 Házirgi suwreti:</p>
        <img src="uploads/<?= htmlspecialchars($news['image']) ?>" alt="Jańalıq suwreti">
      <?php endif; ?>

      <button type="submit" class="btn">💾 Saqlaw</button>
    </form>
  </div>
</body>
</html>
