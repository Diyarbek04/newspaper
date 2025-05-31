<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user']) || $_SESSION['is_admin'] != 0) {
    header("Location: login.php");
    exit;
}

$username = mysqli_real_escape_string($conn, $_SESSION['username']);

// Yangi xabar yuborish
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    if (!empty($message)) {
        mysqli_query($conn, "INSERT INTO messages (username, message, sender) VALUES ('$username', '$message', 'user')");
    }
}

// Xabarlar
$messages = mysqli_query($conn, "SELECT * FROM messages WHERE username = '$username' ORDER BY created_at ASC");
?>

<!DOCTYPE html>
<html lang="uz">
<head>
  <meta charset="UTF-8">
  <title>Admin bilan suhbat</title>
  <style>
    * {
      box-sizing: border-box;
      transition: all 0.3s ease;
    }

    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      background: linear-gradient(to right, #e0f7fa, #e1f5fe);
      padding: 40px;
    }

    .chat-box {
      max-width: 750px;
      margin: auto;
      background: #ffffff;
      border-radius: 14px;
      padding: 30px;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
      overflow: hidden;
    }

    .chat-box h2 {
      margin-top: 0;
      color: #0077c2;
      text-align: center;
      margin-bottom: 25px;
    }

    .chat-content {
      max-height: 450px;
      overflow-y: auto;
      padding-right: 10px;
      margin-bottom: 20px;
    }

    .message {
      margin-bottom: 15px;
      padding: 12px 16px;
      border-radius: 12px;
      max-width: 85%;
      line-height: 1.5;
      position: relative;
      animation: fadeIn 0.4s ease;
    }

    .user {
      background: #e1f5fe;
      text-align: left;
      margin-right: auto;
      border-left: 4px solid #03a9f4;
    }

    .admin {
      background: #c8e6c9;
      text-align: right;
      margin-left: auto;
      border-right: 4px solid #4caf50;
    }

    .meta {
      font-size: 12px;
      color: #555;
      margin-bottom: 6px;
    }

    form {
      display: flex;
      gap: 10px;
    }

    input[type="text"] {
      flex: 1;
      padding: 12px;
      font-size: 15px;
      border: 1px solid #ccc;
      border-radius: 8px;
      outline: none;
    }

    button {
      padding: 12px 20px;
      font-size: 15px;
      background: #2196F3;
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-weight: 500;
      box-shadow: 0 4px 10px rgba(33, 150, 243, 0.3);
    }

    button:hover {
      background: #1976D2;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>
  <div class="chat-box">
    <h2>💬 Admin menen sóylesiw</h2>

    <div class="chat-content">
      <?php while ($msg = mysqli_fetch_assoc($messages)): ?>
        <div class="message <?= $msg['sender'] ?>">
          <div class="meta"><?= $msg['sender'] === 'admin' ? '👨‍💼 Admin' : '👤 Siz' ?> | <?= $msg['created_at'] ?></div>
          <div><?= htmlspecialchars($msg['message']) ?></div>
        </div>
      <?php endwhile; ?>
    </div>

    <form method="POST">
      <input type="text" name="message" placeholder="Xabar yozing..." required>
      <button type="submit">📨 jiberiw</button>
    </form>
  </div>
</body>
</html>
