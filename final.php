<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>LunchTable Matchups</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.min.css">
<style>
/* ────────────────────── COMMON ────────────────────── */
*{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;}
body{background:#000;color:#f5f5f5;min-height:100vh;display:flex;flex-direction:column;background-image:url('https://images.unsplash.com/photo-1546519638-68e109498ffc?ixlib=rb-4.0.3&auto=format&fit=crop&w=1790&q=80');background-size:cover;background-position:center;background-attachment:fixed;position:relative;}
body::before{content:'';position:absolute;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,.75);z-index:-1;}
header{background:#ff6b35;height:80px;box-shadow:0 2px 15px rgba(0,0,0,.5);position:relative;z-index:100;display:flex;align-items:center;justify-content:space-between;padding:0 20px;}
.header-content{display:flex;align-items:center;gap:12px;}
.logo{width:48px;height:48px;position:relative;flex-shrink:0;}
.lunchbox{width:40px;height:32px;background:#8B4513;border-radius:5px;position:absolute;top:8px;left:4px;box-shadow:0 3px 5px rgba(0,0,0,.3);}
.lunchbox-lid{width:44px;height:9px;background:#A0522D;border-radius:5px 5px 0 0;position:absolute;top:4px;left:2px;}
.orange-fruit{width:21px;height:21px;background:#ff6b35;border-radius:50%;position:absolute;top:15px;left:11px;box-shadow:0 2px 3px rgba(0,0,0,.2);}
.orange-highlight{width:8px;height:8px;background:rgba(255,255,255,.3);border-radius:50%;position:absolute;top:4px;left:4px;}
.basketball{width:25px;height:25px;background:#ff6b35;border-radius:50%;position:absolute;top:19px;left:21px;box-shadow:0 2px 3px rgba(0,0,0,.2);}
.basketball-lines{position:absolute;width:100%;height:100%;}
.basketball-line{position:absolute;background:#000;border-radius:1px;}
.line-vertical{width:2px;height:100%;left:50%;transform:translateX(-50%);}
.line-horizontal{width:100%;height:2px;top:50%;transform:translateY(-50%);}
.line-curve-1{width:2px;height:50%;top:0;left:25%;transform:rotate(45deg);transform-origin:top left;}
.line-curve-2{width:2px;height:50%;top:0;right:25%;transform:rotate(-45deg);transform-origin:top right;}
.page-title{font-size:1.9rem;font-weight:700;color:#fff;letter-spacing:.5px;text-shadow:0 2px 8px rgba(0,0,0,.4);}
#homeLink{transition:all .3s ease;text-decoration:none;display:flex;align-items:center;gap:12px;}
#homeLink:hover{text-shadow:0 0 20px rgba(255,107,53,.8), 0 2px 8px rgba(0,0,0,.4);}
#homeLink:hover .page-title{color:#ffb088;}
#homeLink:hover .logo{filter:drop-shadow(0 0 12px rgba(255,107,53,.6));}

/* ────────────────────── NAVIGATION TABS ────────────────────── */
.nav-tabs {
    display:flex;
    align-items:center;
    gap:15px;
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

/* ────────────────────── HOME SECTION ────────────────────── */
#home-section{padding:60px 20px;display:flex;flex-direction:column;align-items:center;min-height:calc(100vh - 80px);}
.subtitle{
    background:rgba(0,0,0,.7);
    padding:18px 30px;
    border-radius:12px;
    font-size:1.1rem;
    color:#fff;
    text-align:center;
    max-width:600px;
    margin-bottom:50px;
    backdrop-filter:blur(8px);
    border:1px solid rgba(255,107,53,.3);
    box-shadow:0 4px 15px rgba(0,0,0,.4);
}
.matchup-container{
    display:flex;
    justify-content:center;
    align-items:stretch;
    gap:40px;
    flex-wrap:wrap;
    width:100%;
    max-width:1200px;
    margin:0 auto;
}
.player-card{
    background:rgba(30,30,30,.9);
    border-radius:16px;
    padding:25px;
    flex:1;
    min-width:300px;
    max-width:400px;
    box-shadow:0 8px 25px rgba(0,0,0,.5);
    border-left:4px solid #ff6b35;
    backdrop-filter:blur(10px);
    transition:transform .3s,box-shadow .3s;
    display:flex;
    flex-direction:column;
}
.player-card:hover{
    transform:translateY(-8px);
    box-shadow:0 12px 30px rgba(0,0,0,.7);
}
.player-title{
    font-size:1.4rem;
    font-weight:600;
    color:#fff;
    margin-bottom:20px;
    text-align:center;
}
.search-container{
    position:relative;
    margin-bottom:20px;
}
.search-input{
    width:100%;
    padding:14px 50px 14px 20px;
    background:rgba(50,50,50,.9);
    border:2px solid transparent;
    border-radius:12px;
    color:#fff;
    font-size:1rem;
    transition:all .3s;
    backdrop-filter:blur(5px);
}
.search-input:focus{
    outline:none;
    border-color:#ff6b35;
    box-shadow:0 0 0 3px rgba(255,107,53,.3);
}
.search-input::placeholder{
    color:#aaa;
}
.search-icon{
    position:absolute;
    right:16px;
    top:50%;
    transform:translateY(-50%);
    color:#ff6b35;
    font-weight:bold;
}
.search-results{
    position:absolute;
    top:100%;
    left:0;
    right:0;
    background:rgba(40,40,40,.95);
    border-radius:12px;
    margin-top:8px;
    max-height:200px;
    overflow-y:auto;
    z-index:10;
    display:none;
    border:1px solid #444;
    box-shadow:0 8px 20px rgba(0,0,0,.6);
    backdrop-filter:blur(8px);
}
.search-result-item{
    padding:14px 20px;
    cursor:pointer;
    transition:background .2s;
    border-bottom:1px solid #333;
    color:#f5f5f5;
    display:flex;
    align-items:center;
    gap:10px;
}
.search-result-item:hover{
    background:rgba(255,107,53,.25);
}
.search-result-item:last-child{
    border-bottom:none;
}
.search-result-avatar{
    width:30px;
    height:30px;
    border-radius:50%;
    background:#ff6b35;
    display:flex;
    justify-content:center;
    align-items:center;
    font-weight:bold;
    font-size:0.8rem;
    color:#fff;
    flex-shrink:0;
}
.selected-player{
    display:flex;
    align-items:center;
    padding:15px;
    background:rgba(50,50,50,.8);
    border-radius:8px;
    margin-top:15px;
    border-left:3px solid #ff6b35;
    display:none;
}
.player-avatar{
    width:50px;
    height:50px;
    border-radius:50%;
    background:#ff6b35;
    display:flex;
    justify-content:center;
    align-items:center;
    margin-right:15px;
    font-weight:bold;
    font-size:1.2rem;
    color:#fff;
    flex-shrink:0;
}
.player-info{
    flex:1;
    text-align:left;
}
.player-name{
    font-weight:600;
    color:#f5f5f5;
}
.player-stats{
    font-size:.85rem;
    color:#ccc;
    display:block;
    margin-top:6px;
}
.stats-preview{
    background:rgba(40,40,40,.8);
    border-radius:12px;
    padding:18px;
    text-align:center;
    color:#ccc;
    font-size:.9rem;
    line-height:1.5;
    border-left:3px solid #ff6b35;
    flex:1;
    display:flex;
    align-items:center;
    justify-content:center;
}
.vs-container{
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    margin:0 20px;
    flex-shrink:0;
}
.vs-circle{
    width:80px;
    height:80px;
    border-radius:50%;
    background:#ff6b35;
    display:flex;
    justify-content:center;
    align-items:center;
    font-size:1.5rem;
    font-weight:700;
    color:#fff;
    box-shadow:0 0 25px rgba(255,107,53,.8), 0 4px 15px rgba(0,0,0,.4);
    margin-bottom:10px;
    animation:pulse 2s infinite;
}
@keyframes pulse{
    0%{box-shadow:0 0 25px rgba(255,107,53,.8), 0 4px 15px rgba(0,0,0,.4);}
    50%{box-shadow:0 0 35px rgba(255,107,53,1), 0 6px 20px rgba(0,0,0,.5);}
    100%{box-shadow:0 0 25px rgba(255,107,53,.8), 0 4px 15px rgba(0,0,0,.4);}
}
.vs-text{
    font-size:1rem;
    color:#ff6b35;
    text-transform:uppercase;
    letter-spacing:2px;
    font-weight:700;
    text-shadow:0 2px 8px rgba(0,0,0,.5);
}
.action-container{
    display:flex;
    justify-content:center;
    gap:20px;
    margin-top:40px;
    flex-wrap:wrap;
    width:100%;
}
.initiate-btn, .clear-all-btn{
    padding:16px 40px;
    border-radius:50px;
    font-size:1.1rem;
    font-weight:600;
    cursor:pointer;
    transition:all .3s;
    border:none;
    box-shadow:0 4px 15px rgba(0,0,0,.4);
}
.initiate-btn{
    background:#ff6b35;
    color:#fff;
}
.initiate-btn:hover{
    background:#ff5a20;
    transform:translateY(-3px);
    box-shadow:0 6px 20px rgba(255,107,53,.6);
}
.initiate-btn:disabled{
    background:#666;
    cursor:not-allowed;
    transform:none;
    box-shadow:0 4px 12px rgba(0,0,0,.3);
}
.clear-all-btn{
    background:rgba(255,107,53,.15);
    color:#ff6b35;
    border:2px solid rgba(255,107,53,.4);
}
.clear-all-btn:hover{
    background:rgba(255,107,53,.3);
    border-color:rgba(255,107,53,.7);
    transform:translateY(-2px);
    box-shadow:0 4px 15px rgba(255,107,53,.3);
}

/* ────────────────────── MATCHUP SECTION ────────────────────── */
#matchup-section{
    display:none;
    background:linear-gradient(135deg,rgba(15,15,15,0.9)0%,rgba(26,26,26,0.9)100%),url('https://images.unsplash.com/photo-1546519638-68e109498ffc?ixlib=rb-4.0.3&auto=format&fit=crop&w=1790&q=80');
    background-size:cover;
    background-position:center;
    background-attachment:fixed;
    padding:30px 20px;
    position:relative;
    min-height:100vh;
}
.player-comparison{
    display:flex;
    justify-content:space-between;
    gap:30px;
    margin-bottom:40px;
    flex-wrap:wrap;
}
.player-card-m{
    background:linear-gradient(145deg,#222,#2a2a2a);
    padding:25px;
    border-radius:12px;
    flex:1;
    min-width:300px;
    box-shadow:0 4px 15px rgba(0,0,0,.3);
    transition:transform .3s,box-shadow .3s;
    border-left:4px solid transparent;
}
#card-left{
    border-left-color:#ff4500;
}
#card-right{
    border-left-color:#00e0ff;
}
.player-card-m:hover{
    transform:translateY(-5px);
    box-shadow:0 8px 20px rgba(0,0,0,.4);
}
.player-header{
    display:flex;
    align-items:center;
    margin-bottom:20px;
}
.player-avatar-m{
    width:80px;
    height:80px;
    border-radius:50%;
    margin-right:15px;
    background-size:cover;
    background-position:center;
    border:3px solid #ff6600;
    box-shadow:0 4px 10px rgba(0,0,0,.3);
}
#avatar-left{
    border-color:#ff4500;
}
#avatar-right{
    border-color:#00e0ff;
}
.player-info-m{
    flex:1;
}
.player-name-m{
    font-size:24px;
    font-weight:600;
    margin-bottom:5px;
}
#name-left{
    color:#ff4500;
}
#name-right{
    color:#00e0ff;
}
.player-title-m{
    font-size:14px;
    color:#aaa;
    font-style:italic;
}
.player-stats-m{
    list-style:none;
}
.player-stats-m li{
    padding:10px 0;
    border-bottom:1px solid #333;
    display:flex;
    justify-content:space-between;
}
.stat-label{
    color:#ccc;
}
.stat-value{
    font-weight:600;
    color:#fff;
}
#stats-left .stat-value{
    color:#ff4500;
}
#stats-right .stat-value{
    color:#00e0ff;
}
.graph-section{
    margin:40px 0;
}
.graph-title{
    font-size:24px;
    margin-bottom:20px;
    color:#ff6b35;
    font-weight:600;
    text-align:center;
}
.chart-container{
    background:#1a1a1a;
    padding:30px;
    border-radius:16px;
    box-shadow:0 8px 30px rgba(0,0,0,.6);
    border:1px solid #333;
    max-width:1000px;
    margin:0 auto;
}
canvas{
    width:100%!important;
    height:520px!important;
}
.ai-explanation{
    background:linear-gradient(145deg,#1a1a1a,#222);
    padding:25px;
    border-radius:12px;
    margin-top:30px;
    box-shadow:0 4px 15px rgba(0,0,0,.3);
    border-left:4px solid #ff6b35;
    max-width:1000px;
    margin:0 auto;
}
.ai-title{
    font-size:22px;
    color:#ff6b35;
    margin-bottom:15px;
    font-weight:600;
}
.ai-text{
    font-size:16px;
    line-height:1.8;
    color:#ddd;
}
.ai-text strong{
    color:#ff8c42;
}
.verdict{
    font-weight:700;
    color:#ff6b35;
    margin-top:15px;
    font-size:1.1rem;
}
.back-button{
    display:block;
    width:200px;
    margin:40px auto 20px;
    padding:15px 25px;
    background:linear-gradient(90deg,#ff6600 0%,#ff8c42 100%);
    color:#000;
    text-align:center;
    border-radius:8px;
    text-decoration:none;
    font-weight:600;
    font-size:18px;
    transition:all .3s;
    box-shadow:0 4px 15px rgba(255,102,0,.3);
}
.back-button:hover{
    transform:translateY(-3px);
    box-shadow:0 6px 20px rgba(255,102,0,.4);
}

/* ────────────────────── BUTTON STYLES ────────────────────── */
.remove-btn{
    background:none;
    border:none;
    color:#ff6b35;
    width:36px;
    height:36px;
    border-radius:50%;
    font-size:1.4rem;
    cursor:pointer;
    display:flex;
    align-items:center;
    justify-content:center;
    transition:all .2s;
    flex-shrink:0;
    margin-left:auto;
    padding:0;
}
.remove-btn:hover{
    background:rgba(255,107,53,.3);
    color:#fff;
    transform:scale(1.15);
}
.remove-btn:active{
    transform:scale(0.95);
}

/* ────────────────────── RESPONSIVE ────────────────────── */
@media(max-width:1024px){
    .matchup-container{
        gap:30px;
    }
    .vs-container{
        order:3;
        width:100%;
        margin:20px 0;
        flex-direction:row;
        gap:20px;
    }
    .vs-circle{
        margin-bottom:0;
    }
}

@media(max-width:768px){
    header{
        height:70px;
        padding:0 15px;
        flex-direction:column;
        justify-content:center;
        gap:10px;
    }
    .header-content{
        justify-content:center;
    }
    .page-title{font-size:1.6rem;}
    .logo{width:42px;height:42px;}
    .nav-tabs{
        gap:10px;
    }
    .player-tab{
        padding:8px 14px;
        gap:6px;
    }
    .player-tab-text{font-size:0.9rem;}
    
    .player-comparison{flex-direction:column;}
    .player-card-m{width:100%;}
    .player-header{flex-direction:column;text-align:center;}
    .player-avatar-m{margin:0 auto 15px;}
    .back-button{width:90%;margin:30px auto 10px;}
    .matchup-container{gap:20px;}
    .player-card{width:100%;max-width:350px;}
    
    .vs-container{
        flex-direction:column;
        margin:10px 0;
    }
    .vs-circle{
        margin-bottom:10px;
    }
}

@media(max-width:480px){
    header{
        height:auto;
        padding:10px;
    }
    .header-content{
        flex-direction:column;
        gap:5px;
    }
    .nav-tabs{
        flex-wrap:wrap;
        justify-content:center;
    }
    #home-section{
        padding:30px 15px;
    }
    .subtitle{
        padding:15px 20px;
        font-size:1rem;
    }
    .player-card{
        padding:20px;
    }
    .action-container{
        flex-direction:column;
        align-items:center;
    }
    .initiate-btn, .clear-all-btn{
        width:100%;
        max-width:300px;
    }
}
</style>
</head>
<body>

<!-- ====================== HEADER ====================== -->
<header>
    <a href="#" class="header-content" id="homeLink">
        <div class="logo">
            <div class="lunchbox-lid"></div>
            <div class="lunchbox"></div>
            <div class="orange-fruit"><div class="orange-highlight"></div></div>
            <div class="basketball">
                <div class="basketball-lines">
                    <div class="basketball-line line-vertical"></div>
                    <div class="basketball-line line-horizontal"></div>
                    <div class="basketball-line line-curve-1"></div>
                    <div class="basketball-line line-curve-2"></div>
                </div>
            </div>
        </div>
        <h1 class="page-title">LunchTable Matchups</h1>
    </a>

    <!-- NAVIGATION TABS -->
    <div class="nav-tabs">
        <a href="home.php" class="player-tab" title="Go to Home">
            <span class="player-tab-icon">🏠</span>
            <span class="player-tab-text">Home</span>
        </a>
        <a href="index.php" class="player-tab" title="View All Players">
            <span class="player-tab-icon">🏀</span>
            <span class="player-tab-text">Players</span>
        </a>
    </div>
</header>

<!-- ====================== HOME SECTION ====================== -->
<section id="home-section">
    <div class="subtitle">
        Compare Player Stats and determine who's more likely to bring home that dub
    </div>

    <div class="matchup-container">
        <!-- PLAYER 1 -->
        <div class="player-card">
            <h3 class="player-title">Search a Player</h3>
            <div class="search-container">
                <input type="text" class="search-input" placeholder="Type to search players..." data-side="1" id="search-1">
                <div class="search-icon">Search</div>
                <div class="search-results" id="search-results-1"></div>
            </div>
            <div class="selected-player" id="selected-player-1">
                <div class="player-avatar" id="player-avatar-1"></div>
                <div class="player-info">
                    <div class="player-name" id="player-name-1"></div>
                    <div class="player-stats" id="player-stats-1"></div>
                </div>
                <button class="remove-btn" id="remove-1" title="Remove player">✕</button>
            </div>
            <div class="stats-preview" id="stats-preview-1">
                Search and select a player to view their detailed statistics and performance metrics.
            </div>
        </div>

        <div class="vs-container">
            <div class="vs-circle">VS</div>
            <div class="vs-text">MATCHUP</div>
        </div>

        <!-- PLAYER 2 -->
        <div class="player-card">
            <h3 class="player-title">Search a Player</h3>
            <div class="search-container">
                <input type="text" class="search-input" placeholder="Type to search players..." data-side="2" id="search-2">
                <div class="search-icon">Search</div>
                <div class="search-results" id="search-results-2"></div>
            </div>
            <div class="selected-player" id="selected-player-2">
                <div class="player-avatar" id="player-avatar-2"></div>
                <div class="player-info">
                    <div class="player-name" id="player-name-2"></div>
                    <div class="player-stats" id="player-stats-2"></div>
                </div>
                <button class="remove-btn" id="remove-2" title="Remove player">✕</button>
            </div>
            <div class="stats-preview" id="stats-preview-2">
                Search and select a player to view their detailed statistics and performance metrics.
            </div>
        </div>
    </div>

    <div class="action-container">
        <button class="initiate-btn" id="initiate-btn" disabled>Initiate Matchup</button>
        <button class="clear-all-btn" id="clear-all-btn">Clear All</button>
    </div>
</section>

<!-- ====================== MATCHUP SECTION ====================== -->
<section id="matchup-section">
    <div class="player-comparison">
        <!-- PLAYER ONE -->
        <div class="player-card-m" id="card-left">
            <div class="player-header">
                <div class="player-avatar-m" id="avatar-left"></div>
                <div class="player-info-m">
                    <div class="player-name-m" id="name-left"></div>
                    <div class="player-title-m" id="title-left"></div>
                </div>
            </div>
            <ul class="player-stats-m" id="stats-left"></ul>
        </div>

        <!-- PLAYER TWO -->
        <div class="player-card-m" id="card-right">
            <div class="player-header">
                <div class="player-avatar-m" id="avatar-right"></div>
                <div class="player-info-m">
                    <div class="player-name-m" id="name-right"></div>
                    <div class="player-title-m" id="title-right"></div>
                </div>
            </div>
            <ul class="player-stats-m" id="stats-right"></ul>
        </div>
    </div>

    <div class="graph-section">
        <h2 class="graph-title">Performance Radar</h2>
        <div class="chart-container">
            <canvas id="comparisonChart"></canvas>
        </div>
    </div>

    <div class="ai-explanation">
        <h3 class="ai-title">AI Matchup Analysis</h3>
        <div class="ai-text" id="ai-text"></div>
    </div>

    <a href="#" class="back-button" id="back-btn">Back to Home</a>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
/* ====================== DATA CONFIG ====================== */
const STAT_FIELDS = ['PTS','AST','REB','STL','BLK','FG_PCT','FG3_PCT','FT_PCT'];
let selected = {1: null, 2: null};

/* ====================== HELPERS ====================== */
function normalizePct(v){
    const n = Number(v);
    if(!isFinite(n)) return 0;
    return n > 1 ? n / 100 : n; // accept 45 -> 0.45 and 0.45 -> 0.45
}

function safeNum(v, fallback = 0){
    const n = Number(v);
    return isFinite(n) ? n : fallback;
}

// Per-stat expected maxima (raw units). These are used to scale each metric
// to a 0-100 range for the radar chart so small-count stats are visible.
const STAT_MAX = {
    PTS: 40,      // points per game
    AST: 12,      // assists per game
    REB: 15,      // rebounds per game
    STL: 4,       // steals per game
    BLK: 4,       // blocks per game
    FG_PCT: 0.6,  // field goal percentage (0..1)
    FG3_PCT: 0.5, // 3P percentage (0..1)
    FT_PCT: 0.95  // free throw percentage (0..1)
};

function normalizeForChart(statKey, value){
    if (value === null || value === undefined) return 0;
    const max = STAT_MAX[statKey];
    if (!isFinite(max) || max <= 0) return 0;
    const v = Number(value);
    if (!isFinite(v)) return 0;
    // value is expected in raw units: percentages are 0..1,
    // others are per-game counts. Scale to 0..100 and clamp.
    const scaled = (v / max) * 100;
    if (!isFinite(scaled)) return 0;
    return Math.max(0, Math.min(100, scaled));
}

/* ====================== NBA PLAYER IMAGES ====================== */
const NBA_PLAYER_IMAGES = {
    "Aaron Gordon": "https://cdn.nba.com/headshots/nba/latest/260x190/203932.png",
    "Aaron Nesmith": "https://cdn.nba.com/headshots/nba/latest/260x190/1630174.png",
    "Alperen Sengun": "https://cdn.nba.com/headshots/nba/latest/260x190/1630578.png",
    "Alex Caruso": "https://cdn.nba.com/headshots/nba/latest/260x190/1627936.png",
    "Alex Sarr": "https://cdn.nba.com/headshots/nba/latest/260x190/1641738.png",
    "Amen Thompson": "https://cdn.nba.com/headshots/nba/latest/260x190/1641708.png",
    "Anfernee Simons": "https://cdn.nba.com/headshots/nba/latest/260x190/1629014.png",
    "Andrew Nembhard": "https://cdn.nba.com/headshots/nba/latest/260x190/1630612.png",
    "Anthony Black": "https://cdn.nba.com/headshots/nba/latest/260x190/1641715.png",
    "Anthony Davis": "https://cdn.nba.com/headshots/nba/latest/260x190/203076.png",
    "Anthony Edwards": "https://cdn.nba.com/headshots/nba/latest/260x190/1630162.png",
    "Austin Reaves": "https://cdn.nba.com/headshots/nba/latest/260x190/1630559.png",
    "Ausar Thompson": "https://cdn.nba.com/headshots/nba/latest/260x190/1641707.png",
    "Bam Adebayo": "https://cdn.nba.com/headshots/nba/latest/260x190/1628389.png",
    "Bennedict Mathurin": "https://cdn.nba.com/headshots/nba/latest/260x190/1631097.png",
    "Bilal Coulibaly": "https://cdn.nba.com/headshots/nba/latest/260x190/1641737.png",
    "Bradley Beal": "https://cdn.nba.com/headshots/nba/latest/260x190/203078.png",
    "Brandon Ingram": "https://cdn.nba.com/headshots/nba/latest/260x190/1627742.png",
    "Brandon Miller": "https://cdn.nba.com/headshots/nba/latest/260x190/1641739.png",
    "Cam Johnson": "https://cdn.nba.com/headshots/nba/latest/260x190/1629661.png",
    "Cade Cunningham": "https://cdn.nba.com/headshots/nba/latest/260x190/1630595.png",
    "Cason Wallace": "https://cdn.nba.com/headshots/nba/latest/260x190/1641730.png",
    "Chet Holmgren": "https://cdn.nba.com/headshots/nba/latest/260x190/1631096.png",
    "Christian Braun": "https://cdn.nba.com/headshots/nba/latest/260x190/1631128.png",
    "CJ McCollum": "https://cdn.nba.com/headshots/nba/latest/260x190/203468.png",
    "Coby White": "https://cdn.nba.com/headshots/nba/latest/260x190/1629632.png",
    "Cooper Flagg": "https://cdn.nba.com/headshots/nba/latest/260x190/1641735.png",
    "D'Angelo Russell": "https://cdn.nba.com/headshots/nba/latest/260x190/1626156.png",
    "Damian Lillard": "https://cdn.nba.com/headshots/nba/latest/260x190/203081.png",
    "Darius Garland": "https://cdn.nba.com/headshots/nba/latest/260x190/1629636.png",
    "De'Aaron Fox": "https://cdn.nba.com/headshots/nba/latest/260x190/1628368.png",
    "De'Andre Hunter": "https://cdn.nba.com/headshots/nba/latest/260x190/1629631.png",
    "DeAndre Ayton": "https://cdn.nba.com/headshots/nba/latest/260x190/1629028.png",
    "Dejounte Murray": "https://cdn.nba.com/headshots/nba/latest/260x190/1627749.png",
    "Deni Avdija": "https://cdn.nba.com/headshots/nba/latest/260x190/1630166.png",
    "Dereck Lively II": "https://cdn.nba.com/headshots/nba/latest/260x190/1641734.png",
    "Derrick White": "https://cdn.nba.com/headshots/nba/latest/260x190/1628401.png",
    "Desmond Bane": "https://cdn.nba.com/headshots/nba/latest/260x190/1630217.png",
    "Devin Booker": "https://cdn.nba.com/headshots/nba/latest/260x190/1626164.png",
    "Devin Vassell": "https://cdn.nba.com/headshots/nba/latest/260x190/1630170.png",
    "Dillon Brooks": "https://cdn.nba.com/headshots/nba/latest/260x190/1628415.png",
    "Dorian Finney-Smith": "https://cdn.nba.com/headshots/nba/latest/260x190/1627827.png",
    "Donovan Clingan": "https://cdn.nba.com/headshots/nba/latest/260x190/1641740.png",
    "Donovan Mitchell": "https://cdn.nba.com/headshots/nba/latest/260x190/1628378.png",
    "Dyson Daniels": "https://cdn.nba.com/headshots/nba/latest/260x190/1630700.png",
    "Evan Mobley": "https://cdn.nba.com/headshots/nba/latest/260x190/1630596.png",
    "Fred VanVleet": "https://cdn.nba.com/headshots/nba/latest/260x190/1627832.png",
    "Franz Wagner": "https://cdn.nba.com/headshots/nba/latest/260x190/1630532.png",
    "Giannis Antetokounmpo": "https://cdn.nba.com/headshots/nba/latest/260x190/203507.png",
    "GG Jackson": "https://cdn.nba.com/headshots/nba/latest/260x190/1641736.png",
    "Gradey Dick": "https://cdn.nba.com/headshots/nba/latest/260x190/1641733.png",
    "Herb Jones": "https://cdn.nba.com/headshots/nba/latest/260x190/1630529.png",
    "Isaiah Hartenstein": "https://cdn.nba.com/headshots/nba/latest/260x190/1628392.png",
    "Isaiah Stewart": "https://cdn.nba.com/headshots/nba/latest/260x190/1630191.png",
    "Ivica Zubac": "https://cdn.nba.com/headshots/nba/latest/260x190/1627826.png",
    "Jabari Smith Jr.": "https://cdn.nba.com/headshots/nba/latest/260x190/1631095.png",
    "Jaden Ivey": "https://cdn.nba.com/headshots/nba/latest/260x190/1631093.png",
    "Jaden McDaniels": "https://cdn.nba.com/headshots/nba/latest/260x190/1630183.png",
    "Jakob Poeltl": "https://cdn.nba.com/headshots/nba/latest/260x190/1627751.png",
    "Jalen Brunson": "https://cdn.nba.com/headshots/nba/latest/260x190/1628973.png",
    "Jalen Duren": "https://cdn.nba.com/headshots/nba/latest/260x190/1631105.png",
    "Jalen Green": "https://cdn.nba.com/headshots/nba/latest/260x190/1630224.png",
    "Jalen Johnson": "https://cdn.nba.com/headshots/nba/latest/260x190/1630552.png",
    "Jalen Suggs": "https://cdn.nba.com/headshots/nba/latest/260x190/1630591.png",
    "Jalen Williams": "https://cdn.nba.com/headshots/nba/latest/260x190/1631114.png",
    "James Harden": "https://cdn.nba.com/headshots/nba/latest/260x190/201935.png",
    "Jared McCain": "https://cdn.nba.com/headshots/nba/latest/260x190/1641741.png",
    "Jaren Jackson Jr.": "https://cdn.nba.com/headshots/nba/latest/260x190/1628991.png",
    "Jarrett Allen": "https://cdn.nba.com/headshots/nba/latest/260x190/1628386.png",
    "Jayson Tatum": "https://cdn.nba.com/headshots/nba/latest/260x190/1628369.png",
    "Jaylen Brown": "https://cdn.nba.com/headshots/nba/latest/260x190/1627759.png",
    "Jaylen Wells": "https://cdn.nba.com/headshots/nba/latest/260x190/1641742.png",
    "Jeremy Sochan": "https://cdn.nba.com/headshots/nba/latest/260x190/1631110.png",
    "Jimmy Butler": "https://cdn.nba.com/headshots/nba/latest/260x190/202710.png",
    "Joel Embiid": "https://cdn.nba.com/headshots/nba/latest/260x190/203954.png",
    "Jonas Valanciunas": "https://cdn.nba.com/headshots/nba/latest/260x190/202685.png",
    "Jonathan Kuminga": "https://cdn.nba.com/headshots/nba/latest/260x190/1630228.png",
    "Jordan Poole": "https://cdn.nba.com/headshots/nba/latest/260x190/1629673.png",
    "Josh Giddey": "https://cdn.nba.com/headshots/nba/latest/260x190/1630581.png",
    "Josh Hart": "https://cdn.nba.com/headshots/nba/latest/260x190/1628404.png",
    "Jrue Holiday": "https://cdn.nba.com/headshots/nba/latest/260x190/201950.png",
    "Julius Randle": "https://cdn.nba.com/headshots/nba/latest/260x190/203944.png",
    "Karl-Anthony Towns": "https://cdn.nba.com/headshots/nba/latest/260x190/1626157.png",
    "Kawhi Leonard": "https://cdn.nba.com/headshots/nba/latest/260x190/202695.png",
    "Kevin Durant": "https://cdn.nba.com/headshots/nba/latest/260x190/201142.png",
    "Kristaps Porzingis": "https://cdn.nba.com/headshots/nba/latest/260x190/204001.png",
    "Kyrie Irving": "https://cdn.nba.com/headshots/nba/latest/260x190/202681.png",
    "LaMelo Ball": "https://cdn.nba.com/headshots/nba/latest/260x190/1630163.png",
    "Lauri Markkanen": "https://cdn.nba.com/headshots/nba/latest/260x190/1628374.png",
    "LeBron James": "https://cdn.nba.com/headshots/nba/latest/260x190/2544.png",
    "Lonzo Ball": "https://cdn.nba.com/headshots/nba/latest/260x190/1628366.png",
    "Lu Dort": "https://cdn.nba.com/headshots/nba/latest/260x190/1629652.png",
    "Luka Doncic": "https://cdn.nba.com/headshots/nba/latest/260x190/1629029.png",
    "Mark Williams": "https://cdn.nba.com/headshots/nba/latest/260x190/1631109.png",
    "Matas Buzelis": "https://cdn.nba.com/headshots/nba/latest/260x190/1641743.png",
    "Michael Porter Jr.": "https://cdn.nba.com/headshots/nba/latest/260x190/1629008.png",
    "Mikal Bridges": "https://cdn.nba.com/headshots/nba/latest/260x190/1628969.png",
    "Mitchell Robinson": "https://cdn.nba.com/headshots/nba/latest/260x190/1629011.png",
    "Myles Turner": "https://cdn.nba.com/headshots/nba/latest/260x190/1626167.png",
    "Naz Reid": "https://cdn.nba.com/headshots/nba/latest/260x190/1629675.png",
    "Nickeil Alexander-Walker": "https://cdn.nba.com/headshots/nba/latest/260x190/1629638.png",
    "Nikola Jokic": "https://cdn.nba.com/headshots/nba/latest/260x190/203999.png",
    "Nikola Vucevic": "https://cdn.nba.com/headshots/nba/latest/260x190/202696.png",
    "Norm Powell": "https://cdn.nba.com/headshots/nba/latest/260x190/1626181.png",
    "OG Anunoby": "https://cdn.nba.com/headshots/nba/latest/260x190/1628384.png",
    "Pascal Siakam": "https://cdn.nba.com/headshots/nba/latest/260x190/1627783.png",
    "Paul George": "https://cdn.nba.com/headshots/nba/latest/260x190/202331.png",
    "Payton Pritchard": "https://cdn.nba.com/headshots/nba/latest/260x190/1630202.png",
    "P.J. Washington": "https://cdn.nba.com/headshots/nba/latest/260x190/1629023.png",
    "Reed Sheppard": "https://cdn.nba.com/headshots/nba/latest/260x190/1641744.png",
    "RJ Barrett": "https://cdn.nba.com/headshots/nba/latest/260x190/1629628.png",
    "Rob Dillingham": "https://cdn.nba.com/headshots/nba/latest/260x190/1641745.png",
    "Rudy Gobert": "https://cdn.nba.com/headshots/nba/latest/260x190/203497.png",
    "Santi Aldama": "https://cdn.nba.com/headshots/nba/latest/260x190/1630583.png",
    "Scottie Barnes": "https://cdn.nba.com/headshots/nba/latest/260x190/1630567.png",
    "Shai Gilgeous-Alexander": "https://cdn.nba.com/headshots/nba/latest/260x190/1628983.png",
    "Spencer Dinwiddie": "https://cdn.nba.com/headshots/nba/latest/260x190/203915.png",
    "Stephon Castle": "https://cdn.nba.com/headshots/nba/latest/260x190/1641746.png",
    "Stephen Curry": "https://cdn.nba.com/headshots/nba/latest/260x190/201939.png",
    "T.J. McConnell": "https://cdn.nba.com/headshots/nba/latest/260x190/204456.png",
    "Tari Eason": "https://cdn.nba.com/headshots/nba/latest/260x190/1631106.png",
    "Toumani Camara": "https://cdn.nba.com/headshots/nba/latest/260x190/1641731.png",
    "Trae Young": "https://cdn.nba.com/headshots/nba/latest/260x190/1629027.png",
    "Trey Murphy III": "https://cdn.nba.com/headshots/nba/latest/260x190/1630530.png",
    "Tyler Herro": "https://cdn.nba.com/headshots/nba/latest/260x190/1629639.png",
    "Tyrese Haliburton": "https://cdn.nba.com/headshots/nba/latest/260x190/1630169.png",
    "Tyrese Maxey": "https://cdn.nba.com/headshots/nba/latest/260x190/1630178.png",
    "Victor Wembanyama": "https://cdn.nba.com/headshots/nba/latest/260x190/1641705.png",
    "Walker Kessler": "https://cdn.nba.com/headshots/nba/latest/260x190/1631117.png",
    "Yves Missi": "https://cdn.nba.com/headshots/nba/latest/260x190/1641747.png",
    "Zaccharie Risacher": "https://cdn.nba.com/headshots/nba/latest/260x190/1641748.png",
    "Zach LaVine": "https://cdn.nba.com/headshots/nba/latest/260x190/203897.png",
    "Zion Williamson": "https://cdn.nba.com/headshots/nba/latest/260x190/1629627.png"
};

/* ====================== PRESELECTED PLAYER FUNCTIONALITY ====================== */
document.addEventListener('DOMContentLoaded', function() {
    const preselected = sessionStorage.getItem('preselectedPlayer');
    if (preselected) {
        const player = JSON.parse(preselected);
        console.log('Preselected player from players page:', player);
        
        const searchInput1 = document.getElementById('search-1');
        if (searchInput1) {
            searchInput1.value = player.name;
            searchInput1.focus();
            
            setTimeout(() => {
                alert(`Player "${player.name}" was preselected from the Players page. Please search and select them to complete the matchup.`);
            }, 500);
        }
        
        sessionStorage.removeItem('preselectedPlayer');
    }
});

/* ====================== API SEARCH ====================== */
async function searchApi(q){
    try {
        const res = await fetch(`search_players.php?q=${encodeURIComponent(q)}`);
        if(!res.ok) return [];
        return await res.json();
    } catch (e) {
        console.error('Search error:', e);
        return [];
    }
}

/* ====================== SEARCH LOGIC ====================== */
[1, 2].forEach(side => {
    const inp = document.getElementById(`search-${side}`);
    const results = document.getElementById(`search-results-${side}`);
    let timer = null;

    inp.addEventListener('input', () => {
        const term = inp.value.trim();
        results.innerHTML = '';
        if(term.length < 2) { results.style.display='none'; return; }
        
        if(timer) clearTimeout(timer);
        timer = setTimeout(async () => {
            const rows = await searchApi(term);
            results.innerHTML = '';
            if(!rows || !rows.length) {
                results.innerHTML = '<div class="search-result-item">No players found</div>';
            } else {
                rows.forEach(r => {
                    const name = r.PLAYER_NAME && r.PLAYER_NAME.trim() ? r.PLAYER_NAME : `Player ${r.PLAYER_ID}`;
                    const div = document.createElement('div');
                    div.className = 'search-result-item';
                    
                    const playerImage = NBA_PLAYER_IMAGES[name] || null;
                    const initials = (name.match(/\b\w/g)||[]).slice(0,2).join('').toUpperCase();
                    
                    div.innerHTML = `
                        <div class="search-result-avatar" style="${playerImage ? `background-image:url('${playerImage}'); background-size:cover;` : ''}">
                            ${playerImage ? '' : initials}
                        </div>
                        <div>
                            <strong>${name}</strong><br>
                            <small>ID: ${r.PLAYER_ID}</small>
                        </div>
                    `;
                    
                    div.onclick = () => {
                        selectPlayer(side, r);
                        results.style.display='none';
                        inp.value = '';
                    };
                    results.appendChild(div);
                });
            }
            results.style.display = 'block';
        }, 200);
    });

    document.addEventListener('click', e => {
        if (!inp.contains(e.target) && !results.contains(e.target)) results.style.display='none';
    });
});

function selectPlayer(side, row){
    const gp = Number(row.GP) || 1;
    const obj = {
        PLAYER_ID: Number(row.PLAYER_ID),
        PLAYER_NAME: row.PLAYER_NAME || `Player ${row.PLAYER_ID}`,
        GP: gp,
        raw: {}, avg: {}
    };

    obj.raw.PTS = Number(row.PTS) || 0;
    obj.raw.AST = Number(row.AST) || 0;
    obj.raw.REB = Number(row.REB) || 0;
    obj.raw.STL = Number(row.STL) || 0;
    obj.raw.BLK = Number(row.BLK) || 0;
    obj.raw.FG_PCT = normalizePct(row.FG_PCT);
    obj.raw.FG3_PCT = normalizePct(row.FG3_PCT);
    obj.raw.FT_PCT = normalizePct(row.FT_PCT);

    obj.avg.PTS = safeNum(obj.raw.PTS / gp);
    obj.avg.AST = safeNum(obj.raw.AST / gp);
    obj.avg.REB = safeNum(obj.raw.REB / gp);
    obj.avg.STL = safeNum(obj.raw.STL / gp);
    obj.avg.BLK = safeNum(obj.raw.BLK / gp);
    obj.avg.FG_PCT = safeNum(obj.raw.FG_PCT);
    obj.avg.FG3_PCT = safeNum(obj.raw.FG3_PCT);
    obj.avg.FT_PCT = safeNum(obj.raw.FT_PCT);

    selected[side] = obj;
    const initials = (obj.PLAYER_NAME.match(/\b\w/g)||[]).slice(0,2).join('').toUpperCase();
    
    const playerAvatar = document.getElementById(`player-avatar-${side}`);
    const playerImage = NBA_PLAYER_IMAGES[obj.PLAYER_NAME] || null;
    if (playerImage) {
        playerAvatar.style.backgroundImage = `url('${playerImage}')`;
        playerAvatar.style.backgroundSize = 'cover';
        playerAvatar.textContent = '';
    } else {
        playerAvatar.style.backgroundImage = '';
        playerAvatar.textContent = initials;
    }
    
    document.getElementById(`player-name-${side}`).textContent = obj.PLAYER_NAME;

    const statsEl = document.getElementById(`player-stats-${side}`);
    if (statsEl) {
        statsEl.textContent = '';
        statsEl.style.display = 'none';
    }

    document.getElementById(`selected-player-${side}`).style.display = 'flex';
    document.getElementById(`stats-preview-${side}`).style.display = 'none';

    const inp = document.getElementById(`search-${side}`);
    if (inp) inp.value = '';
    const results = document.getElementById(`search-results-${side}`);
    if (results) results.style.display = 'none';

    checkReady();
}

function checkReady(){
    const btn = document.getElementById('initiate-btn');
    const ready = selected[1] && selected[2];
    const differentPlayers = ready && (selected[1].PLAYER_ID !== selected[2].PLAYER_ID);
    btn.disabled = !(ready && differentPlayers);
}

/* ====================== INITIATE MATCHUP ====================== */
function showMatchup(){
    if (!selected[1] || !selected[2]) {
        console.warn('Initiate blocked: two players not selected.');
        return;
    }
    if ((selected[1].PLAYER_ID || selected[1].PLAYER_ID === 0) &&
        (selected[2].PLAYER_ID || selected[2].PLAYER_ID === 0) &&
        selected[1].PLAYER_ID === selected[2].PLAYER_ID) {
        alert('Please select two different players for the matchup');
        return;
    }

    populateMatchup();

    const home = document.getElementById('home-section');
    const matchup = document.getElementById('matchup-section');
    if (home) home.style.display = 'none';
    if (matchup) matchup.style.display = 'block';
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

(function attachControls(){
    const initBtn = document.getElementById('initiate-btn');
    const rm1 = document.getElementById('remove-1');
    const rm2 = document.getElementById('remove-2');
    const clearBtn = document.getElementById('clear-all-btn');
    const backBtn = document.getElementById('back-btn');

    if (initBtn) {
        initBtn.addEventListener('click', (e) => {
            e.preventDefault();
            if (initBtn.disabled) return;
            showMatchup();
        });
    }

    if (rm1) rm1.addEventListener('click', e => { e.preventDefault(); removePlayer(1); });
    if (rm2) rm2.addEventListener('click', e => { e.preventDefault(); removePlayer(2); });
    if (clearBtn) clearBtn.addEventListener('click', e => { e.preventDefault(); clearAllPlayers(); });

    if (backBtn) backBtn.addEventListener('click', e => {
        e.preventDefault();
        document.getElementById('matchup-section').style.display = 'none';
        document.getElementById('home-section').style.display = 'block';
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
})();

/* ====================== POPULATE MATCHUP VIEW ====================== */
function populateMatchup(){
    const left = selected[1], right = selected[2];

    // LEFT CARD
    const leftImage = NBA_PLAYER_IMAGES[left.PLAYER_NAME] || null;
    if (leftImage) {
        document.getElementById('avatar-left').style.backgroundImage = `url('${leftImage}')`;
    } else {
        document.getElementById('avatar-left').style.backgroundImage = '';
    }
    document.getElementById('name-left').textContent = left.PLAYER_NAME;
    document.getElementById('title-left').textContent = `ID: ${left.PLAYER_ID}`;
    fillStats('left', left.avg, true);

    // RIGHT CARD
    const rightImage = NBA_PLAYER_IMAGES[right.PLAYER_NAME] || null;
    if (rightImage) {
        document.getElementById('avatar-right').style.backgroundImage = `url('${rightImage}')`;
    } else {
        document.getElementById('avatar-right').style.backgroundImage = '';
    }
    document.getElementById('name-right').textContent = right.PLAYER_NAME;
    document.getElementById('title-right').textContent = `ID: ${right.PLAYER_ID}`;
    fillStats('right', right.avg, true);

    // AI ANALYSIS TEXT
    generateAIAnalysis(left.avg, right.avg);

    // CHART
    const labels = ['PPG','APG','RPG','SPG','BPG','FG%','3P%','FT%'];
    // Normalize each stat to a 0-100 scale so smaller-count stats are visible
    const leftData = [
        normalizeForChart('PTS', left.avg.PTS),
        normalizeForChart('AST', left.avg.AST),
        normalizeForChart('REB', left.avg.REB),
        normalizeForChart('STL', left.avg.STL),
        normalizeForChart('BLK', left.avg.BLK),
        normalizeForChart('FG_PCT', left.avg.FG_PCT),
        normalizeForChart('FG3_PCT', left.avg.FG3_PCT),
        normalizeForChart('FT_PCT', left.avg.FT_PCT)
    ];
    const rightData = [
        normalizeForChart('PTS', right.avg.PTS),
        normalizeForChart('AST', right.avg.AST),
        normalizeForChart('REB', right.avg.REB),
        normalizeForChart('STL', right.avg.STL),
        normalizeForChart('BLK', right.avg.BLK),
        normalizeForChart('FG_PCT', right.avg.FG_PCT),
        normalizeForChart('FG3_PCT', right.avg.FG3_PCT),
        normalizeForChart('FT_PCT', right.avg.FT_PCT)
    ];

    // chart data are normalized to 0-100; pick a max slightly above observed
    const allVals = leftData.concat(rightData).map(v => Number(v)).filter(v => isFinite(v));
    const maxVal = allVals.length ? Math.max(...allVals) * 1.1 : 100;

    if(window.myChart) window.myChart.destroy();
    const ctx = document.getElementById('comparisonChart').getContext('2d');
    window.myChart = new Chart(ctx, {
        type: 'radar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: left.PLAYER_NAME,
                    data: leftData,
                    borderColor: '#ff4500',
                    backgroundColor: 'rgba(255,69,0,0.08)',
                    borderWidth: 3,
                    pointBackgroundColor: '#ff4500',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    fill: true,
                    tension: 0.4
                },
                {
                    label: right.PLAYER_NAME,
                    data: rightData,
                    borderColor: '#00e0ff',
                    backgroundColor: 'rgba(0,224,255,0.08)',
                    borderWidth: 3,
                    pointBackgroundColor: '#00e0ff',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    fill: true,
                    tension: 0.4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        color: '#fff',
                        font: { size: 16, weight: '600' },
                        usePointStyle: true,
                        pointStyle: 'rectRounded',
                        padding: 20
                    }
                },
                tooltip: { enabled: false }
            },
            scales: {
                r: {
                    angleLines: { color: '#555', lineWidth: 1.5 },
                    grid: { color: '#444', lineWidth: 1.2 },
                    pointLabels: {
                        color: '#ccc',
                        font: { size: 13, weight: '600' },
                        padding: 22
                    },
                    ticks: { display: false },
                    suggestedMin: 0,
                    suggestedMax: maxVal
                }
            },
            elements: { line: { tension: 0.4 } }
        }
    });
}

