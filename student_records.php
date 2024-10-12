<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("User is not logged in. Please log in first.");
}

$userId = $_SESSION['user_id'];

// Include the database connection file
include 'db.php';

$studentId = isset($_GET['student_id']) ? intval($_GET['student_id']) : 0;

// Fetch the student's details
$studentQuery = "SELECT id, student_name, section_id FROM students WHERE id = $studentId";
$studentResult = mysqli_query($con, $studentQuery);

if (!$studentResult) {
    die("Query failed: " . mysqli_error($con));
}

$studentRow = mysqli_fetch_assoc($studentResult);

if ($studentRow) {
    $studentName = $studentRow['student_name'];
    $sectionId = $studentRow['section_id'];
} else {
    die("Student not found.");
}

// Fetch the student's scores including timestamp
$query = "
    SELECT a.activity_type, sc.score, a.total_score, sc.id AS score_id, sc.created_at
    FROM scores sc 
    JOIN activities a ON sc.activity_id = a.id 
    WHERE sc.student_id = $studentId
";
$result = mysqli_query($con, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($con));
}

if (mysqli_num_rows($result) === 0) {
    echo "No records found.";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Records</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
            font-size: 24px;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        thead {
            background-color: #3498db;
            color: #fff;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        td {
            color: #333;
        }

        a {
            color: #3498db;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        .actions a {
            margin-right: 10px;
        }

        .actions a.delete {
            color: #e74c3c;
        }

        .actions a.delete:hover {
            text-decoration: underline;
        }

        .back-button {
            display: block;
            width: fit-content;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #3498db;
            color: #fff;
            text-align: center;
            border-radius: 4px;
            text-decoration: none;
        }

        .back-button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Records for <?php echo htmlspecialchars($studentName); ?></h2>
        <table>
            <thead>
                <tr>
                    <th>Activity Type</th>
                    <th>Score</th>
                    <th>Total Score</th>
                    <th>Date and Time</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['activity_type']); ?></td>
                        <td><?php echo htmlspecialchars($row['score']); ?></td>
                        <td><?php echo htmlspecialchars($row['total_score']); ?></td>
                        <td><?php echo htmlspecialchars(date('Y-m-d H:i:s', strtotime($row['created_at']))); ?></td>
                        <td class="actions">
                            <a href="edit_score.php?score_id=<?php echo htmlspecialchars($row['score_id']); ?>">Edit</a>
                            <a href="delete_score.php?score_id=<?php echo htmlspecialchars($row['score_id']); ?>" class="delete" onclick="return confirm('Are you sure you want to delete this score?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <a href="print.php?student_id=<?php echo htmlspecialchars($studentId); ?>" class="mt-4 bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">Print PDF</a>
        <a href="student.php?section_id=<?php echo htmlspecialchars($sectionId); ?>" class="back-button">Back to Students List</a>
    </div>
</body>
</html>
