<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "lunchtable_matchups";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    echo json_encode(["error" => "Database connection failed: " . $conn->connect_error]);
    exit;
}

$search = isset($_GET['q']) ? $conn->real_escape_string($_GET['q']) : '';
if (strlen($search) < 1) {
    echo json_encode([]);
    exit;
}

// Return GP so we can calculate per-game averages
$sql = "
SELECT 
    fp.full_name AS PLAYER_NAME,
    cs.PLAYER_ID,
    cs.GP,
    cs.PTS,
    cs.AST,
    cs.REB,
    cs.STL,
    cs.BLK,
    cs.FG_PCT,
    cs.FG3_PCT,
    cs.FT_PCT
FROM career_stats cs
JOIN filtered_players fp ON fp.id = cs.PLAYER_ID
WHERE fp.full_name LIKE '%$search%'
   OR cs.PLAYER_ID LIKE '%$search%'
LIMIT 20;
";

$result = $conn->query($sql);
$out = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $row['PLAYER_ID'] = (int)$row['PLAYER_ID'];
        $row['GP'] = (int)$row['GP'];
        foreach (['PTS','AST','REB','STL','BLK','FG_PCT','FG3_PCT','FT_PCT'] as $field) {
            $row[$field] = isset($row[$field]) ? (float)$row[$field] : 0;
        }
        $out[] = $row;
    }
}

echo json_encode($out);
$conn->close();
?>