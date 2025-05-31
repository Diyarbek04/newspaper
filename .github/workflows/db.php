<?php
$conn = new mysqli("localhost", "root", "root", "newspaper");
if ($conn->connect_error) {
    die("MySQL bilan ulanishda xatolik: " . $conn->connect_error);
}
?>
