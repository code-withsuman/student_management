<?php
require_once 'includes/auth.php';
require_once 'includes/db.php';
requireLogin();

$page_title = 'All Students';

$success = $_GET['msg'] ?? '';

$result = mysqli_query($conn, "SELECT * FROM students ORDER BY id DESC");
$total  = mysqli_num_rows($result);

include 'includes/header.php';
?>

<div class="page-header d-flex flex-wrap gap-3 justify-content-between align-items-start">
    <div>
        <h1>All Students</h1>
        <p><?= $total ?> student<?= $total !== 1 ? 's' : '' ?> registered</p>
    </div>
    <div class="d-flex gap-2">
        <a href="search_student.php" class="btn btn-secondary"><i class="bi bi-search me-2"></i>Search</a>
        <a href="add_student.php" class="btn btn-primary"><i class="bi bi-person-plus me-2"></i>Add Student</a>
    </div>
</div>

<?php if ($success): ?>
    <div class="alert alert-success auto-dismiss"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<div class="card">
    <div class="card-body p-0">
        <?php if ($total > 0): ?>
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Roll No.</th>
                        <th>Section</th>
                        <th>Age</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $i = 1;
                while ($s = mysqli_fetch_assoc($result)):
                ?>
                    <tr>
                        <td class="text-muted"><?= $i++ ?></td>
                        <td><strong><?= htmlspecialchars($s['name']) ?></strong></td>
                        <td><code style="color:var(--accent);background:var(--accent-bg);padding:2px 6px;border-radius:4px;"><?= htmlspecialchars($s['roll_number']) ?></code></td>
                        <td><span class="badge-section"><?= htmlspecialchars($s['section']) ?></span></td>
                        <td><?= $s['age'] ?></td>
                        <td><?= htmlspecialchars($s['phone']) ?></td>
                        <td><?= htmlspecialchars($s['email']) ?></td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="edit_student.php?id=<?= $s['id'] ?>" class="btn btn-sm btn-info">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="delete_student.php?id=<?= $s['id'] ?>"
                                   class="btn btn-sm btn-danger btn-delete-confirm">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="bi bi-inbox" style="font-size:64px;color:var(--text-muted);"></i>
                <h4 class="mt-3">No students found</h4>
                <p class="text-muted">Start by adding your first student.</p>
                <a href="add_student.php" class="btn btn-primary mt-2">Add Student</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
