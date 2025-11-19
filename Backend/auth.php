<?php
// Backend/auth.php – wersja, która działa i z starymi hasłami (czystym tekstem) i nowymi
require_once "db.php";

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER["REQUEST_METHOD"] !== "POST") exit;

$data = json_decode(file_get_contents("php://input"), true);
$name = trim($data["name"] ?? "");
$password = $data["password"] ?? "";

if ($name === "" || $password === "") {
    echo json_encode(["error" => "Podaj nazwę i hasło"]);
    exit;
}

$stmt = $pdo->prepare("SELECT id, name, role, password FROM users WHERE name = ? LIMIT 1");
$stmt->execute([$name]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    $hashedInDb = $user["password"];

    // Jeśli hasło w bazie jest jeszcze czystym tekstem (stare dane)
    if ($hashedInDb && $hashedInDb === $password) {
        // Poprawne hasło w starym formacie → logujemy i aktualizujemy na hash
        $newHash = password_hash($password, PASSWORD_DEFAULT);
        $pdo->prepare("UPDATE users SET password = ? WHERE id = ?")->execute([$newHash, $user["id"]]);

        echo json_encode([
            "success" => true,
            "user" => ["id" => $user["id"], "name" => $user["name"], "role" => $user["role"]]
        ]);
        exit;
    }

    // Normalne sprawdzanie zahashowanego hasła
    if ($hashedInDb && password_verify($password, $hashedInDb)) {
        echo json_encode([
            "success" => true,
            "user" => ["id" => $user["id"], "name" => $user["name"], "role" => $user["role"]]
        ]);
        exit;
    }

    // Złe hasło
    echo json_encode(["error" => "Złe hasło"]);
} else {
    // Nowy użytkownik – zawsze uczeń (oprócz Jana)
    $role = (strtolower($name) === "jan") ? "teacher" : "student";
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (name, role, password) VALUES (?, ?, ?)");
    $stmt->execute([$name, $role, $hash]);
    $id = $pdo->lastInsertId();

    echo json_encode([
        "success" => true,
        "user" => ["id" => $id, "name" => $name, "role" => $role]
    ]);
}
?>