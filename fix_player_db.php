<?php
// One-click fix for player database structure
$host = "localhost";
$user = "root";
$pass = "";
$db = "icfl_db";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "=== Fixing Player Database Structure ===\n";

try {
    // Drop foreign key if exists
    $conn->query("ALTER TABLE player DROP FOREIGN KEY IF EXISTS fk_team");
    echo "✓ Dropped foreign key constraint\n";

    // Add new columns with defaults (empty string)
    $conn->query("ALTER TABLE player ADD COLUMN blood_group VARCHAR(5) NOT NULL DEFAULT ''");
    echo "✓ Added blood_group column\n";

    $conn->query("ALTER TABLE player ADD COLUMN position VARCHAR(20) NOT NULL DEFAULT ''");
    echo "✓ Added position column\n";

    $conn->query("ALTER TABLE player ADD COLUMN play_for VARCHAR(50) NOT NULL DEFAULT ''");
    echo "✓ Added play_for column\n";

    // Add foreign key
    $conn->query("ALTER TABLE player ADD CONSTRAINT fk_team FOREIGN KEY (play_for) REFERENCES team(team_name) ON UPDATE CASCADE ON DELETE RESTRICT");
    echo "✓ Added foreign key constraint\n";

    echo "\n=== Database Fix Complete! ===\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

$conn->close();
?>