<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user']) || $_SESSION['is_admin'] != 1) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);

    $imagePath = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageName = time() . "_" . basename($_FILES['image']['name']);
        $targetDir = "uploads/";
        $targetFile = $targetDir . $imageName;

        if (!is_dir($targetDir)) {
            mkdir($targetDir);
        }

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $imagePath = $imageName;
        }
    }

    $sql = "INSERT INTO news (title, content, image, category, created_at) 
            VALUES ('$title', '$content', '$imagePath', '$category', NOW())";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('✅ Jańalıq tabıslı qosıldı!'); window.location.href='admin-panel.php';</script>";
    } else {
        echo "<p style='color:red;'>❌ Qátelik: " . mysqli_error($conn) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="uz">
<head>
  <meta charset="UTF-8">
  <title>Jańalıq qosıw</title>
  <style>
    * {
      box-sizing: border-box;
      transition: all 0.3s ease;
    }

    body {
      margin: 0;
      padding: 40px;
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(120deg, #e1f5fe, #fce4ec);
    }

    .form-box {
      max-width: 700px;
      margin: auto;
      background: #fff;
      padding: 40px;
      border-radius: 16px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
      animation: fadeIn 0.6s ease;
    }

    h2 {
      text-align: center;
      color: #333;
      margin-bottom: 30px;
    }

    label {
      font-weight: bold;
      display: block;
      margin-top: 15px;
      margin-bottom: 5px;
      color: #444;
    }

    input[type="text"],
    textarea,
    select,
    input[type="file"] {
      width: 100%;
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 15px;
      outline: none;
    }

    input:focus,
    textarea:focus,
    select:focus {
      border-color: #2196F3;
      box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.1);
    }

    textarea {
      height: 150px;
      resize: vertical;
    }

    .btn {
      background: linear-gradient(45deg, #42a5f5, #1e88e5);
      color: white;
      padding: 14px 20px;
      margin-top: 30px;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      font-size: 16px;
      width: 100%;
      font-weight: 500;
      box-shadow: 0 6px 12px rgba(33,150,243,0.25);
      transition: transform 0.2s ease;
    }

    .btn:hover {
      transform: translateY(-2px);
      background: linear-gradient(45deg, #1e88e5, #1565c0);
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: scale(0.97); }
      to { opacity: 1; transform: scale(1); }
    }
  </style>
</head>
<body>
  <div class="form-box">
    <h2>➕ Jańalıq qosıw
    </h2>
    <form method="POST" enctype="multipart/form-data">
      <label>Atama:</label>
      <input type="text" name="title" required>

      <label>Text:</label>
      <textarea name="content" required></textarea>

      <label>Kategoriya:</label>
      <select name="category" required>
        <option value="">-- Tanlań --</option>
        <option value="Texnologiya">Texnologiya</option>
        <option value="Sport">Sport</option>
        <option value="Siyosat">Siyasat</option>
        <option value="enaqirgi">Eń sońǵı</option>
      </select>

      <label>Suwret:</label>
      <input type="file" name="image" accept="image/*">

      <button type="submit" class="btn">📤 Qosıw</button>
    </form>
  </div>
</body>
</html>
