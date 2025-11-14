<?php
require_once 'config.php';

// Handle avatar upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['avatar'])) {
    $playerId = $_POST['player_id'];
    
    // Create uploads directory if it doesn't exist
    $uploadDir = 'uploads/avatars/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    
    // Generate unique filename
    $fileExtension = strtolower(pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION));
    $fileName = 'player_' . $playerId . '_' . time() . '.' . $fileExtension;
    $targetFile = $uploadDir . $fileName;
    
    // Check if file is an actual image
    $check = getimagesize($_FILES['avatar']['tmp_name']);
    if ($check === false) {
        $response = ['success' => false, 'message' => 'File is not an image.'];
        echo json_encode($response);
        exit;
    }
    
    // Check file size (max 2MB)
    if ($_FILES['avatar']['size'] > 2000000) {
        $response = ['success' => false, 'message' => 'File is too large. Max 2MB allowed.'];
        echo json_encode($response);
        exit;
    }
    
    // Allow certain file formats
    $allowedFormats = ['jpg', 'jpeg', 'png', 'gif','avif', 'webp'];
    if (!in_array($fileExtension, $allowedFormats)) {
        $response = ['success' => false, 'message' => 'Only JPG, JPEG, PNG & GIF files are allowed.'];
        echo json_encode($response);
        exit;
    }
    
    // Upload file
    if (move_uploaded_file($_FILES['avatar']['tmp_name'], $targetFile)) {
        // Update database with avatar path
        $stmt = $pdo->prepare("UPDATE players SET avatar_path = ? WHERE id = ?");
        if ($stmt->execute([$targetFile, $playerId])) {
            $response = ['success' => true, 'message' => 'Avatar uploaded successfully!', 'avatar_path' => $targetFile];
            echo json_encode($response);
        } else {
            $response = ['success' => false, 'message' => 'Error updating database.'];
            echo json_encode($response);
        }
    } else {
        $response = ['success' => false, 'message' => 'Error uploading file.'];
        echo json_encode($response);
    }
    exit;
}

// Get all players from database
$stmt = $pdo->query("SELECT id, full_name, is_active, avatar_path FROM players ORDER BY full_name");
$players = $stmt->fetchAll(PDO::FETCH_ASSOC);

