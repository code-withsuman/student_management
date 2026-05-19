<?php
require_once 'includes/auth.php';
require_once 'includes/db.php';
redirectIfLoggedIn();

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim(mysqli_real_escape_string($conn, $_POST['username'] ?? ''));
    $email    = trim(mysqli_real_escape_string($conn, $_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm_password'] ?? '';

    if (empty($username)) $errors[] = 'Username is required.';
    elseif (strlen($username) < 3) $errors[] = 'Username must be at least 3 characters.';

    if (empty($email)) $errors[] = 'Email is required.';
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Invalid email format.';

    if (empty($password)) $errors[] = 'Password is required.';
    elseif (strlen($password) < 6) $errors[] = 'Password must be at least 6 characters.';

    if ($password !== $confirm) $errors[] = 'Passwords do not match.';

    if (empty($errors)) {
        // Check duplicate email
        $check = mysqli_query($conn, "SELECT id FROM admins WHERE email='$email'");
        if (mysqli_num_rows($check) > 0) {
            $errors[] = 'This email is already registered.';
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO admins (username, email, password) VALUES ('$username', '$email', '$hashed')";
            if (mysqli_query($conn, $sql)) {
                $success = 'Account created successfully! You can now <a href="login.php">login</a>.';
            } else {
                $errors[] = 'Something went wrong. Please try again.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup — StudentMS</title>
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
            <h2>Create Account</h2>
            <p>Register as a system administrator</p>
        </div>

        <?php if ($success): ?>
            <div class="alert alert-success auto-dismiss"><?= $success ?></div>
        <?php endif; ?>
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <?php foreach ($errors as $e): ?>
                    <div><?= htmlspecialchars($e) ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="POST" novalidate>
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control"
                    placeholder="Enter username"
                    value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control"
                    placeholder="admin@school.com"
                    value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control"
                    placeholder="Min. 6 characters" required>
                <div class="mt-2" style="height:4px;background:var(--surface2);border-radius:2px;overflow:hidden;">
                    <div id="passwordStrength" style="height:100%;width:0;transition:all 0.3s;border-radius:2px;"></div>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm_password"
                    class="form-control" placeholder="Re-enter password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Create Account</button>
        </form>

        <div class="divider-text mt-4">Already have an account?</div>
        <a href="login.php" class="btn btn-secondary w-100 mt-2">Sign In</a>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/script.js"></script>
</body>
</html>
