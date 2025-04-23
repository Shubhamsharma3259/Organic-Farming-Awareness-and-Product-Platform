<?php
// Sample blog posts (same as awareness.php; ideally, move to a shared file)
$blogs = [
    [
        'id' => 1,
        'title' => 'The Benefits of Organic Farming',
        'excerpt' => 'Learn how organic farming improves soil health, reduces pollution, and provides nutrient-rich food.',
        'content' => 'Organic farming is a sustainable agricultural practice that avoids synthetic fertilizers and pesticides. It focuses on natural methods like crop rotation, composting, and biological pest control. Benefits include improved soil fertility, reduced environmental pollution, and healthier produce free from harmful chemicals. Studies show organic foods often have higher levels of antioxidants, benefiting consumer health. Additionally, organic farming supports biodiversity by fostering habitats for pollinators and wildlife.',
        'date' => '2025-03-15',
    ],
    [
        'id' => 2,
        'title' => 'Debunking Organic Farming Myths',
        'excerpt' => 'Is organic farming less productive? We bust common myths with facts.',
        'content' => 'Many believe organic farming yields less than conventional methods, but modern organic techniques can match or exceed traditional outputs when managed correctly. Another myth is that organic food is always more expensive, yet prices are becoming competitive as demand grows. Organic farming also doesn’t mean "no pesticides"—it uses natural alternatives like neem oil. Understanding these truths helps consumers make informed choices.',
        'date' => '2025-04-01',
    ],
    [
        'id' => 3,
        'title' => 'How to Start Your Own Organic Garden',
        'excerpt' => 'A beginner’s guide to growing organic produce at home.',
        'content' => 'Starting an organic garden is easier than you think! Begin with a small plot or containers, choose organic seeds, and enrich soil with compost. Avoid synthetic chemicals by using natural fertilizers like manure or seaweed. Regular watering, mulching, and companion planting (e.g., marigolds to deter pests) ensure healthy crops. With patience, you’ll enjoy fresh, homegrown vegetables free from harmful residues.',
        'date' => '2025-04-10',
    ],
];

// Get blog ID from URL
$blog_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$blog = null;

// Find the blog post
foreach ($blogs as $b) {
    if ($b['id'] === $blog_id) {
        $blog = $b;
        break;
    }
}

// If blog not found, redirect or show error
if (!$blog) {
    header('Location: awareness.php');
    exit;
}
?>
<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($blog['title']); ?> - Organic Farming</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Lora:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Header -->
    <header>
        <nav>
            <div class="logo">Organic Living</div>
            <ul class="nav-links">
    <li><a href="index.php">Home</a></li>
    <li><a href="awareness.php" class="active">Awareness</a></li> <!-- Adjust 'active' per page -->
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

    <!-- Blog Content -->
    <section class="blog-detail">
        <h1><?php echo htmlspecialchars($blog['title']); ?></h1>
        <p class="blog-date"><?php echo htmlspecialchars($blog['date']); ?></p>
        <div class="blog-content">
            <?php echo nl2br(htmlspecialchars($blog['content'])); ?>
        </div>
        <a href="awareness.php" class="cta-button">Back to Blogs</a>
    </section>

    <!-- Footer -->
    <footer>
        <p>© 2025 Organic Living. All rights reserved.</p>
    </footer>
</body>
</html>