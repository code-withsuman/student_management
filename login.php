<?php
require_once 'includes/auth.php';
require_once 'includes/db.php';
redirectIfLoggedIn();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim(mysqli_real_escape_string($conn, $_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error = 'Please enter both email and password.';
    } else {
        $sql    = "SELECT * FROM admins WHERE email='$email' LIMIT 1";
        $result = mysqli_query($conn, $sql);
        $admin  = mysqli_fetch_assoc($result);

        if ($admin && password_verify($password, $admin['password'])) {
            $_SESSION['admin_id']       = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            $_SESSION['admin_email']    = $admin['email'];
            header('Location: dashboard.php');
            exit();
        } else {
            $error = 'Invalid email or password. Please try again.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — StudentMS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-logo">
            <span class="auth-logo-icon">◈</span>
            <h2>Welcome Back</h2>
            <p>Sign in to the admin panel</p>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger auto-dismiss"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if (isset($_GET['logged_out'])): ?>
            <div class="alert alert-info auto-dismiss">You have been logged out successfully.</div>
        <?php endif; ?>

        <form method="POST" novalidate>
            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control"
                    placeholder="admin@school.com"
                    value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required autofocus>
            </div>
            <div class="mb-4">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control"
                    placeholder="Enter your password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Sign In</button>
        </form>

        <div class="divider-text mt-4">Don't have an account?</div>
        <a href="signup.php" class="btn btn-secondary w-100 mt-2">Create Account</a>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/script.js"></script>
</body>
</html>
