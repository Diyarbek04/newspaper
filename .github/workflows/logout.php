<?php
session_start();
session_unset();  // Barcha session o'zgaruvchilarini tozalaydi
session_destroy(); // Sessionni butunlay yakunlaydi
header("Location: index.php"); // Bosh sahifaga yo'naltiradi
exit;
?>