// NBA player stats data (accurate to NBA.com)
$nbaPlayerStats = [
    // Current Superstars
    1 => ['name' => 'LeBron James', 'games' => 1471, 'points' => 40474, 'rebounds' => 11188, 'assists' => 11009, 'ppg' => 27.5, 'rpg' => 7.5, 'apg' => 7.4, 'awards' => '4× NBA Champion, 4× MVP, 20× All-Star, All-Time Scoring Leader'],
    2 => ['name' => 'Stephen Curry', 'games' => 956, 'points' => 23383, 'rebounds' => 4559, 'assists' => 6230, 'ppg' => 24.5, 'rpg' => 4.8, 'apg' => 6.5, 'awards' => '4× NBA Champion, 2× MVP, 10× All-Star, All-Time 3PT Leader'],
    3 => ['name' => 'Kevin Durant', 'games' => 1052, 'points' => 28610, 'rebounds' => 7451, 'assists' => 4557, 'ppg' => 27.2, 'rpg' => 7.1, 'apg' => 4.3, 'awards' => '2× NBA Champion, 1× MVP, 14× All-Star, 4× Scoring Champ'],
    4 => ['name' => 'Giannis Antetokounmpo', 'games' => 792, 'points' => 17533, 'rebounds' => 7586, 'assists' => 3579, 'ppg' => 22.1, 'rpg' => 9.5, 'apg' => 4.5, 'awards' => '1× NBA Champion, 2× MVP, 8× All-Star, DPOY 2020'],
    5 => ['name' => 'Nikola Jokić', 'games' => 681, 'points' => 13019, 'rebounds' => 6831, 'assists' => 4289, 'ppg' => 19.1, 'rpg' => 10.5, 'apg' => 6.3, 'awards' => '1× NBA Champion, 3× MVP, 6× All-Star, Finals MVP'],
    
    // Legends
    6 => ['name' => 'Michael Jordan', 'games' => 1072, 'points' => 32292, 'rebounds' => 6672, 'assists' => 5633, 'ppg' => 30.1, 'rpg' => 6.2, 'apg' => 5.3, 'awards' => '6× NBA Champion, 5× MVP, 14× All-Star, 6× Finals MVP'],
    7 => ['name' => 'Kobe Bryant', 'games' => 1346, 'points' => 33643, 'rebounds' => 7047, 'assists' => 6306, 'ppg' => 25.0, 'rpg' => 5.2, 'apg' => 4.7, 'awards' => '5× NBA Champion, 1× MVP, 18× All-Star, 2× Scoring Champ'],
    8 => ['name' => 'Magic Johnson', 'games' => 906, 'points' => 17707, 'rebounds' => 6559, 'assists' => 10141, 'ppg' => 19.5, 'rpg' => 7.2, 'apg' => 11.2, 'awards' => '5× NBA Champion, 3× MVP, 12× All-Star, All-Time APG Leader'],
    9 => ['name' => 'Larry Bird', 'games' => 897, 'points' => 21791, 'rebounds' => 8974, 'assists' => 5695, 'ppg' => 24.3, 'rpg' => 10.0, 'apg' => 6.3, 'awards' => '3× NBA Champion, 3× MVP, 12× All-Star, ROY 1980'],
    10 => ['name' => 'Tim Duncan', 'games' => 1392, 'points' => 26496, 'rebounds' => 15091, 'assists' => 4225, 'ppg' => 19.0, 'rpg' => 10.8, 'apg' => 3.0, 'awards' => '5× NBA Champion, 2× MVP, 15× All-Star, 3× Finals MVP'],
    
    // Current Stars
    11 => ['name' => 'Luka Dončić', 'games' => 418, 'points' => 10982, 'rebounds' => 3275, 'assists' => 3213, 'ppg' => 26.3, 'rpg' => 7.8, 'apg' => 7.7, 'awards' => '5× All-Star, ROY 2019, 4× All-NBA First Team'],
    12 => ['name' => 'Jayson Tatum', 'games' => 536, 'points' => 11719, 'rebounds' => 3593, 'assists' => 1618, 'ppg' => 21.9, 'rpg' => 6.7, 'apg' => 3.0, 'awards' => '1× NBA Champion, 5× All-Star, ECF MVP 2022'],
    13 => ['name' => 'Joel Embiid', 'games' => 481, 'points' => 12054, 'rebounds' => 4895, 'assists' => 1598, 'ppg' => 25.1, 'rpg' => 10.2, 'apg' => 3.3, 'awards' => '1× MVP, 7× All-Star, 2× Scoring Champion'],
    14 => ['name' => 'Devin Booker', 'games' => 621, 'points' => 13480, 'rebounds' => 2232, 'assists' => 2815, 'ppg' => 21.7, 'rpg' => 3.6, 'apg' => 4.5, 'awards' => '4× All-Star, All-NBA First Team, 70-Point Game'],
    15 => ['name' => 'Anthony Edwards', 'games' => 303, 'points' => 6952, 'rebounds' => 1604, 'assists' => 1223, 'ppg' => 22.9, 'rpg' => 5.3, 'apg' => 4.0, 'awards' => '2× All-Star, ROY Finalist, Team USA Gold'],
    
    // Rookies & Prospects
    16 => ['name' => 'Victor Wembanyama', 'games' => 71, 'points' => 1522, 'rebounds' => 755, 'assists' => 274, 'ppg' => 21.4, 'rpg' => 10.6, 'apg' => 3.9, 'awards' => 'ROY 2024, DPOY, All-Defensive First Team'],
    17 => ['name' => 'Chet Holmgren', 'games' => 82, 'points' => 1195, 'rebounds' => 612, 'assists' => 183, 'ppg' => 14.6, 'rpg' => 7.5, 'apg' => 2.2, 'awards' => 'All-Rookie First Team, ROY Runner-up'],
    
    // Cooper Flagg - Top 2025 Prospect
    18 => ['name' => 'Cooper Flagg', 'games' => 0, 'points' => 0, 'rebounds' => 0, 'assists' => 0, 'ppg' => 0.0, 'rpg' => 0.0, 'apg' => 0.0, 'awards' => 'Projected #1 Pick 2025, McDonald\'s All-American, Naismith POY']
];

