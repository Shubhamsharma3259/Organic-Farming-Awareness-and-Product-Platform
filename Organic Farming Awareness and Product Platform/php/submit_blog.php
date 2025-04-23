<?php
// Initialize variables
$name = $email = $title = $content = '';
$errors = [];
$success = '';

function sanitize($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $title = sanitize($_POST['title']);
    $content = sanitize($_POST['content']);

    // Validation
    if (empty($name) || !preg_match("/^[a-zA-Z\s]{2,50}$/", $name)) {
        $errors[] = "Name must be 2-50 characters, letters and spaces only.";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required.";
    }
    if (empty($title) || strlen($title) < 5 || strlen($title) > 100) {
        $errors[] = "Title must be 5-100 characters.";
    }
    if (empty($content) || strlen($content) < 20 || strlen($content) > 1000) {
        $errors[] = "Content must be 20-1000 characters.";
    }

    if (empty($errors)) {
        $data = "Name: $name\nEmail: $email\nTitle: $title\nContent: $content\nTimestamp: " . date('Y-m-d H:i:s') . "\n---\n";
        if (file_put_contents('blog_ideas.txt', $data, FILE_APPEND)) {
            $success = "Thank you, $name! Your blog idea has been submitted.";
        } else {
            $errors[] = "Error saving submission.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Submission Response</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <section class="contact">
        <h2>Submission Response</h2>
        <?php if (!empty($success)): ?>
            <p class="success"><?php echo $success; ?></p>
        <?php else: ?>
            <?php if (!empty($errors)): ?>
                <ul class="errors">
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        <?php endif; ?>
        <a href="../awareness.php" class="cta-button">Back to Awareness</a>
    </section>
</body>
</html>