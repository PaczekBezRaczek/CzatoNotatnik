<?php
$mysqli = new mysqli("10.103.8.113", "Dominika", "1234", "lesson_app");
if ($mysqli->connect_errno) {
    http_response_code(500);
    echo json_encode(["error" => "Błąd połączenia: " . $mysqli->connect_error]);
    exit;
}
$mysqli->set_charset("utf8mb4");
?>
