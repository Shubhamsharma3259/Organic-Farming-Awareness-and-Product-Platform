<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$recommendation = '';
$errors = [];
$success = '';

function sanitize($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

function get_recommendations() {
    $file = __DIR__ . '/php/recommendations.txt';
    $recommendations = [];
    if (file_exists($file)) {
        $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $data = explode('|', $line);
            if (count($data) >= 3) {
                $recommendations[] = [
                    'username' => $data[0],
                    'text' => $data[1],
                    'timestamp' => $data[2]
                ];
            }
        }
    }
    return $recommendations;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $recommendation = sanitize($_POST['recommendation']);

    if (empty($recommendation) || strlen($recommendation) < 10) {
        $errors[] = "Recommendation must be at least 10 characters.";
    }

    if (empty($errors)) {
        $username = $_SESSION['user'];
        $data = "$username|$recommendation|" . date('Y-m-d H:i:s') . "\n";
        if (file_put_contents(__DIR__ . '/php/recommendations.txt', $data, FILE_APPEND)) {
            $success = "Thank you for your recommendation!";
            $recommendation = '';
        } else {
            $errors[] = "Error saving recommendation.";
        }
    }
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recommendations - Organic Farming</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Lora:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <nav>
            <div class="logo">Organic Living</div>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="awareness.php">Awareness</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="recommend.php" class="active">Recommendations</a></li>
                <li><a href="recommend.php?logout=true">Logout</a></li>
            </ul>
        </nav>
    </header>

    <section class="recommend">
        <h2>Share Your Ideas</h2>
        <p>Welcome, <?php echo htmlspecialchars($_SESSION['user']); ?>! Suggest ways to promote organic farming.</p>
        <?php if (!empty($success)): ?>
            <p class="success"><?php echo $success; ?></p>
        <?php endif; ?>
        <?php if (!empty($errors)): ?>
            <ul class="errors">
                <?php foreach ($errors as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <form action="recommend.php" method="POST">
            <textarea name="recommendation" placeholder="Your Recommendation" required><?php echo htmlspecialchars($recommendation); ?></textarea>
            <button type="submit">Submit Recommendation</button>
        </form>

        <h3>Community Recommendations</h3>
        <?php
        $recommendations = get_recommendations();
        if (!empty($recommendations)): ?>
            <div class="recommendations-grid">
                <?php foreach ($recommendations as $rec): ?>
                    <div class="recommend-card">
                        <p><strong><?php echo htmlspecialchars($rec['username']); ?></strong> (<?php echo $rec['timestamp']; ?>)</p>
                        <p><?php echo htmlspecialchars($rec['text']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>No recommendations yet. Be the first!</p>
        <?php endif; ?>
    </section>

    <footer>
        <p>© 2025 Organic Living. All rights reserved.</p>
    </footer>
</body>
</html>