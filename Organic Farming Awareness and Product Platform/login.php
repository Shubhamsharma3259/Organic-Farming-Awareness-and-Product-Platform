<?php
session_start();
if (isset($_SESSION['user'])) {
    header('Location: recommend.php');
    exit;
}

$identifier = $password = '';
$errors = [];

function sanitize($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

function authenticate($identifier, $password) {
    $file = __DIR__ . '/php/users.txt';
    if (!file_exists($file)) return false;
    $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $data = explode('|', $line);
        if (count($data) >= 3 && ($data[0] === $identifier || $data[1] === $identifier)) {
            if (password_verify($password, $data[2])) {
                return $data[0]; // Return username
            }
        }
    }
    return false;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $identifier = sanitize($_POST['identifier']);
    $password = $_POST['password'];

    if (empty($identifier)) {
        $errors[] = "Username or email is required.";
    }
    if (empty($password)) {
        $errors[] = "Password is required.";
    }

    if (empty($errors)) {
        $username = authenticate($identifier, $password);
        if ($username) {
            $_SESSION['user'] = $username;
            header('Location: recommend.php');
            exit;
        } else {
            $errors[] = "Invalid username/email or password.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Organic Farming</title>
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
                <li><a href="login.php" class="active">Login</a></li>
                <li><a href="register.php">Register</a></li>
            </ul>
        </nav>
    </header>

    <section class="login" style="margin-top: 100px; margin-bottom: 100px;">
        <h2>Login</h2>
        <?php if (!empty($errors)): ?>
            <ul class="errors">
                <?php foreach ($errors as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <input type="text" name="identifier" placeholder="Username or Email" value="<?php echo htmlspecialchars($identifier); ?>" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a>.</p>
    </section>

    <footer>
        <p>© 2025 Organic Living. All rights reserved.</p>
    </footer>
</body>
</html>