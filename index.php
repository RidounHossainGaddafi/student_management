<?php
include 'db.php';

$msg = '';
$alertType = '';
$edit = null;

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result = $conn->query("SELECT * FROM students WHERE id = $id");
    if ($result->num_rows > 0) {
        $edit = $result->fetch_assoc();
    } else {
        $msg = "Student not found!";
        $alertType = "danger";
    }
}

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $student_id = $_POST['student_id'];
    $department = $_POST['department'];
    $major = $_POST['major'];
    $dob = $_POST['dob'];
    $address = $_POST['address'];

    // Validate mandatory fields
    if (empty($name) || empty($email)) {
        $msg = "Name and Email are required!";
        $alertType = "danger";
    } else {
        // Check if email already exists (excluding the current student during update)
        $email_check_query = "SELECT * FROM students WHERE email = '$email'";
        if (isset($_POST['id']) && !empty($_POST['id'])) {
            $id = $_POST['id'];
            $email_check_query .= " AND id != $id";
        }
        $email_check_query .= " LIMIT 1";
        $result = $conn->query($email_check_query);
        if ($result->num_rows > 0) {
            $msg = "Error: Email is already registered!";
            $alertType = "danger";
        } else {
            if (isset($_POST['id']) && !empty($_POST['id'])) {
                // Update existing student
                $id = $_POST['id'];
                $sql = "UPDATE students SET name='$name', email='$email', student_id='$student_id', 
                        department='$department', major='$major', dob='$dob', address='$address' WHERE id=$id";
                $msg = "Student updated successfully!";
                $alertType = "success";
            } else {
                // Insert new student
                $sql = "INSERT INTO students (name, email, student_id, department, major, dob, address) 
                        VALUES ('$name', '$email', '$student_id', '$department', '$major', '$dob', '$address')";
                $msg = "Student registered successfully!";
                $alertType = "success";
            }
            if ($conn->query($sql) !== TRUE) {
                $msg = "Error: " . $conn->error;
                $alertType = "danger";
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
    <title>Student Registration</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>
    <div class="navbar">
        <img src="https://postimg.cc/680ZvPZj" alt="Daffodil International University Logo">
        <span class="title">StudentManager</span>
        <a href="index.php">Add Student</a>
        <a href="student_list.php">Student List</a>
        <a href="enroll.php">Enroll in Course</a>
        <a href="enrollment_history.php">Enrollment History</a>
    </div>

    <div class="container">
        <h1 class="text-center"><?= isset($edit) ? 'Update Student' : 'Student Registration' ?></h1>

        <?php if ($msg): ?>
            <div class="alert alert-<?= $alertType ?> alert-dismissible fade show" role="alert">
                <?= $msg ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        <?php endif; ?>

        <form action="index.php" method="POST" class="needs-validation" novalidate>
            <input type="hidden" name="id" value="<?= isset($edit) ? $edit['id'] : '' ?>">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= isset($edit) ? $edit['name'] : '' ?>" required>
                <div class="invalid-feedback">Please enter a name.</div>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= isset($edit) ? $edit['email'] : '' ?>" required>
                <div class="invalid-feedback">Please enter a valid email.</div>
            </div>
            <div class="form-group">
                <label for="student_id">Student ID:</label>
                <input type="text" class="form-control" id="student_id" name="student_id" value="<?= isset($edit) ? $edit['student_id'] : '' ?>">
            </div>
            <div class="form-group">
                <label for="department">Department:</label>
                <select class="form-control" id="department" name="department">
                    <option value="">Select Department</option>
                    <option value="CSE" <?= isset($edit) && $edit['department'] == 'CSE' ? 'selected' : '' ?>>CSE</option>
                    <option value="EEE" <?= isset($edit) && $edit['department'] == 'EEE' ? 'selected' : '' ?>>EEE</option>
                    <option value="BBA" <?= isset($edit) && $edit['department'] == 'BBA' ? 'selected' : '' ?>>BBA</option>
                </select>
            </div>
            <div class="form-group">
                <label for="major">Major:</label>
                <select class="form-control" id="major" name="major">
                    <option value="">Select Major</option>
                    <option value="Computer Science" <?= isset($edit) && $edit['major'] == 'Computer Science' ? 'selected' : '' ?>>Computer Science</option>
                    <option value="Electrical Engineering" <?= isset($edit) && $edit['major'] == 'Electrical Engineering' ? 'selected' : '' ?>>Electrical Engineering</option>
                    <option value="Business Administration" <?= isset($edit) && $edit['major'] == 'Business Administration' ? 'selected' : '' ?>>Business Administration</option>
                </select>
            </div>
            <div class="form-group">
                <label for="dob">Date of Birth:</label>
                <input type="date" class="form-control" id="dob" name="dob" value="<?= isset($edit) ? $edit['dob'] : '' ?>">
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <textarea class="form-control" id="address" name="address"><?= isset($edit) ? $edit['address'] : '' ?></textarea>
            </div>
            <div class="text-center">
                <button type="submit" name="submit" class="btn btn-primary"><?= isset($edit) ? 'Update' : 'Submit' ?></button>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>
</html>