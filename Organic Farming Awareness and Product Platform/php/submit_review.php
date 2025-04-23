<?php
// Initialize variables
$name = $rating = $comment = $product_id = '';
$errors = [];
$success = '';

// Sanitize input
function sanitize($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = sanitize($_POST['product_id']);
    $name = sanitize($_POST['name']);
    $rating = sanitize($_POST['rating']);
    $comment = sanitize($_POST['comment']);

    // Validation rules
    // Product ID: must be valid
    $valid_products = ['veg', 'fruit', 'honey'];
    if (empty($product_id) || !in_array($product_id, $valid_products)) {
        $errors[] = "Invalid product.";
    }

    // Name: letters and spaces, 2-50 characters
    if (empty($name)) {
        $errors[] = "Name is required.";
    } elseif (!preg_match("/^[a-zA-Z\s]{2,50}$/", $name)) {
        $errors[] = "Name must be 2-50 characters and contain only letters and spaces.";
    }

    // Rating: must be 1-5
    if (empty($rating)) {
        $errors[] = "Rating is required.";
    } elseif (!in_array($rating, ['1', '2', '3', '4', '5'])) {
        $errors[] = "Invalid rating. Choose 1-5 stars.";
    }

    // Comment: 10-200 characters
    if (empty($comment)) {
        $errors[] = "Review comment is required.";
    } elseif (strlen($comment) < 10 || strlen($comment) > 200) {
        $errors[] = "Review must be between 10 and 200 characters.";
    }

    // If no errors, save the review
    if (empty($errors)) {
        $data = "$product_id|$name|$rating|$comment|" . date('Y-m-d H:i:s') . "\n";
        if (file_put_contents('reviews.txt', $data, FILE_APPEND)) {
            $success = "Thank you, $name! Your review has been submitted.";
        } else {
            $errors[] = "Error saving review. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Response</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <section class="contact">
        <h2>Review Response</h2>
        <?php if (!empty($success)): ?>
            <p class="success"><?php echo $success; ?></p>
            <a href="../products.php" class="cta-button">Back to Products</a>
        <?php else: ?>
            <?php if (!empty($errors)): ?>
                <ul class="errors">
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <a href="../products.php" class="cta-button">Back to Products</a>
        <?php endif; ?>
    </section>
</body>
</html>