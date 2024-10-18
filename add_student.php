<?php

if (!isset($_SESSION['user_id'])) {
    die("User is not logged in. Please log in first.");
}

$userId = $_SESSION['user_id'];


include 'db.php';
$sectionId = isset($_GET['section_id']) ? intval($_GET['section_id']) : 0;

if ($sectionId <= 0) {
    die("Invalid section ID.");
}


$sectionCheckQuery = "SELECT COUNT(*) AS count FROM sections WHERE id = $sectionId";
$result = mysqli_query($con, $sectionCheckQuery);
$row = mysqli_fetch_assoc($result);

if ($row['count'] == 0) {
    die("Invalid section ID.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_student'])) {

    $studentNumber = mysqli_real_escape_string($con, $_POST['student_number']);
    $studentName = mysqli_real_escape_string($con, $_POST['student_name']);
    $studentEmail = mysqli_real_escape_string($con, $_POST['student_email']);


    $query = "INSERT INTO students (user_id, section_id, student_number, student_name, email) 
              VALUES ($userId, $sectionId,'$studentNumber', '$studentName', '$studentEmail')";

    if (mysqli_query($con, $query)) {
        echo '<script>alert("Student added successfully!");window.location.href = "page.php?student&section_id=' . $sectionId . '";</script>';
    } else {
        echo "Error adding student: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
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
            color: #333;
        }

        form {
            margin-bottom: 20px;
        }

        form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        form input[type="text"],
        form input[type="email"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        form button {
            padding: 10px 20px;
            background-color: #3498db;
            border: none;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }

        form button:hover {
            background-color: #2980b9;
        }

        .back-button {
            display: inline-block;
            margin-bottom: 20px;
        }

        .back-button a {
            text-decoration: none;
            color: #3498db;
        }

        .back-button a:hover {
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

        p {
            color: lightslategrey;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="back-button">
            <a class="teacher-button" href="page.php?student&section_id=<?php echo htmlspecialchars($sectionId); ?>"> <svg width="54" height="74" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">

                    <circle cx="12" cy="12" r="10" fill="#E8F6F3" stroke="#00796B" stroke-width="2" />

                    <path d="M8 12H16M8 12L12 8M8 12L12 16" stroke="#00796B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg></a>
            <br>
            <br>
            <br>
            <br>
        </div>
        <h2>Add New Student</h2>
        <form method="POST" action="">
            <input type="hidden" name="section_id" value="<?php echo htmlspecialchars($sectionId); ?>">

            <label for="student_number">Student No:</label>
            <input type="text" id="student_number" name="student_number" placeholder="Enter Student Number" required>

            <label for="student_name">Student Name:<p>Surname, First Name MI</p></label>
            <input type="text" id="student_name" name="student_name" placeholder="Enter Student Name" required>

            <label for="student_email">Student Email:</label>
            <input type="email" id="student_email" name="student_email" placeholder="Enter Student Email" required>

            <button type="submit" name="add_student">Add Student</button>
        </form>
    </div>
</body>

</html>