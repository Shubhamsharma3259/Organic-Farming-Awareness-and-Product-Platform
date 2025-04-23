<?php
// Initialize variables for form data and errors
$name = $email = $message = '';
$errors = [];
$success = '';

// Function to sanitize input
function sanitize($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize input
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $message = sanitize($_POST['message']);

    // Validation rules
    // Name: letters and spaces only, 2-50 characters
    if (empty($name)) {
        $errors[] = "Name is required.";
    } elseif (!preg_match("/^[a-zA-Z\s]{2,50}$/", $name)) {
        $errors[] = "Name must be 2-50 characters and contain only letters and spaces.";
    }

    // Email: valid format
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    // Message: 10-500 characters
    if (empty($message)) {
        $errors[] = "Message is required.";
    } elseif (strlen($message) < 10 || strlen($message) > 500) {
        $errors[] = "Message must be between 10 and 500 characters.";
    }

    // If no errors, process the form
    if (empty($errors)) {
        // Save to file (or extend to database/email)
        $data = "Name: $name\nEmail: $email\nMessage: $message\nTimestamp: " . date('Y-m-d H:i:s') . "\n---\n";
        if (file_put_contents('messages.txt', $data, FILE_APPEND)) {
            $success = "Thank you, $name! Your message has been received.";
            // Clear form data
            $name = $email = $message = '';
        } else {
            $errors[] = "Error saving message. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Response</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <section class="contact">
        <h2>Contact Response</h2>
        <?php if (!empty($success)): ?>
            <p class="success"><?php echo $success; ?></p>
            <a href="../contact.html" class="cta-button">Back to Contact Form</a>
        <?php else: ?>
            <?php if (!empty($errors)): ?>
                <ul class="errors">
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <a href="../contact.html" class="cta-button">Back to Contact Form</a>
        <?php endif; ?>
    </section>
</body>
</html>

<style>
.success {
    color: #4caf50;
    font-weight: bold;
    margin-bottom: 20px;
}
.errors {
    color: #d32f2f;
    list-style: disc;
    margin-bottom: 20px;
    padding-left: 20px;
}
</style>