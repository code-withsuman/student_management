<?php
require_once 'includes/auth.php';
require_once 'includes/db.php';
requireLogin();

$page_title = 'Search Students';

$query    = trim($_GET['q'] ?? '');
$students = [];
$searched = false;

if ($query !== '') {
    $searched = true;
    $q_escaped = mysqli_real_escape_string($conn, $query);
    $sql = "SELECT * FROM students
            WHERE name LIKE '%$q_escaped%'
               OR roll_number LIKE '%$q_escaped%'
               OR section LIKE '%$q_escaped%'
               OR email LIKE '%$q_escaped%'
            ORDER BY name ASC";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $students[] = $row;
    }
}

include 'includes/header.php';
?>

<div class="page-header">
    <h1>Search Students</h1>
    <p>Find students by name, roll number, section, or email</p>
</div>

<!-- Search Form -->
<div class="card mb-4">
    <div class="card-body p-4">
        <form method="GET" class="d-flex gap-3 flex-wrap align-items-end">
            <div class="flex-grow-1">
                <label class="form-label">Search Query</label>
                <input type="text" name="q" id="searchInput" class="form-control"
                    placeholder="Name, roll number, section, or email..."
                    value="<?= htmlspecialchars($query) ?>" autocomplete="off">
            </div>
            <div>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search me-2"></i>Search
                </button>
            </div>
            <?php if ($searched): ?>
            <div>
                <a href="search_student.php" class="btn btn-secondary">Clear</a>
            </div>
            <?php endif; ?>
        </form>
    </div>
</div>

<!-- Results -->
<?php if ($searched): ?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-list-ul me-2"></i>
            <?= count($students) ?> result<?= count($students) !== 1 ? 's' : '' ?>
            for "<strong><?= htmlspecialchars($query) ?></strong>"
        </span>
        <?php if (count($students) > 0): ?>
            <a href="view_students.php" class="btn btn-sm btn-secondary">View All</a>
        <?php endif; ?>
    </div>
    <div class="card-body p-0">
        <?php if (count($students) > 0): ?>
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
                <?php foreach ($students as $i => $s): ?>
                    <tr>
                        <td class="text-muted"><?= $i + 1 ?></td>
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
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="bi bi-binoculars" style="font-size:56px;color:var(--text-muted);"></i>
                <h4 class="mt-3">No results found</h4>
                <p class="text-muted">No students matched "<strong><?= htmlspecialchars($query) ?></strong>"</p>
                <a href="add_student.php" class="btn btn-primary mt-2">Add Student</a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php else: ?>
    <div class="text-center py-5">
        <i class="bi bi-search" style="font-size:56px;color:var(--text-muted);"></i>
        <h4 class="mt-3">Start searching</h4>
        <p class="text-muted">Enter a name, roll number, section, or email to search.</p>
    </div>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
