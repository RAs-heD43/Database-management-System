<?php
// -------------------------------------------------
// Updated Insert page – works with the "icfl_db" DB
// -------------------------------------------------
$host = "localhost";
$user = "root";
$pass = "";
$db   = "icfl_db"; // <-- make sure this matches the DB you created

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

$showMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ---------- PLAYER INSERT ----------
    if (isset($_POST['player_submit']) &&
        !empty($_POST['id']) &&
        !empty($_POST['name']) &&
        !empty($_POST['blood_group']) &&
        !empty($_POST['position']) &&
        !empty($_POST['play_for'])) {

        $p_id   = $conn->real_escape_string($_POST['id']);
        $p_name = $conn->real_escape_string($_POST['name']);
        $p_blood_group = $conn->real_escape_string($_POST['blood_group']);
        $p_position = $conn->real_escape_string($_POST['position']);
        $p_play_for = $conn->real_escape_string($_POST['play_for']);

        $sql = "INSERT INTO player (id, name, blood_group, position, play_for)\n                VALUES ('$p_id', '$p_name', '$p_blood_group', '$p_position', '$p_play_for')";
        if ($conn->query($sql) === TRUE) {
            $showMessage = "✅ Player added successfully!";
        } else {
            $showMessage = "❌ Error inserting player: " . $conn->error;
        }
    }

    // ---------- TEAM INSERT ----------
    if (isset($_POST['team_submit']) &&
        !empty($_POST['team_name']) &&
        !empty($_POST['goal_score']) &&
        isset($_POST['match_played']) &&
        isset($_POST['win_match']) &&
        isset($_POST['loss_match'])) {

        $t_name  = $conn->real_escape_string($_POST['team_name']);
        $t_score = $conn->real_escape_string($_POST['goal_score']);
        $t_match_played = $conn->real_escape_string($_POST['match_played']);
        $t_win_match = $conn->real_escape_string($_POST['win_match']);
        $t_loss_match = $conn->real_escape_string($_POST['loss_match']);

        $sql = "INSERT INTO team (team_name, goal_score, match_played, win_match, loss_match)\n                VALUES ('$t_name', $t_score, $t_match_played, $t_win_match, $t_loss_match)";
        if ($conn->query($sql) === TRUE) {
            $showMessage = "✅ Team added successfully!";
        } else {
            $showMessage = "❌ Error inserting team: " . $conn->error;
        }
    }
}
?>
<!doctype html>
<html>
<head>
    <title>Insert - ICFL System</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        .msg {
            max-width: 420px;
            margin: 1em auto;
            padding: 0.8em 1em;
            border-left: 5px solid #ccc;
            font-weight: bold;
        }
        .msg.success {
            background: #e7f5e6;
            border-left-color: #28a745;
            color: #1e7e34;
        }
        .msg.error {
            background: #fbe9e7;
            border-left-color: #e53935;
            color: #c62828;
        }
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
        <h2 class="page-title">Add New Records</h2>

        <?php if (!empty($showMessage)): ?>
            <div class="msg <?= strpos($showMessage,'✅')!==false ? 'success' : 'error' ?>">
                <?= $showMessage ?>
            </div>
        <?php endif; ?>

        <!-- Player Form -->
        <div class="form-container">
            <form method="POST" action="i.php">
                <h3>Player Details</h3>
                <table border="0">
                    <tr>
                        <td>Player ID:</td>
                        <td><input type="text" name="id" placeholder="Enter ID" required></td>
                    </tr>
                    <tr>
                        <td>Player Name:</td>
                        <td><input type="text" name="name" placeholder="Enter Name" required></td>
                    </tr>
                    <tr>
                        <td>Blood Group:</td>
                        <td><input type="text" name="blood_group" placeholder="Enter Blood Group" required></td>
                    </tr>
                    <tr>
                        <td>Playing Position:</td>
                        <td><input type="text" name="position" placeholder="Enter Position" required></td>
                    </tr>
                    <tr>
                        <td>Play For Team:</td>
                        <td><input type="text" name="play_for" placeholder="Enter Team Name" required></td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="submit" name="player_submit" value="Insert Player"></td>
                    </tr>
                </table>
            </form>
        </div>

        <!-- Team Form -->
        <div class="form-container">
            <form method="POST" action="i.php">
                <h3>Team Details</h3>
                <table border="0">
                    <tr>
                        <td>Team Name:</td>
                        <td><input type="text" name="team_name" placeholder="Enter Team Name" required></td>
                    </tr>
                    <tr>
                        <td>Goal Score:</td>
                        <td><input type="number" name="goal_score" placeholder="Enter Goal Score" required></td>
                    </tr>
                    <tr>
                        <td>Match Played:</td>
                        <td><input type="number" name="match_played" placeholder="Enter matches played" required></td>
                    </tr>
                    <tr>
                        <td>Win Match:</td>
                        <td><input type="number" name="win_match" placeholder="Enter wins" required></td>
                    </tr>
                    <tr>
                        <td>Loss Match:</td>
                        <td><input type="number" name="loss_match" placeholder="Enter losses" required></td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="submit" name="team_submit" value="Insert Team"></td>
                    </tr>
                </table>
            </form>
        </div>
    </main>

    <footer>
        &copy; 2026 ICFL Database Management Project. Developed by <strong>Rashed</strong>, ID: <strong>24203257</strong>
    </footer>
</body>
</html>