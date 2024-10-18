<?php



if (!isset($_SESSION['user_id'])) {
    die("User is not logged in. Please log in first.");
}

$userId = $_SESSION['user_id'];


include 'db.php';


$student_id = isset($_GET['student_id']) ? intval($_GET['student_id']) : 0;
$section_id = isset($_GET['section_id']) ? intval($_GET['section_id']) : 0;


if ($student_id <= 0) {
    die("Invalid student ID.");
}


$studentQuery = "SELECT * FROM students WHERE id = $student_id AND user_id = $userId";
$result = mysqli_query($con, $studentQuery);

if (!$result || mysqli_num_rows($result) == 0) {
    die("Student not found.");
}

$student = mysqli_fetch_assoc($result);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentNumber = mysqli_real_escape_string($con, $_POST['student_number']);
    $studentName = mysqli_real_escape_string($con, $_POST['student_name']);
    $studentEmail = mysqli_real_escape_string($con, $_POST['student_email']);


    $updateQuery = "UPDATE students SET student_number='$studentNumber', student_name='$studentName', email='$studentEmail' WHERE id=$student_id AND user_id = $userId";

    if (mysqli_query($con, $updateQuery)) {
        echo '<script>alert("Student updated successfully!");window.location.href = "page.php?student&section_id=' . $student_id . '&section_id=' . $section_id . '";</script>';
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
    <link rel="icon" href="css/img/logo.ico">
    <style>
        .container {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 99vw;
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

        .teacher-button {
            position: absolute;
            top: 20px;
            left: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 60px;
            height: 80px;
            background: linear-gradient(135deg, #B2DFDB, #00796B);
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            text-decoration: none;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .teacher-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.3);
        }

        .teacher-button svg {
            transition: fill 0.2s;
        }

        .teacher-button:hover svg circle {
            fill: #E8F6F3;
        }

        .teacher-button:hover svg path {
            stroke: #E8F6F3;
        }
    </style>
</head>

<body>
    <div class="container">

        <div class="back-button">
            <a class="teacher-button" href="page.php?student&section_id=<?php echo htmlspecialchars($student['section_id']); ?>"><svg width="54" height="74" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">

                    <circle cx="12" cy="12" r="10" fill="#E8F6F3" stroke="#00796B" stroke-width="2" />

                    <path d="M8 12H16M8 12L12 8M8 12L12 16" stroke="#00796B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg></a>
        </div>
        <br>
        <br>
        <br>
        <br>
        <br>
        <h2>Edit Student</h2>

        <br>
        <form method="POST" action="">

            <label for="student_number">Student Number:</label>
            <input type="text" id="student_number" name="student_number" value="<?php echo htmlspecialchars($student['student_number']); ?>" required>

            <label for="student_name">Student Name:</label>
            <input type="text" id="student_name" name="student_name" value="<?php echo htmlspecialchars($student['student_name']); ?>" required>

            <label for="student_email">Student Email:</label>
            <input type="email" id="student_email" name="student_email" value="<?php echo htmlspecialchars($student['email']); ?>" required>


            <button type="submit">Update Student</button>
        </form>

    </div>
</body>

</html>