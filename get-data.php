<?php
// Đọc token từ file token.txt
// get root directory
$rootDirectory = dirname(__FILE__);
$tokenFile = $rootDirectory . '/token.txt';
$chatIdFile = $rootDirectory . '/chat-id.txt';

if (file_exists($tokenFile) && file_exists($chatIdFile)) {
    $token = trim(file_get_contents($tokenFile)); // Đọc và loại bỏ khoảng trắng
    $chatId = trim(file_get_contents($chatIdFile));
} else {
    die("File token.txt hoặc chat-id.txt không tồn tại.");
}
?>
