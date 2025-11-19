<?php
require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $stmt = $pdo->query("SELECT content FROM board WHERE id = 1");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode(["content" => $row["content"] ?? ""]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    $content = $data["content"] ?? "";

    // Zawsze edytujemy wiersz o id=1
    $stmt = $pdo->prepare("INSERT INTO board (id, content) VALUES (1, ?) 
                           ON DUPLICATE KEY UPDATE content = ?");
    $stmt->execute([$content, $content]);

    echo json_encode(["success" => true]);
    exit;
}
?>