<?php
$conn = new mysqli("localhost", "root", "", "icfl_db");
if ($conn->connect_error) { die("❌ Connection failed: " . $conn->connect_error); }
$query = "SELECT * FROM player";
$result = $conn->query($query);
?>

<!doctype html>
<html>
<head>
    <title>View - ICFL System</title>
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
        <h2 class="page-title">Player Records</h2>
        <div class="table-container">
            <table class="data-table">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                </tr>
                <?php
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </div>
    </main>

    <footer>
        &copy; 2026 ICFL Database Management Project. Developed by <strong>Rashed</strong>, ID: <strong>24203257</strong>
    </footer>
</body>
</html>