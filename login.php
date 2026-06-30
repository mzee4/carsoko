<?php
session_start();
include 'db.php';

// If already logged in, go to home
if (isset($_SESSION['email'])) {
    header('Location: index.php');
    exit;
}

$error_message = '';
$success_message = '';
$submitted_email = '';

// Show registration success message once
if (isset($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $submitted_email = trim($_POST['email']);
    $email = $submitted_email;
    $password = $_POST['password'];

    if ($email === '' || $password === '') {
        $error_message = 'Please enter both email and password.';
    } else {
        $stmt = mysqli_prepare($conn, "SELECT id, password FROM users WHERE email = ? LIMIT 1");
        if ($stmt === false) {
            $error_message = 'Database error: ' . mysqli_error($conn);
        } else {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_assoc($result)) {
                if (password_verify($password, $row['password'])) {
                    // Store user info in session
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['email'] = $email;

                    // Add one-time login success message
                    $_SESSION['login_success'] = 'You have successfully logged in!';

                    header('Location: index.php');
                    exit;
                } else {
                    $error_message = 'Invalid login details.';
                }
            } else {
                $error_message = 'Invalid login details.';
            }

            mysqli_stmt_close($stmt);
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Customer Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>Customer Login</h1>
</header>

<nav>
    <a href="index.php">Home</a>
    <a href="register.php">Register</a>
    <a href="login.php">Login</a>
</nav>

<div class="container">

<?php if ($success_message !== ''): ?>
    <p style="color: green;"><?php echo htmlspecialchars($success_message, ENT_QUOTES, 'UTF-8'); ?></p>
<?php endif; ?>

<?php if ($error_message !== ''): ?>
    <p style="color: red;"><?php echo htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8'); ?></p>
<?php endif; ?>

<form action="login.php" method="POST">

<label>Email Address</label>
<input type="email" name="email" value="<?php echo htmlspecialchars($submitted_email, ENT_QUOTES, 'UTF-8'); ?>" required>

<label>Password</label>
<input type="password" name="password" required>

<input type="checkbox"> Remember Me

<br><br>

<button type="submit" name="login">Login</button>

<p>
    New customer?
    <a href="register.php">Register Here</a>
</p>

</form>

</div>

<footer>
    &copy; 2026 Car Soko Rental Services
</footer>

</body>
</html>