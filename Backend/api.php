<?php
// api.php - prosty router (opcjonalny)
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(204); exit; }

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'login': require __DIR__ . '/auth.php'; break;
    case 'getMessages':
    case 'sendMessage': require __DIR__ . '/message.php'; break;
    case 'getBoard':
    case 'saveBoard': require __DIR__ . '/board.php'; break;
    case 'getNotes':
    case 'saveNotes': require __DIR__ . '/notes.php'; break;
    default:
        http_response_code(404);
        echo json_encode(['error' => 'Invalid action']);
        break;
}
