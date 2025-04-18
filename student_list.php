<?php
include 'db.php';

// Handle Delete operation
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    if ($conn->query("DELETE FROM students WHERE id = $id") === TRUE) {
        $msg = "Student deleted successfully!";
        $alertType = "success";
    } else {
        $msg = "Error: " . $conn->error;
        $alertType = "danger";
    }
}

// Retrieve all students
$sql = "SELECT id, name, student_id, department, major, email FROM students";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List</title>
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
        <h1 class="text-center">Student List</h1>

        <?php if (isset($msg)): ?>
            <div class="alert alert-<?= $alertType ?> alert-dismissible fade show" role="alert">
                <?= $msg ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        <?php endif; ?>

        <?php if ($result->num_rows > 0): ?>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Student ID</th>
                            <th>Department</th>
                            <th>Major</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row["name"] ?></td>
                                <td><?= $row["student_id"] ?></td>
                                <td><?= $row["department"] ?></td>
                                <td><?= $row["major"] ?></td>
                                <td><?= $row["email"] ?></td>
                                <td>
                                    <a href="index.php?edit=<?= $row["id"] ?>" class="btn btn-warning btn-sm">Update</a>
                                    <a href="student_list.php?delete=<?= $row["id"] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this student?')">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info">No data in the table</div>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>
</html>