/* ====================== FILL HELPERS ====================== */
function fillStats(side, stats, isAvg = true) {
    const ul = document.getElementById(`stats-${side}`);
    if(!ul) return;
    ul.innerHTML = '';
    const items = [
        ['PTS', stats.PTS],
        ['AST', stats.AST],
        ['REB', stats.REB],
        ['STL', stats.STL],
        ['BLK', stats.BLK],
        ['FG %', stats.FG_PCT],
        ['3P %', stats.FG3_PCT],
        ['FT %', stats.FT_PCT]
    ];

    items.forEach(([lbl, val]) => {
        const li = document.createElement('li');
        const labelSpan = document.createElement('span');
        labelSpan.className = 'stat-label';
        labelSpan.textContent = lbl + ':';

        const valueSpan = document.createElement('span');
        valueSpan.className = 'stat-value';

        if (lbl.includes('%')) {
            const n = safeNum(val, null);
            valueSpan.textContent = (n === null) ? '—' : ( (Number.isFinite(n) ? (n * 100).toFixed(1) + '%' : '—') );
        } else {
            const n = safeNum(val, null);
            valueSpan.textContent = (n === null) ? '—' : (isAvg ? Number(n).toFixed(1) : String(n));
        }

        li.appendChild(labelSpan);
        li.appendChild(document.createTextNode(' '));
        li.appendChild(valueSpan);
        ul.appendChild(li);
    });
}

