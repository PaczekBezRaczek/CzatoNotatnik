<?php
header('Content-Type: application/json; charset=utf-8');

$host = '10.103.8.113';
$dbname = 'lesson_app';
$user = 'Dominika';
$pass = '1234';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => "Brak połączenia z bazą szkolną"]);
    exit;
}
?>