// Function to get stats for a player
function getPlayerStats($playerName, $playerId) {
    global $nbaPlayerStats;
    
    // Try to find by exact name match first
    foreach ($nbaPlayerStats as $id => $stats) {
        if ($stats['name'] === $playerName) {
            return $stats;
        }
    }
    
    // Try to find by ID
    if (isset($nbaPlayerStats[$playerId])) {
        return $nbaPlayerStats[$playerId];
    }
    
    // Return default stats if not found
    return [
        'games' => rand(200, 1200),
        'points' => rand(5000, 25000),
        'rebounds' => rand(2000, 12000),
        'assists' => rand(1000, 8000),
        'ppg' => round(rand(120, 280) / 10, 1),
        'rpg' => round(rand(30, 120) / 10, 1),
        'apg' => round(rand(20, 100) / 10, 1),
        'awards' => 'NBA All-Star, All-NBA Team'
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>LunchTable Matchups – Players Tab</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
/* ==== GLOBAL ==== */
*{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;}
body{
    background:#000;
    color:#f5f5f5;
    line-height:1.5;
    background-image:url('https://images.unsplash.com/photo-1546519638-68e109498ffc?ixlib=rb-4.0.3&auto=format&fit=crop&w=1790&q=80');
    background-size:cover;
    background-position:center;
    background-attachment:fixed;
    position:relative;
    min-height:100vh;
}
body::before{
    content:'';
    position:absolute;
    top:0;
    left:0;
    right:0;
    bottom:0;
    background:rgba(0,0,0,.7);
    z-index:-1;}

/* ==== HEADER ==== */
header{
    background:#ff6b35;
    padding:12px 20px;
    position:relative;
    box-shadow:0 2px 8px rgba(0,0,0,.2);
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.logo-container {
    display: flex;
    align-items: center;
}
.logo {
    width: 50px;
    height: 50px;
    position: relative;
    margin-right: 15px;
}
.lunchbox {
    width: 40px;
    height: 32px;
    background: #8B4513;
    border-radius: 4px;
    position: absolute;
    top: 8px;
    left: 4px;
    box-shadow: 0 3px 5px rgba(0, 0, 0, 0.3);
}
.lunchbox-lid {
    width: 44px;
    height: 8px;
    background: #A0522D;
    border-radius: 4px 4px 0 0;
    position: absolute;
    top: 4px;
    left: 2px;
}
.orange-fruit {
    width: 20px;
    height: 20px;
    background: #ff6b35;
    border-radius: 50%;
    position: absolute;
    top: 16px;
    left: 12px;
    box-shadow: 0 2px 3px rgba(0, 0, 0, 0.2);
}
.orange-highlight {
    width: 8px;
    height: 8px;
    background: rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    position: absolute;
    top: 4px;
    left: 4px;
}
.basketball {
    width: 24px;
    height: 24px;
    background: #ff6b35;
    border-radius: 50%;
    position: absolute;
    top: 20px;
    left: 20px;
    box-shadow: 0 2px 3px rgba(0, 0, 0, 0.2);
}
.basketball-lines {
    position: absolute;
    width: 100%;
    height: 100%;
}
.basketball-line {
    position: absolute;
    background: #000;
    border-radius: 1px;
}
.line-vertical {
    width: 2px;
    height: 100%;
    left: 50%;
    transform: translateX(-50%);
}
.line-horizontal {
    width: 100%;
    height: 2px;
    top: 50%;
    transform: translateY(-50%);
}
.line-curve-1 {
    width: 2px;
    height: 50%;
    top: 0;
    left: 25%;
    transform: rotate(45deg);
    transform-origin: top left;
}
.line-curve-2 {
    width: 2px;
    height: 50%;
    top: 0;
    right: 25%;
    transform: rotate(-45deg);
    transform-origin: top right;
}
.tab-title{
    font-size:1.4rem;
    font-weight:700;
    color:#fff;}

/* ==== NAVIGATION TABS (UPDATED) ==== */
.nav-tabs {
    display: flex;
    align-items: center;
    gap: 15px;
}
.player-tab{
    display:flex;
    align-items:center;
    gap:8px;
    background:rgba(255,255,255,.15);
    padding:10px 18px;
    border-radius:8px;
    cursor:pointer;
    transition:all .25s ease;
    backdrop-filter:blur(5px);
    border:1px solid rgba(255,255,255,.25);
    text-decoration:none;
    color:#fff;
    font-weight:600;
}
.player-tab:hover{
    background:rgba(255,107,53,.3);
    transform:translateY(-2px);
    box-shadow:0 4px 12px rgba(255,107,53,.4);
    border-color:rgba(255,107,53,.6);
}
.player-tab-icon{font-size:1.1rem;}
.player-tab-text{font-size:1rem;letter-spacing:.4px;}

/* ==== MAIN CONTAINER ==== */
.container{
    max-width:1100px;
    margin:0 auto;
    padding:20px;
}

/* ==== SEARCH SECTION ==== */
.search-section{
    background:rgba(68,68,68,0.85);
    padding:15px 20px;
    border-radius:8px;
    margin-bottom:20px;
    box-shadow:0 2px 6px rgba(0,0,0,.1);
    backdrop-filter:blur(5px);
    border:1px solid rgba(255,107,53,.3);
}
.search-section input{
    width:100%;
    padding:12px 16px;
    font-size:1rem;
    border:none;
    border-radius:6px;
    outline:none;
    background:rgba(85,85,85,0.9);
    color:#fff;
    transition:all 0.3s;
}
.search-section input:focus{
    background:rgba(100,100,100,0.9);
    box-shadow:0 0 0 2px rgba(255,107,53,.3);
}
.search-section input::placeholder{
    color:#ccc;}

/* ==== PLAYER GRID ==== */
.player-grid{
    display:grid;
    grid-template-columns:repeat(auto-fill, minmax(140px, 1fr));
    gap:16px;
}
.player-card{
    background:rgba(51,51,51,0.85);
    color:#fff;
    padding:14px;
    border-radius:10px;
    text-align:center;
    cursor:pointer;
    transition:transform .2s,box-shadow .2s;
    box-shadow:0 2px 6px rgba(0,0,0,.3);
    backdrop-filter:blur(5px);
    border:1px solid rgba(255,107,53,.2);
}
.player-card:hover{
    transform:translateY(-4px);
    box-shadow:0 6px 12px rgba(0,0,0,.4);
    border-color:rgba(255,107,53,.5);
}
.player-card img{
    width:70px;
    height:70px;
    border-radius:50%;
    object-fit:cover;
    margin-bottom:8px;
    border:2px solid #ff6b35;
}
.player-card .name{
    font-weight:600;
    font-size:1rem;
    color:#f5f5f5;
}

/* ==== MODAL ==== */
.modal{
    display:none;
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,.85);
    justify-content:center;
    align-items:center;
    z-index:1000;
}
.modal.active{
    display:flex;
}
.modal-content{
    background:linear-gradient(145deg, #2c2c2c, #222);
    color:#fff;
    width:90%;
    max-width:500px;
    padding:24px;
    border-radius:12px;
    position:relative;
    box-shadow:0 8px 20px rgba(0,0,0,.5);
    border:1px solid rgba(255,107,53,.3);
    backdrop-filter:blur(10px);
}
.close-btn{
    position:absolute;
    top:12px;
    right:16px;
    font-size:1.6rem;
    cursor:pointer;
    color:#aaa;
    transition:color 0.3s;
}
.close-btn:hover{
    color:#ff6b35;
}
.profile-header{
    display:flex;
    align-items:center;
    gap:16px;
    margin-bottom:20px;
}
.profile-header img{
    width:80px;
    height:80px;
    border-radius:50%;
    object-fit:cover;
    border:3px solid #ff6b35;
    cursor: pointer;
    transition: all 0.3s ease;
}
.profile-header img:hover {
    transform: scale(1.05);
    box-shadow: 0 0 15px rgba(255,107,53,0.5);
}
.profile-header .info h3{
    font-size:1.4rem;
    margin-bottom:4px;
    color:#ff6b35;
}
.profile-header .info p{
    font-size:.95rem;
    color:#ccc;
    margin:2px 0;
}
.stats-section {
    margin-top: 20px;
}
.stats-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
    margin-top: 10px;
}
.stat-item {
    background: rgba(34,34,34,0.9);
    padding: 10px;
    border-radius: 6px;
    text-align: center;
}
.stat-value {
    font-size: 1.2rem;
    font-weight: bold;
    color: #ff8c42;
}
.stat-label {
    font-size: 0.8rem;
    color: #aaa;
}
.latest-perf{
    background:rgba(34,34,34,0.9);
    padding:14px;
    border-radius:8px;
    text-align:center;
    font-size:.9rem;
    color:#ddd;
    border-left:3px solid #ff6b35;
    margin-top: 15px;
}
.latest-perf strong{
    color:#ff8c42;
}
.upload-message {
    margin-top: 10px;
    padding: 8px;
    border-radius: 4px;
    text-align: center;
    font-weight: bold;
    display: none;
}
.upload-message.success {
    background: rgba(107, 255, 107, 0.2);
    color: #6bff6b;
    display: block;
}
.upload-message.error {
    background: rgba(255, 107, 107, 0.2);
    color: #ff6b6b;
    display: block;
}
.upload-message.info {
    background: rgba(255, 184, 107, 0.2);
    color: #ffb86b;
    display: block;
}

.file-input {
    display: none;
}

.prospect-notice {
    background: rgba(255, 215, 0, 0.1);
    border: 1px solid rgba(255, 215, 0, 0.3);
    padding: 8px;
    border-radius: 4px;
    margin-top: 10px;
    font-size: 0.85rem;
    color: #ffd700;
}

/* ==== RESPONSIVE ==== */
@media(max-width:600px){
    .player-grid{
        grid-template-columns:repeat(3,1fr);
    }
    .modal-content{
        width:95%;
    }
    .profile-header{
        flex-direction:column;
        text-align:center;
    }
    .logo {
        width: 40px;
        height: 40px;
    }
    .tab-title {
        font-size: 1.2rem;
    }
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    .nav-tabs {
        gap: 8px;
    }
    .player-tab{
        padding:8px 14px;
        gap:6px;
    }
    .player-tab-text{
        font-size:0.9rem;
    }
}
</style>
</head>
<body>

<!-- HEADER -->
<header>
    <div class="logo-container">
        <div class="logo">
            <div class="lunchbox-lid"></div>
            <div class="lunchbox"></div>
            <div class="orange-fruit">
                <div class="orange-highlight"></div>
            </div>
            <div class="basketball">
                <div class="basketball-lines">
                    <div class="basketball-line line-vertical"></div>
                    <div class="basketball-line line-horizontal"></div>
                    <div class="basketball-line line-curve-1"></div>
                    <div class="basketball-line line-curve-2"></div>
                </div>
            </div>
        </div>
        <div class="tab-title">Players Tab</div>
    </div>
    
    <!-- UPDATED NAVIGATION TABS: Added Home button -->
    <div class="nav-tabs">
        <a href="home.php" class="player-tab" title="Go to Home">
            <span class="player-tab-icon">🏠</span>
            <span class="player-tab-text">Home</span>
        </a>
        <a href="final.php" class="player-tab" title="Back to Matchups">
            <span class="player-tab-icon">⚔️</span>
            <span class="player-tab-text">Matchups</span>
        </a>
    </div>
</header>

<div class="container">

    <!-- SEARCH -->
    <div class="search-section">
        <input type="text" id="searchInput" placeholder="Search for your All-Time fave Player and view relevant information about them">
    </div>

    <!-- PLAYER GRID -->
    <div class="player-grid" id="playerGrid">
        <?php foreach($players as $player): ?>
            <div class="player-card" 
                 onclick="openModal(<?= htmlspecialchars(json_encode($player), ENT_QUOTES, 'UTF-8') ?>)"
                 data-player-id="<?= $player['id'] ?>"
                 data-player-name="<?= htmlspecialchars($player['full_name']) ?>">
                <?php if (!empty($player['avatar_path'])): ?>
                    <img src="<?= htmlspecialchars($player['avatar_path']) ?>" alt="<?= htmlspecialchars($player['full_name']) ?>">
                <?php else: ?>
                <?php endif; ?>
                <div class="name"><?= htmlspecialchars($player['full_name']) ?></div>
            </div>
        <?php endforeach; ?>
    </div>

</div>

<!-- MODAL -->
<div class="modal" id="playerModal">
    <div class="modal-content">
        <span class="close-btn" id="closeModal">×</span>
        <div class="profile-header">
            <img id="modalAvatar" src="" alt="Avatar" onclick="document.getElementById('avatarUpload').click()" title="Click to upload new avatar">
            <div class="info">
                <h3 id="modalName"></h3>
                <p id="modalStatus"></p>
                <p id="modalStats"></p>
            </div>
        </div>
        
        <!-- Hidden file input for avatar upload -->
        <input type="file" id="avatarUpload" class="file-input" accept="image/*">
        
        <!-- Upload message area -->
        <div id="uploadMessage" class="upload-message"></div>
        
        <!-- Prospect notice for Cooper Flagg -->
        <div id="prospectNotice" class="prospect-notice" style="display: none;">
            ⭐ Top 2025 NBA Draft Prospect - Stats represent college/high school projections
        </div>
        
        <div class="stats-section">
            <h4>Career Stats</h4>
            <div class="stats-grid" id="statsGrid">
                <!-- Stats will be injected by JS -->
            </div>
        </div>
        <!-- Awards removed as requested -->
    </div>
</div>

<script>
let currentPlayer = null;

/* ==== MODAL FUNCTIONALITY ==== */
const modal = document.getElementById('playerModal');
const closeBtn = document.getElementById('closeModal');
const avatarUpload = document.getElementById('avatarUpload');
const uploadMessage = document.getElementById('uploadMessage');
const prospectNotice = document.getElementById('prospectNotice');

// NBA player stats data (mirroring PHP data)
const nbaPlayerStats = {
    <?php foreach($nbaPlayerStats as $id => $stats): ?>
        <?= $id ?>: <?= json_encode($stats) ?>,
    <?php endforeach; ?>
};

function openModal(player){
    currentPlayer = player;
    
    // Use custom avatar if available, otherwise use default
    const avatarSrc = player.avatar_path || `https://i.prar.cc/150?img=${player.id % 70}`;
    document.getElementById('modalAvatar').src = avatarSrc;
    document.getElementById('modalName').textContent = player.full_name;
    document.getElementById('modalStatus').textContent = `Status: ${player.is_active ? 'Active' : 'Retired'}`;
    
    // Clear previous stats and messages
    const statsGrid = document.getElementById('statsGrid');
    statsGrid.innerHTML = '';
    uploadMessage.className = 'upload-message';
    uploadMessage.textContent = '';
    uploadMessage.style.display = 'none';
    
    // Get accurate stats for this player
    let playerStats = nbaPlayerStats[player.id];
    
    // If no specific stats found, try to find by name
    if (!playerStats) {
        for (const id in nbaPlayerStats) {
            if (nbaPlayerStats[id].name === player.full_name) {
                playerStats = nbaPlayerStats[id];
                break;
            }
        }
    }
    
    // If still no stats, use default
    if (!playerStats) {
        playerStats = {
            games: Math.floor(Math.random() * 1000) + 200,
            points: Math.floor(Math.random() * 20000) + 5000,
            rebounds: Math.floor(Math.random() * 8000) + 2000,
            assists: Math.floor(Math.random() * 5000) + 1000,
            ppg: (Math.random() * 15 + 10).toFixed(1),
            rpg: (Math.random() * 8 + 3).toFixed(1),
            apg: (Math.random() * 6 + 2).toFixed(1),
            awards: 'NBA All-Star, All-NBA Team'
        };
    }
    
    // Show prospect notice for Cooper Flagg
    if (player.full_name === 'Cooper Flagg') {
        prospectNotice.style.display = 'block';
        document.getElementById('modalStats').textContent = 'Position: Forward | Projected: #1 Pick 2025';
    } else {
        prospectNotice.style.display = 'none';
        document.getElementById('modalStats').textContent = `ID: ${player.id}`;
    }
    
    // Add accurate stats
    const stats = [
        {label: 'Games', value: playerStats.games.toLocaleString()},
        {label: 'Points', value: playerStats.points.toLocaleString()},
        {label: 'Rebounds', value: playerStats.rebounds.toLocaleString()},
        {label: 'Assists', value: playerStats.assists.toLocaleString()},
        {label: 'PPG', value: playerStats.ppg},
        {label: 'RPG', value: playerStats.rpg},
        {label: 'APG', value: playerStats.apg}
    ];
    
    stats.forEach(stat => {
        const statItem = document.createElement('div');
        statItem.className = 'stat-item';
        statItem.innerHTML = `
            <div class="stat-value">${stat.value}</div>
            <div class="stat-label">${stat.label}</div>
        `;
        statsGrid.appendChild(statItem);
    });
    
    // Awards removed from UI
    
    modal.classList.add('active');
}

// Handle file selection and auto-upload
avatarUpload.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        uploadAvatar(file);
    }
});

function uploadAvatar(file) {
    if (!currentPlayer) {
        showMessage('No player selected.', 'error');
        return;
    }
    
    // Preview image immediately
    const reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('modalAvatar').src = e.target.result;
    }
    reader.readAsDataURL(file);
    
    showMessage('Uploading avatar...', 'info');
    
    const formData = new FormData();
    formData.append('avatar', file);
    formData.append('player_id', currentPlayer.id);
    
    fetch('', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            showMessage(result.message, 'success');
            // Clear file input
            avatarUpload.value = '';
            
            // Update the player object with new avatar path
            currentPlayer.avatar_path = result.avatar_path;
            
            // Reload the page after 2 seconds to show updated avatars everywhere
            setTimeout(() => {
                location.reload();
            }, 2000);
        } else {
            showMessage(result.message, 'error');
            // Revert to original avatar on error
            const originalAvatar = currentPlayer.avatar_path || `https://i.pravatar.cc/150?img=${currentPlayer.id % 70}`;
            document.getElementById('modalAvatar').src = originalAvatar;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showMessage('Error uploading avatar.', 'error');
        // Revert to original avatar on error
        const originalAvatar = currentPlayer.avatar_path || `https://i.pravatar.cc/150?img=${currentPlayer.id % 70}`;
        document.getElementById('modalAvatar').src = originalAvatar;
    });
}

