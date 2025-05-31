<?php
session_start();
include 'db.php';

// Faqat admin kira oladi
if (!isset($_SESSION['user']) || $_SESSION['is_admin'] != 1) {
    header("Location: login.php");
    exit;
}

// O‘chirish
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM news WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: manage_news.php");
    exit;
}

$news = $conn->query("SELECT * FROM news ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <title>Jańalıqlardı basqarıw</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            background: #f4f4f4;
        }

        .navbar {
            background: #1f1f2e;
            color: #fff;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar a {
            color: #00d9ff;
            text-decoration: none;
            font-weight: bold;
        }

        .container {
            padding: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #1f1f2e;
            color: #fff;
        }

        tr:hover {
            background: #f1f1f1;
        }

        .btn {
            padding: 6px 12px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
        }

        .btn-edit {
            background: #00b894;
            color: #fff;
        }

        .btn-delete {
            background: #d63031;
            color: #fff;
        }

        .btn-add {
            display: inline-block;
            margin-bottom: 15px;
            background: #0984e3;
            color: #fff;
        }
    </style>
</head>
<body>

<div class="navbar">
    <div><strong>Admin Panel</strong></div>
    <div><a href="admin_dashboard.php">← Artqa</a></div>
</div>

<div class="container">
    <h2>Jańalıqlardı basqarıw</h2>

    <a class="btn btn-add" href="add_news.php">+ Jańalıqlar qosıw</a>

    <table>
        <thead>
            <tr>
                <th>Atama</th>
                <th>Suwret</th>
                <th>Sáne</th>
                <th>Ámeller</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $news->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['title']) ?></td>
                    <td><img src="uploads/<?= htmlspecialchars($row['image']) ?>" alt="Rasm" width="80"></td>
                    <td><?= htmlspecialchars($row['created_at']) ?></td>
                    <td>
                        <a class="btn btn-edit" href="edit_news.php?id=<?= $row['id'] ?>">Tuzetiw</a>
                        <a class="btn btn-delete" href="manage_news.php?delete=<?= $row['id'] ?>" onclick="return confirm('Usı jańalıqlardı óshiriwdi qáleysizbe?')">Óshiriw</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
