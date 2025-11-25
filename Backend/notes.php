<?php
require_once "db.php";
header('Content-Type: application/json; charset=utf-8');

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
<<<<<<< HEAD
        http_response_code(400);
=======
>>>>>>> 2d453ad9231ff0a33ac7c66c8a2d06702ed119eb
        echo json_encode(["error" => "Brak user_id"]);
        exit;
    }

<<<<<<< HEAD
    try {
        // Próbujemy INSERT – jeśli duplikat, to UPDATE
        $stmt = $pdo->prepare("
            INSERT INTO notes (user_id, content, updated_at) 
            VALUES (?, ?, NOW()) 
            ON DUPLICATE KEY UPDATE 
                content = VALUES(content),
                updated_at = NOW()
        ");
        $stmt->execute([$user_id, $content]);
    } catch (PDOException $e) {
        // Jeśli błąd duplikatu (kod 23000) – robimy UPDATE ręcznie
        if ($e->getCode() == 23000) {
            $stmt = $pdo->prepare("UPDATE notes SET content = ?, updated_at = NOW() WHERE user_id = ?");
            $stmt->execute([$content, $user_id]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Błąd bazy: " . $e->getMessage()]);
            exit;
        }
    }
=======
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
>>>>>>> 2d453ad9231ff0a33ac7c66c8a2d06702ed119eb

    echo json_encode(["success" => true]);
    exit;
}
?>