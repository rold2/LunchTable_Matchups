<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "lunchtable_matchups";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$player_id = $_GET['player_id'] ?? 0;

$sql = "SELECT PTS, AST, REB, STL, BLK, FG_PCT, FG3_PCT, FT_PCT 
        FROM career_stats 
        WHERE PLAYER_ID = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $player_id);
$stmt->execute();
$result = $stmt->get_result();

$stats = $result->fetch_assoc();

if (!$stats) {
    // Return default values if player not found
    $stats = [
        'PTS' => 0, 'AST' => 0, 'REB' => 0, 'STL' => 0, 'BLK' => 0,
        'FG_PCT' => 0, 'FG3_PCT' => 0, 'FT_PCT' => 0
    ];
}

echo json_encode($stats);

$stmt->close();
$conn->close();
?>