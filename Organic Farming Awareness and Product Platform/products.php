<?php
// Function to load reviews from file
function load_reviews($product_id) {
    $reviews = [];
    if (file_exists('php/reviews.txt')) {
        $lines = file('php/reviews.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $data = explode('|', $line);
            if (count($data) >= 4 && $data[0] === $product_id) {
                $reviews[] = [
                    'name' => $data[1],
                    'rating' => $data[2],
                    'comment' => $data[3],
                    'timestamp' => $data[4]
                ];
            }
        }
    }
    return $reviews;
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
    <title>Products - Organic Farming</title>
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

    <!-- Products Section -->
    <section class="products">
        <h2>Our Organic Products</h2>
        <div class="products-grid">
            <?php
            $products = [
                ['id' => 'veg', 'name' => 'Organic Vegetables', 'desc' => 'Fresh, pesticide-free vegetables grown sustainably.', 'price' => '$5.99/kg', 'img' => 'images/vegetables.jpg'],
                ['id' => 'fruit', 'name' => 'Organic Fruits', 'desc' => 'Juicy fruits packed with natural flavors.', 'price' => '$6.99/kg', 'img' => 'images/fruits.jpg'],
                ['id' => 'honey', 'name' => 'Organic Honey', 'desc' => 'Pure, unprocessed honey from local farms.', 'price' => '$8.99/jar', 'img' => 'images/honey.jpg']
            ];

            foreach ($products as $product):
            ?>
                <div class="product-card">
                    <img src="<?php echo $product['img']; ?>" alt="<?php echo $product['name']; ?>">
                    <h3><?php echo $product['name']; ?></h3>
                    <p><?php echo $product['desc']; ?></p>
                    <p class="price"><?php echo $product['price']; ?></p>
                    <button class="add-to-cart">Add to Cart</button>

                    <!-- Review Form -->
                    <div class="review-form">
                        <h4>Leave a Review</h4>
                        <form action="php/submit_review.php" method="POST">
                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                            <input type="text" name="name" placeholder="Your Name" required>
                            <select name="rating" required>
                                <option value="">Select Rating</option>
                                <option value="5">5 Stars</option>
                                <option value="4">4 Stars</option>
                                <option value="3">3 Stars</option>
                                <option value="2">2 Stars</option>
                                <option value="1">1 Star</option>
                            </select>
                            <textarea name="comment" placeholder="Your Review" required></textarea>
                            <button type="submit">Submit Review</button>
                        </form>
                    </div>

                    <!-- Display Reviews -->
                    <div class="reviews">
                        <h4>Reviews</h4>
                        <?php
                        $reviews = load_reviews($product['id']);
                        if (empty($reviews)):
                        ?>
                            <p>No reviews yet. Be the first!</p>
                        <?php else: ?>
                            <?php foreach ($reviews as $review): ?>
                                <div class="review">
                                    <p><strong><?php echo htmlspecialchars($review['name']); ?></strong> (<?php echo $review['rating']; ?> Stars)</p>
                                    <p><?php echo htmlspecialchars($review['comment']); ?></p>
                                    <p><small><?php echo $review['timestamp']; ?></small></p>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>© 2025 Organic Living. All rights reserved.</p>
    </footer>

    <script>
        // Add to Cart alert
        document.querySelectorAll('.add-to-cart').forEach(button => {
            button.addEventListener('click', () => {
                alert('Product added to cart!');
            });
        });
    </script>
</body>
</html>