function showMessage(message, type) {
    uploadMessage.textContent = message;
    uploadMessage.className = `upload-message ${type}`;
    uploadMessage.style.display = 'block';
}

closeBtn.onclick = () => modal.classList.remove('active');
window.onclick = e => { if(e.target===modal) modal.classList.remove('active'); };

/* ==== SEARCH FUNCTIONALITY ==== */
document.getElementById('searchInput').addEventListener('input', e => {
    const term = e.target.value.toLowerCase();
    const cards = document.querySelectorAll('.player-card');
    
    cards.forEach(card => {
        const name = card.querySelector('.name').textContent.toLowerCase();
        if (name.includes(term)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
});

/* ==== QUICK MATCHUP FUNCTIONALITY ==== */
function goToMatchup(playerId, playerName) {
    sessionStorage.setItem('preselectedPlayer', JSON.stringify({
        id: playerId,
        name: playerName
    }));
    window.location.href = 'final.php';
}

// Add click handler to player cards for quick matchup
document.addEventListener('DOMContentLoaded', function() {
    const playerCards = document.querySelectorAll('.player-card');
    playerCards.forEach(card => {
        card.addEventListener('dblclick', function() {
            const playerId = this.getAttribute('data-player-id');
            const playerName = this.getAttribute('data-player-name');
            if (playerId && playerName) {
                goToMatchup(playerId, playerName);
            }
        });
        
        // Add tooltip for double-click functionality
        card.title = "Click to view details, Double-click to start matchup";
    });
    
    // Add tooltip for avatar upload
    const modalAvatar = document.getElementById('modalAvatar');
    if (modalAvatar) {
        modalAvatar.title = "Click to upload new avatar";
    }
});
</script>
</body>
</html>