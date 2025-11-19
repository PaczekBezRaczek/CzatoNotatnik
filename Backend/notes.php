<?php
require_once "db.php";

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $user_id = intval($_GET["user_id"] ?? 0);
    $stmt = $pdo->prepare("SELECT content FROM notes WHERE user_id = ? LIMIT 1");
    $stmt->execute([$user_id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode(["content" => $row["content"] ?? ""]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    $user_id = intval($data["user_id"] ?? 0);
    $content = $data["content"] ?? "";

    if ($user_id === 0) {
        echo json_encode(["error" => "Brak user_id"]);
        exit;
    }

    // To jest klucz: INSERT ... ON DUPLICATE KEY UPDATE
    // Dzięki UNIQUE na user_id – zawsze nadpisze istniejącą notatkę
    $stmt = $pdo->prepare("
        INSERT INTO notes (user_id, content, updated_at) 
        VALUES (?, ?, NOW()) 
        ON DUPLICATE KEY UPDATE 
            content = VALUES(content), 
            updated_at = NOW()
    ");
    $stmt->execute([$user_id, $content]);

    echo json_encode(["success" => true]);
    exit;
}
?>