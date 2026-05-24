<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "icfl_db";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "=== Current Foreign Key Constraint ===\n";
$result = $conn->query("SHOW CREATE TABLE player");
if ($result) {
    $row = $result->fetch_assoc();
    if ($row) {
        echo $row['Create Table'] . "\n";
    }
}

$conn->close();
?>