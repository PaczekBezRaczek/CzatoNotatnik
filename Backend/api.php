<?php
header('Content-Type: application/json');

$action = $_GET['action'] ?? '';

$host = '10.103.8.113';
$dbname = 'lesson_app';
$user = 'Dominka';
$pass = '1234';

$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

$data = json_decode(file_get_contents('php://input'), true);

if ($action === 'login') {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE login=? AND password=?");
    $stmt->execute([$data['name'], $data['pass']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) echo json_encode(['success' => true]);
    else echo json_encode(['success' => false, 'message' => 'Nieprawidłowy login']);
}

if ($action === 'sendMessage') {
    $msg = $data['message'] ?? '';
    if ($msg) {
        $stmt = $pdo->prepare("INSERT INTO chat (message, created_at) VALUES (?, NOW())");
        $stmt->execute([$msg]);
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
}
