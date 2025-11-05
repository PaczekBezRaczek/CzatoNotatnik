<?php
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    $stmt = $pdo->prepare("SELECT id, name, role FROM users WHERE name = ? LIMIT 1");
    $stmt->execute([$data["name"]]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        echo json_encode(["success" => true, "user" => $user]);
    } else {
        echo json_encode(["error" => "User not found"]);
    }
}
?>
