<?php
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $stmt = $pdo->query("SELECT content, updated_at FROM board ORDER BY id DESC LIMIT 1");
    echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
}

elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    if (!isset($data["content"])) {
        http_response_code(400);
        echo json_encode(["error" => "Missing content"]);
        exit;
    }
    $stmt = $pdo->prepare("INSERT INTO board (content, updated_at) VALUES (?, NOW())");
    $stmt->execute([$data["content"]]);
    echo json_encode(["success" => true]);
}
?>
