<?php
require_once "db.php";

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $last_id = intval($_GET["last_id"] ?? 0);

    // Pobieramy tylko wiadomości nowsze niż last_id (polling)
    $stmt = $pdo->prepare("
        SELECT m.id, m.text, u.name
        FROM messages m
        JOIN users u ON m.user_id = u.id
        WHERE m.id > ?
        ORDER BY m.id ASC
    ");
    $stmt->execute([$last_id]);
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($messages);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    $user_id = intval($data["user_id"] ?? 0);
    $text = trim($data["text"] ?? "");

    if ($user_id === 0 || $text === "") {
        http_response_code(400);
        echo json_encode(["error" => "Brak danych"]);
        exit;
    }

    // 1. Dodajemy nową wiadomość
    $stmt = $pdo->prepare("INSERT INTO messages (user_id, text) VALUES (?, ?)");
    $stmt->execute([$user_id, $text]);
    $new_id = $pdo->lastInsertId();

    // 2. Zostawiamy TYLKO ostatnie 20 wiadomości (najstarsze znikają)
    $pdo->query("
        DELETE FROM messages 
        WHERE id NOT IN (
            SELECT id FROM (
                SELECT id 
                FROM messages 
                ORDER BY id DESC 
                LIMIT 20
            ) AS keep_these
        )
    ");

    echo json_encode(["success" => true, "id" => $new_id]);
    exit;
}
?>