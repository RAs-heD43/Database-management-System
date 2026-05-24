<?php
// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$db   = "icfl_db";
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

// Ensure registration table exists
$tableSql = "CREATE TABLE IF NOT EXISTS team_registration (
    id INT AUTO_INCREMENT PRIMARY KEY,
    team_name VARCHAR(255) NOT NULL,
    team_id VARCHAR(255) NOT NULL,
    team_owner VARCHAR(255) NOT NULL,
    team_fair_prize VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$conn->query($tableSql);

// Handle form submission
$showMessage = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $team_name = $conn->real_escape_string($_POST['team_name']);
    $team_id   = $conn->real_escape_string($_POST['team_id']);
    $team_owner= $conn->real_escape_string($_POST['team_owner']);
    $team_fair = $conn->real_escape_string($_POST['team_fair_prize']);

    $sql = "INSERT INTO team_registration (team_name, team_id, team_owner, team_fair_prize)
            VALUES ('$team_name', '$team_id', '$team_owner', '$team_fair')";

    if ($conn->query($sql) === TRUE) {
        $showMessage = "✅ Team registration added successfully!";
    } else {
        $showMessage = "❌ Error: " . $conn->error;
    }
}
?>
<!doctype html>
<html>
<head>
    <title>Register Team - ICFL System</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        .page-title { font-size: 1.8em; margin-bottom: 30px; }
        .form-container { margin: 30px auto; max-width: 600px; }
        .msg { max-width: 420px; margin: 1em auto; padding: 0.8em 1em; border-left: 5px solid #ccc; font-weight: bold; }
        .msg.success { background: #e7f5e6; border-left-color: #28a745; color: #1e7e34; }
        .msg.error { background: #fbe9e7; border-left-color: #e53935; color: #c62828; }
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
        <h2 class="page-title">Team Registration</h2>

        <?php if (!empty($showMessage)): ?>
            <div class="msg <?= strpos($showMessage,'✅')!==false ? 'success' : 'error' ?>">
                <?= $showMessage ?>
            </div>
        <?php endif; ?>

        <div class="form-container">
            <form method="POST" action="team_register.php">
                <table border="0">
                    <tr>
                        <td>Team Name:</td>
                        <td><input type="text" name="team_name" placeholder="Enter team name" required></td>
                    </tr>
                    <tr>
                        <td>Team ID:</td>
                        <td><input type="text" name="team_id" placeholder="Enter team id" required></td>
                    </tr>
                    <tr>
                        <td>Team Owner:</td>
                        <td><input type="text" name="team_owner" placeholder="Enter team owner" required></td>
                    </tr>
                    <tr>
                        <td>Fair Prize:</td>
                        <td><input type="text" name="team_fair_prize" placeholder="Enter team fair prize" required></td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="submit" value="Register Team" style="margin-top:10px;"></td>
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