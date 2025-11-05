<?php
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $last_id = isset($_GET["last_id"]) ? intval($_GET["last_id"]) : 0;
    $stmt = $pdo->prepare("SELECT m.id, m.text, u.name, m.created_at 
                           FROM messages m 
                           JOIN users u ON m.user_id = u.id 
                           WHERE m.id > ? ORDER BY m.id ASC");
    $stmt->execute([$last_id]);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    if (!isset($data["user_id"], $data["text"])) {
        http_response_code(400);
        echo json_encode(["error" => "Missing fields"]);
        exit;
    }
    $stmt = $pdo->prepare("INSERT INTO messages (user_id, text, created_at) VALUES (?, ?, NOW())");
    $stmt->execute([$data["user_id"], $data["text"]]);
    echo json_encode(["success" => true, "id" => $pdo->lastInsertId()]);
}
?>
