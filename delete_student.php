<?php
require_once 'includes/auth.php';
require_once 'includes/db.php';
requireLogin();

$id = intval($_GET['id'] ?? 0);

if ($id <= 0) {
    header('Location: view_students.php');
    exit();
}

$result  = mysqli_query($conn, "SELECT * FROM students WHERE id=$id LIMIT 1");
$student = mysqli_fetch_assoc($result);

if (!$student) {
    header('Location: view_students.php?msg=Student+not+found');
    exit();
}

// Confirm & delete via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_delete'])) {
    mysqli_query($conn, "DELETE FROM students WHERE id=$id");
    header('Location: view_students.php?msg=' . urlencode('Student "' . $student['name'] . '" deleted successfully.'));
    exit();
}

$page_title = 'Delete Student';
include 'includes/header.php';
?>

<div class="page-header">
    <h1>Delete Student</h1>
    <p>This action cannot be undone</p>
</div>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card" style="border-color: var(--danger);">
            <div class="card-header" style="background:rgba(248,81,73,0.1);color:var(--danger);">
                <i class="bi bi-exclamation-triangle me-2"></i>Confirm Deletion
            </div>
            <div class="card-body p-4 text-center">
                <i class="bi bi-person-x" style="font-size:56px;color:var(--danger);"></i>
                <h4 class="mt-3"><?= htmlspecialchars($student['name']) ?></h4>
                <p class="text-muted mb-1">Roll: <?= htmlspecialchars($student['roll_number']) ?> &nbsp;|&nbsp; Section: <?= htmlspecialchars($student['section']) ?></p>
                <p class="text-muted"><?= htmlspecialchars($student['email']) ?></p>

                <div class="alert alert-danger mt-3">
                    Are you sure you want to permanently delete this student record?
                </div>

                <form method="POST" class="d-flex gap-3 justify-content-center mt-3">
                    <button type="submit" name="confirm_delete" class="btn btn-danger">
                        <i class="bi bi-trash me-2"></i>Yes, Delete
                    </button>
                    <a href="view_students.php" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
