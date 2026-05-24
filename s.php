<?php
$conn = new mysqli("localhost", "root", "", "icfl_db");
if ($conn->connect_error) { die("❌ Connection failed: " . $conn->connect_error); }
$search_result = null;

if(isset($_POST['search_btn'])) {
    $search_val = $conn->real_escape_string($_POST['search_val']);
    $search_type = $_POST['search_type'] ?? 'player';
    if ($search_type === 'team') {
        // Search by team name
        $query = "SELECT * FROM team WHERE team_name = '$search_val'";
    } else {
        // Default: search player by ID
        $query = "SELECT * FROM player WHERE id = '$search_val'";
    }
    $search_result = $conn->query($query);
}
?>

<!doctype html>
<html>
<head>
    <title>Search - ICFL System</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <header class="site-header">
        <h1>ICFL Management System</h1>
        <nav class="header-nav">
            <a href="cover.html" class="btn">Home</a>
            <a href="team_register.php" class="btn">Register</a>
            <a href="i.php" class="btn">Insert</a>
            <a href="s.php" class="btn">Search</a>
            <a href="r.php" class="btn">Report</a>
        </nav>
    </header>

    <main class="content">
        <h2 class="page-title">Search Records</h2>
        <form method="POST" action="s.php" class="search-form">
            <input type="text" name="search_val" placeholder="Enter ID or Team Name" required>
            <select name="search_type">
                <option value="player">Player</option>
                <option value="team">Team</option>
            </select>
            <input type="submit" name="search_btn" value="Search">
        </form>

        <?php
        if (isset($_POST['search_btn'])) {
            if ($search_result && $search_result->num_rows > 0) {
                echo "<div class='table-container'>";
                if ($_POST['search_type'] === 'team') {
                    echo "<table class='data-table'>";
                    echo "<tr><th>Team Name</th><th>Goal Score</th><th>Match Played</th><th>Wins</th><th>Losses</th></tr>";
                    while ($row = $search_result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['team_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['goal_score']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['match_played']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['win_match']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['loss_match']) . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<table class='data-table'>";
                    echo "<tr><th>ID</th><th>Name</th></tr>";
                    while ($row = $search_result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                }
                echo "</div>";
            }
            // No warning messages for empty results or errors.
        }
        ?>
    </main>

    <footer>
        &copy; 2026 ICFL Database Management Project. Developed by <strong>Rashed</strong>, ID: <strong>24203257</strong>
    </footer>
</body>
</html>