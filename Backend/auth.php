<?php
require_once "db.php"; // $pdo

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['name']) || !isset($data['token'])) {
        echo json_encode(["error" => "Nie podano nazwy użytkownika lub tokenu"]);
        exit;
    }

    $name = trim($data['name']);
    $token = $data['token'];

    // Sprawdzenie, czy użytkownik istnieje
    $stmt = $pdo->prepare("SELECT id, name, role, token FROM users WHERE name = ? LIMIT 1");
    $stmt->execute([$name]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Weryfikacja tokenu
        if (password_verify($token, $user['token'])) {
            // Zapis logowania
            $ip = $_SERVER['REMOTE_ADDR'];
            $logStmt = $pdo->prepare("INSERT INTO logins (user_id, ip_address) VALUES (?, ?)");
            $logStmt->execute([$user['id'], $ip]);

            echo json_encode(["success" => true, "user" => $user]);
        } else {
            echo json_encode(["error" => "Nieprawidłowy token"]);
        }
    } else {
        // Konto nie istnieje → tworzymy nowy user
        $hashedToken = password_hash($token, PASSWORD_DEFAULT);
        $insert = $pdo->prepare("INSERT INTO users (name, role, token) VALUES (?, 'student', ?)");
        $insert->execute([$name, $hashedToken]);
        $user_id = $pdo->lastInsertId();

        // Zapis logowania
        $ip = $_SERVER['REMOTE_ADDR'];
        $logStmt = $pdo->prepare("INSERT INTO logins (user_id, ip_address) VALUES (?, ?)");
        $logStmt->execute([$user_id, $ip]);

        echo json_encode([
            "success" => true,
            "user" => [
                "id" => $user_id,
                "name" => $name,
                "role" => "student",
                "token" => $token
            ]
        ]);
    }
}
?>

