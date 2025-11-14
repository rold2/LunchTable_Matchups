<?php
require_once 'config.php';

// Get all players from database initially
$stmt = $pdo->query("SELECT id, full_name, is_active FROM players ORDER BY full_name");
$players = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>LunchTable Matchups – Players Tab</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Same CSS as above -->
<style>
/* ... (same CSS styles as above) ... */
</style>
</head>
<body>

<!-- Same HTML structure as above -->
<header>
    <div class="logo-container">
        <!-- Same logo HTML -->
    </div>
</header>

<div class="container">
    <div class="search-section">
        <input type="text" id="searchInput" placeholder="Search for your All-Time fave Player and view relevant information about them">
    </div>

    <div class="player-grid" id="playerGrid">
        <?php foreach($players as $player): ?>
            <div class="player-card" onclick="openModal(<?= htmlspecialchars(json_encode($player), ENT_QUOTES, 'UTF-8') ?>)">
                <img src="https://i.pravatar.cc/150?img=<?= $player['id'] % 70 ?>" alt="<?= htmlspecialchars($player['full_name']) ?>">
                <div class="name"><?= htmlspecialchars($player['full_name']) ?></div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Same modal HTML -->

<script>
// Enhanced search with AJAX
document.getElementById('searchInput').addEventListener('input', function(e) {
    const term = e.target.value.trim();
    
    if (term.length < 2) {
        // If search term is too short, show all players
        loadAllPlayers();
        return;
    }
    
    // AJAX search
    fetch(`search.php?search=${encodeURIComponent(term)}`)
        .then(response => response.json())
        .then(players => {
            renderPlayers(players);
        })
        .catch(error => console.error('Error:', error));
});

function loadAllPlayers() {
    fetch('search.php?search=')
        .then(response => response.json())
        .then(players => {
            renderPlayers(players);
        });
}

function renderPlayers(players) {
    const grid = document.getElementById('playerGrid');
    grid.innerHTML = '';
    
    players.forEach(player => {
        const card = document.createElement('div');
        card.className = 'player-card';
        card.onclick = () => openModal(player);
        card.innerHTML = `
            <img src="https://i.pravatar.cc/150?img=${player.id % 70}" alt="${player.full_name}">
            <div class="name">${player.full_name}</div>
        `;
        grid.appendChild(card);
    });
}

// Same modal functions as before
function openModal(player){
    document.getElementById('modalAvatar').src = `https://i.pravatar.cc/150?img=${player.id % 70}`;
    document.getElementById('modalName').textContent = player.full_name;
    document.getElementById('modalStatus').textContent = `Status: ${player.is_active ? 'Active' : 'Retired'}`;
    document.getElementById('modalStats').textContent = `ID: ${player.id}`;
    
    const statsGrid = document.getElementById('statsGrid');
    statsGrid.innerHTML = '';
    
    const stats = [
        {label: 'Games', value: Math.floor(Math.random() * 1500)},
        {label: 'Points', value: Math.floor(Math.random() * 30000)},
        {label: 'Rebounds', value: Math.floor(Math.random() * 10000)},
        {label: 'Assists', value: Math.floor(Math.random() * 8000)}
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
    
    const awards = player.is_active ? 
        'NBA All-Star, All-NBA Team, Olympic Gold Medal' : 
        'Hall of Fame, NBA Champion, MVP';
    
    document.getElementById('modalAwards').textContent = awards;
    modal.classList.add('active');
}

// Close modal functionality
const modal = document.getElementById('playerModal');
const closeBtn = document.getElementById('closeModal');
closeBtn.onclick = () => modal.classList.remove('active');
window.onclick = e => { if(e.target===modal) modal.classList.remove('active'); };
</script>
</body>
</html>