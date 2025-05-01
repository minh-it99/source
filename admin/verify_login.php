<?php
session_start();

// Đọc file auth.json
$authFile = file_get_contents('auth.json');
$authData = json_decode($authFile, true);

// Nhận dữ liệu từ POST request
$data = json_decode(file_get_contents('php://input'), true);
$username = $data['username'] ?? '';
$password = $data['password'] ?? '';

// Kiểm tra thông tin đăng nhập
if ($username === $authData['username'] && $password === $authData['password']) {
    $_SESSION['admin_logged_in'] = true;
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?> 