function generateAIAnalysis(p1, p2) {
    const s1 = p1, s2 = p2;
    const lines = [];
    const pct = v => (v * 100).toFixed(1) + '%';

    lines.push(`<strong>${selected[1].PLAYER_NAME}</strong> vs <strong>${selected[2].PLAYER_NAME}</strong><br>`);

    lines.push(`PPG: <strong>${s1.PTS.toFixed(1)}</strong> vs <strong>${s2.PTS.toFixed(1)}</strong> → <strong>${s1.PTS > s2.PTS ? selected[1].PLAYER_NAME : selected[2].PLAYER_NAME} wins</strong><br>`);
    lines.push(`APG: <strong>${s1.AST.toFixed(1)}</strong> vs <strong>${s2.AST.toFixed(1)}</strong> → <strong>${s1.AST > s2.AST ? selected[1].PLAYER_NAME : selected[2].PLAYER_NAME} wins</strong><br>`);
    lines.push(`RPG: <strong>${s1.REB.toFixed(1)}</strong> vs <strong>${s2.REB.toFixed(1)}</strong> → <strong>${s1.REB > s2.REB ? selected[1].PLAYER_NAME : selected[2].PLAYER_NAME} wins</strong><br>`);
    lines.push(`Defense (SPG+BPG): <strong>${(s1.STL + s1.BLK).toFixed(1)}</strong> vs <strong>${(s2.STL + s2.BLK).toFixed(1)}</strong> → <strong>${(s1.STL + s1.BLK) > (s2.STL + s2.BLK) ? selected[1].PLAYER_NAME : selected[2].PLAYER_NAME} wins</strong><br><br>`);

    lines.push(`<strong>Efficiency</strong><br>`);
    lines.push(`FG%: <strong>${pct(s1.FG_PCT)}</strong> vs <strong>${pct(s2.FG_PCT)}</strong> → <strong>${s1.FG_PCT > s2.FG_PCT ? selected[1].PLAYER_NAME : selected[2].PLAYER_NAME} wins</strong><br>`);
    lines.push(`3P%: <strong>${pct(s1.FG3_PCT)}</strong> vs <strong>${pct(s2.FG3_PCT)}</strong> → <strong>${s1.FG3_PCT > s2.FG3_PCT ? selected[1].PLAYER_NAME : selected[2].PLAYER_NAME} wins</strong><br>`);
    lines.push(`FT%: <strong>${pct(s1.FT_PCT)}</strong> vs <strong>${pct(s2.FT_PCT)}</strong> → <strong>${s1.FT_PCT > s2.FT_PCT ? selected[1].PLAYER_NAME : selected[2].PLAYER_NAME} wins</strong><br><br>`);

    const p1Score = s1.PTS*0.4 + s1.AST*0.2 + s1.REB*0.2 + (s1.STL + s1.BLK)*0.1 + (s1.FG_PCT + s1.FG3_PCT + s1.FT_PCT)*10*0.1;
    const p2Score = s2.PTS*0.4 + s2.AST*0.2 + s2.REB*0.2 + (s2.STL + s2.BLK)*0.1 + (s2.FG_PCT + s2.FG3_PCT + s2.FT_PCT)*10*0.1;
    const winner = p1Score > p2Score ? selected[1] : selected[2];
    const margin = Math.abs(p1Score - p2Score).toFixed(1);

    lines.push(`<strong class="verdict">Verdict:</strong> <strong>${winner.PLAYER_NAME} wins</strong> by <strong>${margin}</strong> impact points.<br>`);
    lines.push(`<em>Per-game averages. Radar shows relative dominance.</em>`);

    document.getElementById('ai-text').innerHTML = lines.join('');
}

