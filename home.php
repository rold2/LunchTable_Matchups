<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LunchTable Matchups - Home</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* ────────────────────── GLOBAL STYLES ────────────────────── */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: #000;
            color: #f5f5f5;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-image: url('https://images.unsplash.com/photo-1546519638-68e109498ffc?ixlib=rb-4.0.3&auto=format&fit=crop&w=1790&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            position: relative;
            overflow-x: hidden;
        }
        
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            z-index: -1;
        }
        
        /* ────────────────────── HEADER ────────────────────── */
        header {
            background: #ff6b35;
            height: 80px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.5);
            position: relative;
            z-index: 100;
        }
        
        .header-content {
            position: absolute;
            top: 50%;
            left: 20px;
            transform: translateY(-50%);
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .logo {
            width: 48px;
            height: 48px;
            position: relative;
            flex-shrink: 0;
        }
        
        .lunchbox {
            width: 40px;
            height: 32px;
            background: #8B4513;
            border-radius: 5px;
            position: absolute;
            top: 8px;
            left: 4px;
            box-shadow: 0 3px 5px rgba(0, 0, 0, 0.3);
        }
        
        .lunchbox-lid {
            width: 44px;
            height: 9px;
            background: #A0522D;
            border-radius: 5px 5px 0 0;
            position: absolute;
            top: 4px;
            left: 2px;
        }
        
        .orange-fruit {
            width: 21px;
            height: 21px;
            background: #ff6b35;
            border-radius: 50%;
            position: absolute;
            top: 15px;
            left: 11px;
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
            width: 25px;
            height: 25px;
            background: #ff6b35;
            border-radius: 50%;
            position: absolute;
            top: 19px;
            left: 21px;
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
        
        .page-title {
            font-size: 1.9rem;
            font-weight: 700;
            color: #fff;
            letter-spacing: 0.5px;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.4);
        }
        
        /* ────────────────────── NAVIGATION TABS ────────────────────── */
        .nav-tabs {
            position: absolute;
            top: 50%;
            right: 20px;
            transform: translateY(-50%);
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .nav-tab {
            display: flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.15);
            padding: 10px 18px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.25s ease;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            text-decoration: none;
            color: #fff;
            font-weight: 600;
        }
        
        .nav-tab:hover {
            background: rgba(255, 107, 53, 0.3);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 107, 53, 0.4);
            border-color: rgba(255, 107, 53, 0.6);
        }
        
        .nav-tab-icon {
            font-size: 1.1rem;
        }
        
        .nav-tab-text {
            font-size: 1rem;
            letter-spacing: 0.4px;
        }
        
        /* ────────────────────── HERO SECTION ────────────────────── */
        .hero {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 40px 20px;
            position: relative;
        }
        
        .hero-content {
            max-width: 900px;
            margin: 0 auto;
            position: relative;
            z-index: 2;
        }
        
        .hero-title {
            font-size: 4rem;
            font-weight: 800;
            margin-bottom: 20px;
            color: #fff;
            text-shadow: 0 4px 12px rgba(0, 0, 0, 0.5);
            line-height: 1.1;
        }
        
        .hero-title span {
            color: #ff6b35;
        }
        
        .hero-subtitle {
            font-size: 1.4rem;
            margin-bottom: 40px;
            color: #f5f5f5;
            line-height: 1.6;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
            background: rgba(0, 0, 0, 0.6);
            padding: 20px 25px;
            border-radius: 12px;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 107, 53, 0.3);
        }
        
        /* ────────────────────── FEATURE CARDS ────────────────────── */
        .features {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-top: 50px;
            flex-wrap: wrap;
        }
        
        .feature-card {
            background: rgba(30, 30, 30, 0.85);
            border-radius: 12px;
            padding: 30px 25px;
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
            border: 1px solid rgba(255, 107, 53, 0.3);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(5px);
            width: 280px;
        }
        
        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.6);
            border-color: rgba(255, 107, 53, 0.6);
        }
        
        .feature-icon {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: #ff6b35;
        }
        
        .feature-title {
            font-size: 1.4rem;
            margin-bottom: 15px;
            color: #f5f5f5;
            font-weight: 600;
        }
        
        .feature-description {
            font-size: 0.95rem;
            color: #ccc;
            line-height: 1.5;
        }
        
        /* ────────────────────── CTA BUTTONS ────────────────────── */
        .cta-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 50px;
            flex-wrap: wrap;
        }
        
        .cta-btn {
            background: #ff6b35;
            color: #fff;
            border: none;
            padding: 16px 40px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(255, 107, 53, 0.5);
            letter-spacing: 0.5px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }
        
        .cta-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(255, 107, 53, 0.7);
            background: #ff5a20;
            color: #fff;
        }
        
        .cta-btn.secondary {
            background: rgba(255, 107, 53, 0.2);
            color: #ff6b35;
            border: 1px solid rgba(255, 107, 53, 0.4);
        }
        
        .cta-btn.secondary:hover {
            background: rgba(255, 107, 53, 0.4);
            border-color: rgba(255, 107, 53, 0.7);
            box-shadow: 0 4px 15px rgba(255, 107, 53, 0.3);
        }
        
        /* ────────────────────── ANIMATED BACKGROUND ELEMENTS ────────────────────── */
        .floating-elements {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
        }
        
        .floating-element {
            position: absolute;
            background: rgba(255, 107, 53, 0.1);
            border-radius: 50%;
            animation: float 15s infinite linear;
        }
        
        @keyframes float {
            0% {
                transform: translateY(0) rotate(0deg);
            }
            50% {
                transform: translateY(-20px) rotate(180deg);
            }
            100% {
                transform: translateY(0) rotate(360deg);
            }
        }
        
        /* ────────────────────── FOOTER ────────────────────── */
        footer {
            background: rgba(20, 20, 20, 0.9);
            padding: 20px;
            text-align: center;
            margin-top: auto;
            border-top: 1px solid rgba(255, 107, 53, 0.2);
        }
        
        .footer-content {
            max-width: 1000px;
            margin: 0 auto;
        }
        
        .copyright {
            color: #aaa;
            font-size: 0.9rem;
        }
        
        /* ────────────────────── RESPONSIVE ────────────────────── */
        @media (max-width: 768px) {
            header {
                height: 70px;
            }
            
            .header-content {
                left: 15px;
                gap: 10px;
            }
            
            .page-title {
                font-size: 1.6rem;
            }
            
            .logo {
                width: 42px;
                height: 42px;
            }
            
            .lunchbox {
                width: 36px;
                height: 28px;
                top: 7px;
                left: 3px;
            }
            
            .lunchbox-lid {
                width: 40px;
                top: 3px;
                left: 1.5px;
            }
            
            .orange-fruit {
                width: 18px;
                height: 18px;
                top: 13px;
                left: 10px;
            }
            
            .basketball {
                width: 22px;
                height: 22px;
                top: 17px;
                left: 18px;
            }
            
            .nav-tabs {
                right: 15px;
                gap: 10px;
            }
            
            .nav-tab {
                padding: 8px 14px;
                gap: 6px;
            }
            
            .nav-tab-text {
                font-size: 0.9rem;
            }
            
            .hero-title {
                font-size: 2.8rem;
            }
            
            .hero-subtitle {
                font-size: 1.1rem;
                padding: 15px 20px;
            }
            
            .features {
                gap: 20px;
            }
            
            .feature-card {
                width: 100%;
                max-width: 300px;
            }
            
            .cta-buttons {
                flex-direction: column;
                align-items: center;
            }
            
            .cta-btn {
                width: 100%;
                max-width: 280px;
                justify-content: center;
            }
        }
    </style>
