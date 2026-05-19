<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($page_title) ? htmlspecialchars($page_title) . ' — ' : '' ?>StudentMS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>

<?php if (isset($_SESSION['admin_id'])): ?>
<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <span class="brand-icon">◈</span>
        <span class="brand-text">StudentMS</span>
    </div>
    <nav class="sidebar-nav">
        <a href="dashboard.php" class="nav-link <?= $current_page === 'dashboard.php' ? 'active' : '' ?>">
            <i class="bi bi-grid-1x2"></i> Dashboard
        </a>
        <a href="add_student.php" class="nav-link <?= $current_page === 'add_student.php' ? 'active' : '' ?>">
            <i class="bi bi-person-plus"></i> Add Student
        </a>
        <a href="view_students.php" class="nav-link <?= $current_page === 'view_students.php' ? 'active' : '' ?>">
            <i class="bi bi-people"></i> All Students
        </a>
        <a href="search_student.php" class="nav-link <?= $current_page === 'search_student.php' ? 'active' : '' ?>">
            <i class="bi bi-search"></i> Search
        </a>
        <div class="sidebar-divider"></div>
        <a href="logout.php" class="nav-link nav-logout">
            <i class="bi bi-box-arrow-right"></i> Logout
        </a>
    </nav>
    <div class="sidebar-footer">
        <i class="bi bi-person-circle"></i>
        <?= htmlspecialchars($_SESSION['admin_username'] ?? 'Admin') ?>
    </div>
</div>

<!-- Top Navbar (mobile) -->
<nav class="topbar">
    <button class="sidebar-toggle" id="sidebarToggle">
        <i class="bi bi-list"></i>
    </button>
    <span class="topbar-title"><?= isset($page_title) ? htmlspecialchars($page_title) : 'Dashboard' ?></span>
    <a href="logout.php" class="topbar-logout"><i class="bi bi-box-arrow-right"></i></a>
</nav>

<div class="main-content" id="mainContent">
<?php endif; ?>
