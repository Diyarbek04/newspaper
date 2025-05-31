<?php session_start(); ?>
<style>
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

  @media screen and (max-width: 600px) {
    .navbar {
      flex-direction: column;
      align-items: flex-start;
    }

    .navbar .nav-links {
      margin-top: 10px;
    }

    .navbar .nav-links a {
      display: block;
      margin: 10px 0;
    }
  }
</style>

<div class="navbar">
  <a href="index.php" class="logo">Gazeta.uz</a>

  <div class="nav-links">
    <a href="index.php">Bosh sahifa</a>
    <a href="news.php">Barcha yangiliklar</a>
    <a href="chat.php">Admin bilan bog‘lanish</a>

    <?php if (isset($_SESSION['user'])): ?>
      <span style="margin-left: 20px;">👤 <?= htmlspecialchars($_SESSION['username']) ?></span>
      <a href="logout.php">Chiqish</a>
    <?php else: ?>
      <a href="register.php">Ro‘yxatdan o‘tish</a>
      <a href="login.php">Kirish</a>
    <?php endif; ?>
  </div>
</div>
