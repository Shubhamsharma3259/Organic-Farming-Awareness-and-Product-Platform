<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organic Farming Platform</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Lora:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">Organic Living</div>
            <ul class="nav-links">
                <li><a href="index.php" class="active">Home</a></li>
                <li><a href="awareness.php">Awareness</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="contact.php">Contact</a></li>
                <?php if (isset($_SESSION['user'])): ?>
                    <li><a href="recommend.php">Recommendations</a></li>
                    <li><a href="recommend.php?logout=true">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="register.php">Register</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <!-- Rest of index.html content unchanged -->
    <section class="hero">
        <div class="hero-content">
            <h1>Grow Green, Live Organic</h1>
            <p>Discover the benefits of organic farming and shop sustainably sourced products.</p>
            <a href="products.php" class="cta-button">Shop Now</a>
        </div>
    </section>
    <section class="benefits">
        <h2>Why Choose Organic?</h2>
        <div class="benefits-grid">
            <div class="benefit-card">
                <i class="fas fa-leaf"></i>
                <h3>Eco-Friendly</h3>
                <p>Supports sustainable practices that protect our planet.</p>
            </div>
            <div class="benefit-card">
                <i class="fas fa-heart"></i>
                <h3>Healthier Choice</h3>
                <p>Free from harmful chemicals and pesticides.</p>
            </div>
            <div class="benefit-card">
                <i class="fas fa-seedling"></i>
                <h3>Supports Farmers</h3>
                <p>Empowers local farmers with fair trade practices.</p>
            </div>
        </div>
    </section>
    <footer>
        <p>© 2025 Organic Living. All rights reserved.</p>
    </footer>
</body>
</html>