<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("User is not logged in. Please log in first.");
}

$userId = $_SESSION['user_id'];

// Include the database connection file
include 'db.php';

// Retrieve student_id from the URL
$studentId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Validate student_id
if ($studentId <= 0) {
    die("Invalid student ID.");
}

// Fetch student details to display in the form
$studentQuery = "SELECT * FROM students WHERE id = $studentId AND user_id = $userId";
$result = mysqli_query($con, $studentQuery);

if (!$result || mysqli_num_rows($result) == 0) {
    die("Student not found.");
}

$student = mysqli_fetch_assoc($result);

// Handle the form submission to update the student
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentName = mysqli_real_escape_string($con, $_POST['student_name']);
    $studentEmail = mysqli_real_escape_string($con, $_POST['student_email']);
    $cpNumber = mysqli_real_escape_string($con, $_POST['cp_number']);
    $program = mysqli_real_escape_string($con, $_POST['program']);
    $course = mysqli_real_escape_string($con, $_POST['course']);

    $updateQuery = "UPDATE students SET student_name='$studentName', email='$studentEmail', cp_number='$cpNumber', program='$program', course='$course' WHERE id=$studentId AND user_id = $userId";

    if (mysqli_query($con, $updateQuery)) {
        echo '<script>alert("Student updated successfully!");window.location.href = "student.php?section_id=' . $student['section_id'] . '";</script>';
    } else {
        echo "Error updating student: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <!-- Add your styles here -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
            padding: 20px;
            box-sizing: border-box;
        }

        h2 {
            margin-top: 0;
            color: #007bff;
            font-size: 24px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }

        input[type="text"],
        input[type="email"] {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 10px;
            margin-bottom: 15px;
            font-size: 16px;
            color: #333;
        }

        button {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        a {
            display: inline-block;
            margin-top: 15px;
            text-decoration: none;
            color: #007bff;
            font-size: 16px;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Edit Student</h2>
    <form method="POST" action="">
        <label for="student_name">Student Name:</label>
        <input type="text" id="student_name" name="student_name" value="<?php echo htmlspecialchars($student['student_name']); ?>" required>

        <label for="student_email">Student Email:</label>
        <input type="email" id="student_email" name="student_email" value="<?php echo htmlspecialchars($student['email']); ?>" required>

        <label for="cp_number">Cellphone Number:</label>
        <input type="text" id="cp_number" name="cp_number" value="<?php echo htmlspecialchars($student['cp_number']); ?>" required>

        <label for="program">Program:</label>
        <input type="text" id="program" name="program" value="<?php echo htmlspecialchars($student['program']); ?>" required>

        <label for="course">Course:</label>
        <input type="text" id="course" name="course" value="<?php echo htmlspecialchars($student['course']); ?>" required>

        <button type="submit">Update Student</button>
    </form>
    <a href="student.php?section_id=<?php echo htmlspecialchars($student['section_id']); ?>">Back to Students List</a>
</div>
</body>
</html>