</head>
<body>

<!-- ====================== HEADER ====================== -->
<header>
    <div class="header-content">
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
    </div>

    <div class="nav-tabs">
        <a href="final.php" class="nav-tab" title="Player Matchups">
            <span class="nav-tab-icon">⚔️</span>
            <span class="nav-tab-text">Matchups</span>
        </a>
        <a href="index.php" class="nav-tab" title="View All Players">
            <span class="nav-tab-icon">🏀</span>
            <span class="nav-tab-text">Players</span>
        </a>
    </div>
</header>

<!-- ====================== ANIMATED BACKGROUND ====================== -->
<div class="floating-elements" id="floatingElements"></div>

<!-- ====================== HERO SECTION ====================== -->
<section class="hero">
    <div class="hero-content">
        <h1 class="hero-title">Compare <span>NBA Legends</span></h1>
        <p class="hero-subtitle">
            Dive into detailed player statistics, head-to-head matchups, and AI-powered analysis to settle the debate on who truly dominates the court.
        </p>
        
        <div class="features">
            <div class="feature-card">
                <div class="feature-icon">📊</div>
                <h3 class="feature-title">Player Stats</h3>
                <p class="feature-description">
                    Explore comprehensive career statistics for your favorite NBA players across all eras.
                </p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">⚔️</div>
                <h3 class="feature-title">Head-to-Head</h3>
                <p class="feature-description">
                    Compare players side-by-side with detailed metrics and visual comparisons.
                </p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">🤖</div>
                <h3 class="feature-title">AI Analysis</h3>
                <p class="feature-description">
                    Get intelligent insights on player matchups with our advanced analysis system.
                </p>
            </div>
        </div>
        
        <div class="cta-buttons">
            <a href="final.php" class="cta-btn">
                <i class="fas fa-fist-raised"></i> Start a Matchup
            </a>
            <a href="index.php" class="cta-btn secondary">
                <i class="fas fa-users"></i> Browse Players
            </a>
        </div>
    </div>
</section>

<!-- ====================== FOOTER ====================== -->
<footer>
    <div class="footer-content">
        <p class="copyright">© 2023 LunchTable Matchups. All rights reserved.</p>
    </div>
</footer>

<script>
    // Create floating background elements
    document.addEventListener('DOMContentLoaded', function() {
        const floatingElements = document.getElementById('floatingElements');
        const colors = ['rgba(255, 107, 53, 0.1)', 'rgba(255, 107, 53, 0.07)', 'rgba(255, 107, 53, 0.05)'];
        
        for (let i = 0; i < 15; i++) {
            const element = document.createElement('div');
            element.classList.add('floating-element');
            
            // Random properties
            const size = Math.random() * 100 + 20;
            const color = colors[Math.floor(Math.random() * colors.length)];
            const left = Math.random() * 100;
            const top = Math.random() * 100;
            const animationDuration = Math.random() * 20 + 10;
            const animationDelay = Math.random() * 5;
            
            element.style.width = `${size}px`;
            element.style.height = `${size}px`;
            element.style.background = color;
            element.style.left = `${left}%`;
            element.style.top = `${top}%`;
            element.style.animationDuration = `${animationDuration}s`;
            element.style.animationDelay = `${animationDelay}s`;
            
            floatingElements.appendChild(element);
        }
    });
</script>

</body>
</html>