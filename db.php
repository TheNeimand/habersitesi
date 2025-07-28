<?php
// Veritabanı Bağlantı Bilgileri
define('DB_HOST', 'localhost');
define('DB_USER', 'u271340643_root');
define('DB_PASS', 'B>BC#85h');
define('DB_NAME', 'u271340643_altinoran');

// Veritabanı bağlantısı
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Bağlantı kontrolü
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Karakter seti
$conn->set_charset("utf8mb4");
?>