/* ====================== REMOVE PLAYER ====================== */
function removePlayer(side){
    selected[side] = null;
    document.getElementById(`selected-player-${side}`).style.display = 'none';
    document.getElementById(`stats-preview-${side}`).style.display = 'block';
    document.getElementById(`search-${side}`).value = '';
    document.getElementById(`search-results-${side}`).style.display = 'none';
    // clear avatar and name/stats so state doesn't persist visually
    const avatar = document.getElementById(`player-avatar-${side}`);
    if (avatar) {
        avatar.style.backgroundImage = '';
        avatar.textContent = '';
    }
    const nameEl = document.getElementById(`player-name-${side}`);
    if (nameEl) nameEl.textContent = '';
    const statsEl = document.getElementById(`player-stats-${side}`);
    if (statsEl) statsEl.innerHTML = '';
    checkReady();
}

/* ====================== CLEAR ALL PLAYERS ====================== */
function clearAllPlayers(){
    selected[1] = null;
    selected[2] = null;
    document.getElementById('selected-player-1').style.display = 'none';
    document.getElementById('selected-player-2').style.display = 'none';
    document.getElementById('stats-preview-1').style.display = 'block';
    document.getElementById('stats-preview-2').style.display = 'block';
    document.getElementById('search-1').value = '';
    document.getElementById('search-2').value = '';
    document.getElementById('search-results-1').style.display = 'none';
    document.getElementById('search-results-2').style.display = 'none';
    checkReady();
}

/* ====================== ATTACH EVENT LISTENERS ====================== */
checkReady();

document.getElementById('homeLink').addEventListener('click', e => {
    e.preventDefault();
    document.getElementById('matchup-section').style.display = 'none';
    document.getElementById('home-section').style.display = 'flex';
    document.getElementById('home-section').style.flexDirection = 'column';
    clearAllPlayers();
    window.scrollTo({ top: 0, behavior: 'smooth' });
});
</script>

</body>
</html>