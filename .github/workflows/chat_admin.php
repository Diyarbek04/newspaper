<?php 
session_start();
include 'db.php';

if (!isset($_SESSION['user']) || $_SESSION['is_admin'] != 1) {
    header("Location: login.php");
    exit;
}

// Xabar yuborish
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $msg = mysqli_real_escape_string($conn, $_POST['message']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    if (!empty($msg)) {
        mysqli_query($conn, "INSERT INTO messages (username, message, sender) VALUES ('$username', '$msg', 'admin')");
    }
}

// Xabarlarni olish
$messages = mysqli_query($conn, "SELECT * FROM messages ORDER BY created_at ASC");
?>

<!DOCTYPE html>
<html lang="uz">
<head>
  <meta charset="UTF-8">
  <title>Admin Chat</title>
  <style>
    * {
      box-sizing: border-box;
      transition: all 0.3s ease;
    }

    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(120deg, #e1f5fe, #f1f8e9);
      padding: 40px;
    }

    .chat-box {
      max-width: 800px;
      margin: auto;
      background: #fff;
      border-radius: 16px;
      padding: 30px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      animation: fadeIn 0.6s ease;
    }

    .chat-box h2 {
      margin: 0 0 25px;
      color: #1976D2;
      text-align: center;
    }

    .chat-content {
      max-height: 450px;
      overflow-y: auto;
      margin-bottom: 20px;
      padding-right: 10px;
    }

    .message {
      margin-bottom: 18px;
      padding: 12px 16px;
      border-radius: 10px;
      max-width: 80%;
      position: relative;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
      animation: slideIn 0.3s ease;
    }

    .user {
      background: #e0f7fa;
      margin-right: auto;
      border-left: 5px solid #03a9f4;
    }

    .admin {
      background: #dcedc8;
      margin-left: auto;
      border-right: 5px solid #4caf50;
      text-align: right;
    }

    .meta {
      font-size: 13px;
      color: #555;
      margin-bottom: 6px;
    }

    form {
      display: flex;
      gap: 10px;
      flex-wrap: wrap;
      align-items: center;
    }

    input[type="text"],
    select {
      padding: 12px;
      font-size: 14px;
      border-radius: 8px;
      border: 1px solid #ccc;
      flex: 1;
      outline: none;
      transition: border 0.3s;
    }

    input[type="text"]:focus,
    select:focus {
      border-color: #2196F3;
    }

    button {
      padding: 12px 20px;
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
      transform: translateY(-1px);
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: scale(0.96); }
      to { opacity: 1; transform: scale(1); }
    }

    @keyframes slideIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>
  <div class="chat-box">
    <h2>💬 Paydalanıwshı menen sóylesiw</h2>

    <div class="chat-content">
      <?php while ($msg = mysqli_fetch_assoc($messages)): ?>
        <div class="message <?= $msg['sender'] ?>">
          <div class="meta">
            <?= htmlspecialchars($msg['username']) ?> | <?= $msg['created_at'] ?>
          </div>
          <div><?= htmlspecialchars($msg['message']) ?></div>
        </div>
      <?php endwhile; ?>
    </div>

    <form method="POST">
      <select name="username" required>
        <option value="" disabled selected>Paydalanıwshını tańlań</option>
        <?php
        $users = mysqli_query($conn, "SELECT DISTINCT username FROM messages WHERE sender='user'");
        while ($u = mysqli_fetch_assoc($users)) {
          echo "<option value='".htmlspecialchars($u['username'])."'>".htmlspecialchars($u['username'])."</option>";
        }
        ?>
      </select>
      <input type="text" name="message" placeholder="Jawap jazıń..." required>
      <button type="submit">📨 jiberiw</button>
    </form>
  </div>
</body>
</html>
