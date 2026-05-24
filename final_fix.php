<?php
// Final fix for player database structure
$host = "localhost";
$user = "root";
$pass = "";
$db = "icfl_db";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "=== Final Database Fix ===\n";

try {
    // Drop foreign key if exists
    $conn->query("ALTER TABLE player DROP FOREIGN KEY IF EXISTS fk_team");
    echo "✓ Dropped foreign key constraint (if existed)\n";

    // Modify play_for column to match team_name length
    $conn->query("ALTER TABLE player MODIFY COLUMN play_for VARCHAR(100) NOT NULL DEFAULT ''");
    echo "✓ Modified play_for column to VARCHAR(100)\n";

    // Ensure team_name is indexed for foreign key reference
    $conn->query("ALTER TABLE team ADD UNIQUE INDEX idx_team_name (team_name)");
    echo "✓ Added unique index on team.team_name\n";

    // Add foreign key constraint
    $conn->query("ALTER TABLE player
                   ADD CONSTRAINT fk_team
                   FOREIGN KEY (play_for) REFERENCES team(team_name)
                   ON UPDATE CASCADE
                   ON DELETE RESTRICT");
    echo "✓ Added foreign key constraint\n";

    echo "\n=== Database Fix Complete! ===\n";
    echo "Note: Ensure team names in team table match expected values for play_for.\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

$conn->close();
?>