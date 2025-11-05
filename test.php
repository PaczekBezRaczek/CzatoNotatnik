<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Połączenie z MySQL</title>
</head>
<body>
<?php
$mysqli = new mysqli("10.103.8.113", "Dominika", "1234", "lesson_app");

if ($mysqli->connect_errno) {
    die("Błąd połączenia: " . $mysqli->connect_error);
} else {
    echo "Połączenie działa!";
}
?>
</body>
</html>
