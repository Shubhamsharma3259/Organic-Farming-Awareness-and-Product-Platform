<?php
// Sample blog posts (can be moved to a file or database)
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
?>

<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Awareness - Organic Farming</title>
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

    <!-- Awareness Content -->
    <section class="awareness">
        <h2>Learn About Organic Farming</h2>
        <div class="awareness-content">
            <div class="awareness-card">
                <h3>What is Organic Farming?</h3>
                <p>Organic farming avoids synthetic fertilizers and pesticides, focusing on natural methods to enrich soil and protect crops.</p>
            </div>
            <div class="awareness-card">
                <h3>Benefits</h3>
                <p>Improves soil health, reduces pollution, and provides nutrient-rich food.</p>
            </div>
            <div class="awareness-card">
                <h3>Myths Busted</h3>
                <p>Organic doesn't mean less productive—modern techniques ensure high yields sustainably.</p>
            </div>
        </div>
    </section>

    <!-- Blog Section -->
    <section class="blogs">
        <h2>Organic Farming Blog</h2>
        <div class="blog-search">
            <input type="text" id="blogSearch" placeholder="Search blogs..." onkeyup="searchBlogs()">
            <i class="fas fa-search"></i>
        </div>
        <div class="blogs-grid">
            <?php foreach ($blogs as $blog): ?>
                <div class="blog-card">
                    <h3><?php echo htmlspecialchars($blog['title']); ?></h3>
                    <p class="blog-date"><?php echo htmlspecialchars($blog['date']); ?></p>
                    <p><?php echo htmlspecialchars($blog['excerpt']); ?></p>
                    <a href="blog.php?id=<?php echo $blog['id']; ?>" class="read-more">Read More</a>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
    <!-- Blog Submission Form -->
<section class="blog-submit">
    <h2>Submit a Blog Idea</h2>
    <form action="php/submit_blog.php" method="POST">
        <input type="text" name="name" placeholder="Your Name" required>
        <input type="email" name="email" placeholder="Your Email" required>
        <input type="text" name="title" placeholder="Blog Title" required>
        <textarea name="content" placeholder="Your Blog Idea" required></textarea>
        <button type="submit">Submit Idea</button>
    </form>
</section>

    <!-- Footer -->
    <footer>
        <p>© 2025 Organic Living. All rights reserved.</p>
    </footer>

    <script>
        // Blog search functionality
        function searchBlogs() {
            let input = document.getElementById('blogSearch').value.toLowerCase();
            let cards = document.getElementsByClassName('blog-card');
            for (let i = 0; i < cards.length; i++) {
                let title = cards[i].getElementsByTagName('h3')[0].innerText.toLowerCase();
                let excerpt = cards[i].getElementsByTagName('p')[0].innerText.toLowerCase();
                if (title.includes(input) || excerpt.includes(input)) {
                    cards[i].style.display = '';
                } else {
                    cards[i].style.display = 'none';
                }
            }
        }
    </script>
</body>
</html>