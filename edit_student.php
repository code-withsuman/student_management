<?php
require_once 'includes/auth.php';
require_once 'includes/db.php';
requireLogin();

$page_title = 'Edit Student';
$errors  = [];
$success = '';

$id = intval($_GET['id'] ?? 0);
if ($id <= 0) {
    header('Location: view_students.php');
    exit();
}

$student_result = mysqli_query($conn, "SELECT * FROM students WHERE id=$id LIMIT 1");
if (mysqli_num_rows($student_result) === 0) {
    header('Location: view_students.php');
    exit();
}
$student = mysqli_fetch_assoc($student_result);

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
        // Check duplicate roll number (excluding current student)
        $check = mysqli_query($conn, "SELECT id FROM students WHERE roll_number='$roll_number' AND id != $id");
        if (mysqli_num_rows($check) > 0) {
            $errors[] = 'Roll number already assigned to another student.';
        } else {
            $sql = "UPDATE students SET
                        name='$name', roll_number='$roll_number', section='$section',
                        age=$age, phone='$phone', email='$email'
                    WHERE id=$id";
            if (mysqli_query($conn, $sql)) {
                $success = 'Student updated successfully!';
                // Refresh student data
                $student = ['name'=>$name,'roll_number'=>$roll_number,'section'=>$section,
                            'age'=>$age,'phone'=>$phone,'email'=>$email];
            } else {
                $errors[] = 'Database error: ' . mysqli_error($conn);
            }
        }
    }
}

include 'includes/header.php';
?>

<div class="page-header">
    <h1>Edit Student</h1>
    <p>Update student information for <strong><?= htmlspecialchars($student['name']) ?></strong></p>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header"><i class="bi bi-pencil-square me-2"></i>Update Details</div>
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
                                value="<?= htmlspecialchars($_POST['name'] ?? $student['name']) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Roll Number <span style="color:var(--danger)">*</span></label>
                            <input type="text" name="roll_number" class="form-control"
                                value="<?= htmlspecialchars($_POST['roll_number'] ?? $student['roll_number']) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Section <span style="color:var(--danger)">*</span></label>
                            <select name="section" class="form-select" required>
                                <option value="">Select section</option>
                                <?php
                                $current_section = $_POST['section'] ?? $student['section'];
                                foreach (['A','B','C','D','E','F'] as $s) {
                                    $sel = ($current_section === $s) ? 'selected' : '';
                                    echo "<option value='$s' $sel>Section $s</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Age <span style="color:var(--danger)">*</span></label>
                            <input type="number" name="age" class="form-control"
                                min="1" max="100"
                                value="<?= htmlspecialchars($_POST['age'] ?? $student['age']) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone Number <span style="color:var(--danger)">*</span></label>
                            <input type="text" name="phone" class="form-control"
                                value="<?= htmlspecialchars($_POST['phone'] ?? $student['phone']) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email Address <span style="color:var(--danger)">*</span></label>
                            <input type="email" name="email" class="form-control"
                                value="<?= htmlspecialchars($_POST['email'] ?? $student['email']) ?>" required>
                        </div>
                    </div>

                    <div class="d-flex gap-3 mt-4">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle me-2"></i>Save Changes
                        </button>
                        <a href="view_students.php" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
