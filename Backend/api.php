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
        require "messages.php";
        break;
    case str_contains($path, "/board"):
        require "board.php";
        break;
    case str_contains($path, "/notes"):
        require "notes.php";
        break;
    default:
        echo json_encode(["error" => "Unknown endpoint"]);
}
?>

