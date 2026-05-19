<?php
require_once 'includes/auth.php';
require_once 'includes/db.php';
requireLogin();

$page_title = 'Dashboard';

// Stats
$total_students = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM students"))['c'];
$recent_students = mysqli_query($conn, "SELECT * FROM students ORDER BY created_at DESC LIMIT 5");

// Section distribution
$sections_result = mysqli_query($conn, "SELECT section, COUNT(*) as c FROM students GROUP BY section ORDER BY c DESC LIMIT 4");
$sections = [];
while ($row = mysqli_fetch_assoc($sections_result)) $sections[] = $row;

include 'includes/header.php';
?>

<div class="page-header">
    <h1>Dashboard</h1>
    <p>Welcome back, <?= htmlspecialchars($_SESSION['admin_username']) ?>!</p>
</div>

<!-- Stat Cards -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon amber"><i class="bi bi-people-fill"></i></div>
            <div>
                <div class="stat-number"><?= $total_students ?></div>
                <div class="stat-label">Total Students</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon blue"><i class="bi bi-journal-bookmark-fill"></i></div>
            <div>
                <div class="stat-number"><?= count($sections) ?></div>
                <div class="stat-label">Active Sections</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon green"><i class="bi bi-person-check-fill"></i></div>
            <div>
                <div class="stat-number"><?= $total_students > 0 ? round($total_students / max(count($sections),1)) : 0 ?></div>
                <div class="stat-label">Avg. Per Section</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon red"><i class="bi bi-calendar-event"></i></div>
            <div>
                <div class="stat-number"><?= date('Y') ?></div>
                <div class="stat-label">Academic Year</div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="card mb-4">
    <div class="card-header"><i class="bi bi-lightning-charge me-2"></i>Quick Actions</div>
    <div class="card-body p-3">
        <div class="row g-3">
            <div class="col-6 col-md-3">
                <a href="add_student.php" class="quick-action">
                    <i class="bi bi-person-plus-fill"></i>
                    <span>Add Student</span>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="view_students.php" class="quick-action">
                    <i class="bi bi-table"></i>
                    <span>View All</span>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="search_student.php" class="quick-action">
                    <i class="bi bi-search"></i>
                    <span>Search</span>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="logout.php" class="quick-action">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Logout</span>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Recent Students -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-clock-history me-2"></i>Recently Added</span>
        <a href="view_students.php" class="btn btn-sm btn-outline-primary">View All</a>
    </div>
    <div class="card-body p-0">
        <?php if (mysqli_num_rows($recent_students) > 0): ?>
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Roll No.</th>
                        <th>Section</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php while ($s = mysqli_fetch_assoc($recent_students)): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($s['name']) ?></strong></td>
                        <td><?= htmlspecialchars($s['roll_number']) ?></td>
                        <td><span class="badge-section"><?= htmlspecialchars($s['section']) ?></span></td>
                        <td><?= htmlspecialchars($s['email']) ?></td>
                        <td>
                            <a href="edit_student.php?id=<?= $s['id'] ?>" class="btn btn-sm btn-info">Edit</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="bi bi-inbox" style="font-size:48px;color:var(--text-muted);"></i>
                <p class="mt-3 text-muted">No students added yet.</p>
                <a href="add_student.php" class="btn btn-primary mt-2">Add First Student</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
