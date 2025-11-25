<?php
require_once "db.php";
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $last_id = intval($_GET["last_id"] ?? 0);

    $stmt = $pdo->prepare("
        SELECT m.id, m.text, u.name
        FROM messages m
        JOIN users u ON m.user_id = u.id
        WHERE m.id > ?
        ORDER BY m.id ASC
    ");
    $stmt->execute([$last_id]);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
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

    // Dodajemy nową wiadomość
    $stmt = $pdo->prepare("INSERT INTO messages (user_id, text) VALUES (?, ?)");
    $stmt->execute([$user_id, $text]);

    // USUWAMY WIADOMOŚCI STARSZE NIŻ 1 GODZINA
    $pdo->query("DELETE FROM messages WHERE created_at < NOW() - INTERVAL 1 HOUR");

    echo json_encode(["success" => true]);
    exit;
}
?>