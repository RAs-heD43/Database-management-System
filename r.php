<?php
$conn = new mysqli("localhost", "root", "", "icfl_db");
if ($conn->connect_error) { die("❌ Connection failed: " . $conn->connect_error); }

// Player count for summary
$count_query = "SELECT COUNT(id) as total FROM player";
$count_result = $conn->query($count_query);
$data = $count_result->fetch_assoc();
$total_players = $data['total'];

// Team standings (aggregate scores for same team name)
$team_query = "SELECT team_name, SUM(goal_score) as total_goal_score, match_played, win_match, loss_match FROM team GROUP BY team_name ORDER BY total_goal_score DESC";
$team_result = $conn->query($team_query);
?>

<!doctype html>
<html>
<head>
    <title>Report - ICFL System</title>
    <link rel="stylesheet" type="text/css" href="style.css">
<style>
.side-by-side { display:flex; gap:20px; }
.side-by-side > .players,
.side-by-side > .teams { flex:1; }
</style>
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
        <h2 class="page-title">System Report</h2>

        <div class="report-card">
            <h3>League Summary</h3>
            <p>Total Registered Players: <strong><?php echo $total_players; ?></strong></p>
        </div>
        <h3 class="page-title" style="font-size: 1.5em;">Registered Players</h3>
        <div class="table-container">
            <table class="data-table" id="players-table">
                <tr><th>Name</th><th>Action</th></tr>
                <?php
                $players_query = "SELECT * FROM player ORDER BY name";
                $players_result = $conn->query($players_query);
                while ($p = $players_result->fetch_assoc()) {
                    $pid = $p['id'];
                    $name = htmlspecialchars($p['name']);
                    $blood = htmlspecialchars($p['blood_group']);
                    $pos = htmlspecialchars($p['position']);
                    $team = htmlspecialchars($p['play_for']);
                    echo "<tr>";
                    echo "<td>$name</td>";
                    echo "<td><button class='detail-btn' onclick=\"toggleDetail('" . $pid . "')\">Details</button></td>";
                    echo "</tr>";
                    echo "<tr id='detail-$pid' style='display:none; background:#000; color:#fff;'>";
                    echo "<td colspan='2'>";
                    echo "<strong>Name:</strong> $name<br>";
                    echo "<strong>ID:</strong> $pid<br>";
                    echo "<strong>Blood Group:</strong> $blood<br>";
                    echo "<strong>Position:</strong> $pos<br>";
                    echo "<strong>Team:</strong> $team";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </div>
        <script>
        function toggleDetail(id) {
            var row = document.getElementById('detail-' + id);
            if (row.style.display === 'none') {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
        </script>

        <h3 class="page-title" style="font-size: 1.5em;">Team Standings</h3>
        <div class="table-container">
            <table class="data-table">
                <tr><th>Team Name</th><th>Total Goal Score</th></tr>
                <?php while($row = $team_result->fetch_assoc()) {
                    $teamId = md5($row['team_name']);
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['team_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['total_goal_score']) . " -<button class='detail-btn' onclick=\"toggleDetail('$teamId')\">Details</button></td>";
                    echo "</tr>";
                    echo "<tr id='detail-$teamId' style='display:none; background:#000; color:#fff;'>";
                    echo "<td colspan='2'>";
                    echo "<strong>Match Played:</strong> " . htmlspecialchars($row['match_played']) . "<br>";
                    echo "<strong>Wins:</strong> " . htmlspecialchars($row['win_match']) . "<br>";
                    echo "<strong>Losses:</strong> " . htmlspecialchars($row['loss_match']) . "<br><br>";
                    // Player sub‑list
                    $teamName = $row['team_name'];
                    $players = $conn->query("SELECT id, name, blood_group, position FROM player WHERE play_for = '" . $conn->real_escape_string($teamName) . "'");
                    if ($players && $players->num_rows > 0) {
                        echo "<strong>Players in " . htmlspecialchars($teamName) . ":</strong><br>";
                        echo "<table class='data-table' style='background:#222;color:#fff;margin-top:5px;'>";
                        echo "<tr><th>ID</th><th>Name</th><th>Blood Group</th><th>Position</th></tr>";
                        while ($pl = $players->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($pl['id']) . "</td>";
                            echo "<td>" . htmlspecialchars($pl['name']) . "</td>";
                            echo "<td>" . htmlspecialchars($pl['blood_group']) . "</td>";
                            echo "<td>" . htmlspecialchars($pl['position']) . "</td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                    } else {
                        echo "No players registered for this team.";
                    }
                    echo "</td>";
                    echo "</tr>";
                } ?>
            </table>
        </div>
        <br><br>
        <button class="print-btn" onclick="window.print()">Print Report</button>
    </main>

    <footer>
        &copy; 2026 ICFL Database Management Project. Developed by <strong>Rashed</strong>, ID: <strong>24203257</strong>
    </footer>
</body>
</html>