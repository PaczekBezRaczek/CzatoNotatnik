<?php
require_once "db.php";

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$method = $_SERVER["REQUEST_METHOD"];

// Prosty router
switch (true) {
    case str_contains($path, "/messages"):
        if ($method === "GET") {
            echo json_encode([
                ["id"=>1, "name"=>"Jan", "text"=>"Cześć!", "created_at"=>"2025-11-05 12:00:00"],
                ["id"=>2, "name"=>"Anna", "text"=>"Witam!", "created_at"=>"2025-11-05 12:01:00"]
            ]);
        } elseif ($method === "POST") {
            $data = json_decode(file_get_contents("php://input"), true);
            // tutaj normalnie zapis do bazy
            echo json_encode(["status"=>"ok", "message"=>$data]);
        }
        break;

    case str_contains($path, "/board"):
        if ($method === "GET") {
            echo json_encode(["content"=>"Tu jest treść tablicy nauczyciela"]);
        } elseif ($method === "POST") {
            $data = json_decode(file_get_contents("php://input"), true);
            echo json_encode(["status"=>"ok", "board_saved"=>$data]);
        }
        break;

    case str_contains($path, "/notes"):
        if ($method === "GET") {
            echo json_encode(["content"=>"Twoje prywatne notatki"]);
        } elseif ($method === "POST") {
            $data = json_decode(file_get_contents("php://input"), true);
            echo json_encode(["status"=>"ok", "notes_saved"=>$data]);
        }
        break;

    default:
        echo json_encode(["error" => "Unknown endpoint"]);
}
?>


