<?php
include 'db.php';

$msg = '';
$alertType = '';

if (isset($_POST['submit'])) {
    $student_id = $_POST['student_id'];
    $course_code = $_POST['course_code'];
    $course_title = $_POST['course_title'];
    $semester = $_POST['semester'];

    // Validate mandatory fields
    if (empty($student_id) || empty($course_code)) {
        $msg = "Student ID and Course Code are required!";
        $alertType = "danger";
    } else {
        // Insert enrollment
        $sql = "INSERT INTO enrollments (student_id, course_code, course_title, semester) 
                VALUES ('$student_id', '$course_code', '$course_title', '$semester')";
        if ($conn->query($sql) === TRUE) {
            $msg = "Enrollment successful!";
            $alertType = "success";
        } else {
            $msg = "Error: " . $conn->error;
            $alertType = "danger";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Enrollment</title>
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
        <h1 class="text-center">Course Enrollment</h1>

        <?php if ($msg): ?>
            <div class="alert alert-<?= $alertType ?> alert-dismissible fade show" role="alert">
                <?= $msg ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <form action="enroll.php" method="POST" class="needs-validation" novalidate>
            <div class="form-group">
                <label for="student_id">Student ID:</label>
                <input type="text" class="form-control" id="student_id" name="student_id" required>
                <div class="invalid-feedback">Please enter a Student ID.</div>
            </div>
            <div class="form-group">
                <label for="course_code">Course Code:</label>
                <input type="text" class="form-control" id="course_code" name="course_code" required>
                <div class="invalid-feedback">Please enter a Course Code.</div>
            </div>
            <div class="form-group">
                <label for="course_title">Course Title:</label>
                <input type="text" class="form-control" id="course_title" name="course_title">
            </div>
            <div class="form-group">
                <label for="semester">Semester:</label>
                <select class="form-control" id="semester" name="semester">
                    <option value="">Select Semester</option>
                    <option value="Spring 2025">Spring 2025</option>
                    <option value="Fall 2025">Fall 2025</option>
                    <option value="Summer 2025">Summer 2025</option>
                </select>
            </div>
            <div class="text-center">
                <button type="submit" name="submit" class="btn btn-primary">Enroll</button>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>
</html>