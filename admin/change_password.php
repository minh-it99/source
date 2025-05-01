<?php
session_start();

// Kiểm tra đăng nhập
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

// Đọc dữ liệu từ POST request
$data = json_decode(file_get_contents('php://input'), true);
$currentPassword = $data['currentPassword'] ?? '';
$newPassword = $data['newPassword'] ?? '';

// Đọc file auth.json
$authFile = file_get_contents('auth.json');
$authData = json_decode($authFile, true);

// Kiểm tra mật khẩu hiện tại
if ($currentPassword !== $authData['password']) {
    echo json_encode(['success' => false, 'message' => 'Mật khẩu hiện tại không đúng']);
    exit;
}

// Cập nhật mật khẩu mới
$authData['password'] = $newPassword;
$newAuthFile = json_encode($authData, JSON_PRETTY_PRINT);

// Lưu vào file
if (file_put_contents('auth.json', $newAuthFile)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Không thể lưu mật khẩu mới']);
}
?> 