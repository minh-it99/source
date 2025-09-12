<?php
// Simple server-side Telegram proxy to avoid CORS and hide bot token

header('Content-Type: application/json; charset=utf-8');

// Only allow POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => 'Method Not Allowed']);
    exit;
}

// Read token and default chat id from files
$root = __DIR__;
$tokenFile = $root . DIRECTORY_SEPARATOR . 'token.txt';
$chatFile = $root . DIRECTORY_SEPARATOR . 'chat-id.txt';

if (!file_exists($tokenFile)) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'Missing token.txt']);
    exit;
}

$token = trim(file_get_contents($tokenFile));
$defaultChatId = file_exists($chatFile) ? trim(file_get_contents($chatFile)) : '';

// Parse JSON body
$raw = file_get_contents('php://input');
$data = json_decode($raw, true);
if (!is_array($data)) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'Invalid JSON body']);
    exit;
}

$chatId = isset($data['chat_id']) && $data['chat_id'] !== '' ? $data['chat_id'] : $defaultChatId;
$text = isset($data['text']) ? (string)$data['text'] : '';
$parseMode = isset($data['parse_mode']) ? (string)$data['parse_mode'] : 'Markdown';

if ($text === '' || $chatId === '') {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'Missing text or chat_id']);
    exit;
}

$url = 'https://api.telegram.org/bot' . urlencode($token) . '/sendMessage';

$payload = [
    'chat_id' => $chatId,
    'text' => $text,
    'parse_mode' => $parseMode,
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 8);
curl_setopt($ch, CURLOPT_TIMEOUT, 15);

$response = curl_exec($ch);
$errno = curl_errno($ch);
$error = curl_error($ch);
curl_close($ch);

if ($errno) {
    http_response_code(502);
    echo json_encode(['ok' => false, 'error' => $error]);
    exit;
}

// Pass through Telegram response
http_response_code(200);
echo $response;
?>


