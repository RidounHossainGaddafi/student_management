<?php
include 'db.php';

$msg = '';
$alertType = '';
$student_id = '';
$result = null;

if (isset($_POST['search'])) {
    $student_id = $_POST['student_id'];
    if (empty($student_id)) {
        $msg = "Please enter a Student ID!";
        $alertType = "danger";
    } else {
        $sql = "SELECT course_code, course_title, semester, grade FROM enrollments WHERE student_id = '$student_id'";
        $result = $conn->query($sql);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollment History</title>
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
        <h1 class="text-center">Enrollment History</h1>

        <form action="enrollment_history.php" method="POST" class="needs-validation" novalidate>
            <div class="form-group">
                <label for="student_id">Student ID:</label>
                <input type="text" class="form-control" id="student_id" name="student_id" value="<?= $student_id ?>" required>
                <div class="invalid-feedback">Please enter a Student ID.</div>
            </div>
            <div class="text-center">
                <button type="submit" name="search" class="btn btn-primary">Search</button>
            </div>
        </form>

        <?php if ($msg): ?>
            <div class="alert alert-<?= $alertType ?> alert-dismissible fade show mt-3" role="alert">
                <?= $msg ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <?php if ($result): ?>
            <?php if ($result->num_rows > 0): ?>
                <div class="table-responsive mt-3">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Course Code</th>
                                <th>Course Title</th>
                                <th>Semester</th>
                                <th>Grade</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $row["course_code"] ?></td>
                                    <td><?= $row["course_title"] ?></td>
                                    <td><?= $row["semester"] ?></td>
                                    <td><?= $row["grade"] ? $row["grade"] : 'N/A' ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-info mt-3">No data available</div>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>
</html>