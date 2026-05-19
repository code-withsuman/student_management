<?php
require_once 'includes/auth.php';
require_once 'includes/db.php';
requireLogin();

$page_title = 'Add Student';
$errors  = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name        = trim(mysqli_real_escape_string($conn, $_POST['name'] ?? ''));
    $roll_number = trim(mysqli_real_escape_string($conn, $_POST['roll_number'] ?? ''));
    $section     = trim(mysqli_real_escape_string($conn, $_POST['section'] ?? ''));
    $age         = intval($_POST['age'] ?? 0);
    $phone       = trim(mysqli_real_escape_string($conn, $_POST['phone'] ?? ''));
    $email       = trim(mysqli_real_escape_string($conn, $_POST['email'] ?? ''));

    if (empty($name))        $errors[] = 'Student name is required.';
    if (empty($roll_number)) $errors[] = 'Roll number is required.';
    if (empty($section))     $errors[] = 'Section is required.';
    if ($age < 1 || $age > 100) $errors[] = 'Please enter a valid age.';
    if (empty($phone))       $errors[] = 'Phone number is required.';
    if (empty($email))       $errors[] = 'Email is required.';
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Invalid email format.';

    if (empty($errors)) {
        // Check duplicate roll number
        $check = mysqli_query($conn, "SELECT id FROM students WHERE roll_number='$roll_number'");
        if (mysqli_num_rows($check) > 0) {
            $errors[] = 'Roll number already exists.';
        } else {
            $sql = "INSERT INTO students (name, roll_number, section, age, phone, email)
                    VALUES ('$name','$roll_number','$section',$age,'$phone','$email')";
            if (mysqli_query($conn, $sql)) {
                $success = 'Student added successfully!';
                // Clear form
                $_POST = [];
            } else {
                $errors[] = 'Database error: ' . mysqli_error($conn);
            }
        }
    }
}

include 'includes/header.php';
?>

<div class="page-header">
    <h1>Add Student</h1>
    <p>Fill in the details to register a new student</p>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header"><i class="bi bi-person-plus me-2"></i>Student Information</div>
            <div class="card-body p-4">

                <?php if ($success): ?>
                    <div class="alert alert-success auto-dismiss"><?= htmlspecialchars($success) ?></div>
                <?php endif; ?>
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <?php foreach ($errors as $e): ?>
                            <div><?= htmlspecialchars($e) ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <form method="POST" novalidate>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Student Name <span style="color:var(--danger)">*</span></label>
                            <input type="text" name="name" class="form-control"
                                placeholder="Full name"
                                value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Roll Number <span style="color:var(--danger)">*</span></label>
                            <input type="text" name="roll_number" class="form-control"
                                placeholder="e.g. CS-2024-001"
                                value="<?= htmlspecialchars($_POST['roll_number'] ?? '') ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Section <span style="color:var(--danger)">*</span></label>
                            <select name="section" class="form-select" required>
                                <option value="">Select section</option>
                                <?php
                                $selected_section = $_POST['section'] ?? '';
                                $sections = ['A','B','C','D','E','F'];
                                foreach ($sections as $s) {
                                    $sel = ($selected_section === $s) ? 'selected' : '';
                                    echo "<option value='$s' $sel>Section $s</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Age <span style="color:var(--danger)">*</span></label>
                            <input type="number" name="age" class="form-control"
                                placeholder="e.g. 18" min="1" max="100"
                                value="<?= htmlspecialchars($_POST['age'] ?? '') ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone Number <span style="color:var(--danger)">*</span></label>
                            <input type="text" name="phone" class="form-control"
                                placeholder="e.g. 9876543210"
                                value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email Address <span style="color:var(--danger)">*</span></label>
                            <input type="email" name="email" class="form-control"
                                placeholder="student@email.com"
                                value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                        </div>
                    </div>

                    <div class="d-flex gap-3 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-person-check me-2"></i>Add Student
                        </button>
                        <a href="view_students.php" class="btn btn-secondary">View All Students</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
