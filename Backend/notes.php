<?php
require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if (!isset($_GET["user_id"])) {
        http_response_code(400);
        echo json_encode(["error" => "Missing user_id"]);
        exit;
    }
    $stmt = $pdo->prepare("SELECT content, updated_at FROM notes WHERE user_id = ?");
    $stmt->execute([$_GET["user_id"]]);
    echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
}

elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    if (!isset($data["user_id"], $data["content"])) {
        http_response_code(400);
        echo json_encode(["error" => "Missing fields"]);
        exit;
    }

    // Zapis (UPDATE lub INSERT)
    $stmt = $pdo->prepare("INSERT INTO notes (user_id, content, updated_at)
                           VALUES (?, ?, NOW())
                           ON DUPLICATE KEY UPDATE content = VALUES(content), updated_at = NOW()");
    $stmt->execute([$data["user_id"], $data["content"]]);
    echo json_encode(["success" => true]);
}
?>
