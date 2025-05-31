<?php
include "db.php";
session_start();

$id = (int)$_GET['id'];
$res = $conn->query("SELECT * FROM news WHERE id = $id");
$news = $res->fetch_assoc();

echo "<h3>" . htmlspecialchars($news['title']) . "</h3>";
echo "<img src='uploads/" . htmlspecialchars($news['image']) . "'>";
echo "<p>" . htmlspecialchars($news['content']) . "</p>";

// Izohlar ro'yxati
$comments = $conn->query("SELECT * FROM comments WHERE news_id = $id ORDER BY created_at DESC");
echo "<div class='comment-list'>";
while ($c = $comments->fetch_assoc()) {
    echo "<div class='comment-item'>";
    echo "<strong>" . htmlspecialchars($c['username']) . " (" . htmlspecialchars($c['email']) . ")</strong>";
    echo "<p>" . htmlspecialchars($c['comment']) . "</p>";
    echo "</div>";
}
echo "</div>";

if (isset($_SESSION['user'])) {
?>
  <form class="comment-box" method="POST" action="news.php">
    <input type="hidden" name="news_id" value="<?= $id ?>">
    <textarea name="comment" placeholder="Komen jazıw..." required></textarea>
    <button type="submit">Jiberiw</button>
  </form>
<?php
} else {
    echo "<p>Koment jazıw ushın <a href='login.php'>kirish</a> kerak.</p>";
}
?>
