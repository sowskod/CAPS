<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("User is not logged in. Please log in first.");
}

$userId = $_SESSION['user_id'];

// Include the database connection file
include 'db.php';

// Fetch section ID
$sectionId = isset($_GET['section_id']) ? intval($_GET['section_id']) : 0;

// Handle student and activity addition
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_student'])) {
        $studentName = mysqli_real_escape_string($con, $_POST['student_name']);
        $studentEmail = mysqli_real_escape_string($con, $_POST['student_email']);
        $query = "INSERT INTO students (user_id, section_id, student_name, email) VALUES ($userId, $sectionId, '$studentName', '$studentEmail')";
        if (mysqli_query($con, $query)) {
            echo '<script>alert("Student added successfully!");window.location.href = "student.php?section_id=' . $sectionId . '";</script>';
        } else {
            echo "Error adding student: " . mysqli_error($con);
        }
    }

    if (isset($_POST['add_activity'])) {
        $activityType = mysqli_real_escape_string($con, $_POST['activity_type']);
        $totalScore = intval($_POST['total_score']);
        $query = "INSERT INTO activities (section_id, user_id, activity_type, total_score) VALUES ($sectionId, $userId, '$activityType', $totalScore)";
        if (mysqli_query($con, $query)) {
            echo '<script>alert("Activity added successfully!");window.location.href = "student.php?section_id=' . $sectionId . '";</script>';
        } else {
            echo "Error adding activity: " . mysqli_error($con);
        }
    }

    if (isset($_POST['save_scores'])) {
        $scoresDeletedActivities = [];
        foreach ($_POST['scores'] as $studentId => $activities) {
            foreach ($activities as $activityId => $score) {
                $studentId = intval($studentId);
                $activityId = intval($activityId);
                $score = intval($score);

                $query = "INSERT INTO scores (student_id, activity_id, score) VALUES ($studentId, $activityId, $score)
                          ON DUPLICATE KEY UPDATE score = VALUES(score)";
                if (!mysqli_query($con, $query)) {
                    echo "Error saving score: " . mysqli_error($con);
                }

                $scoresDeletedActivities[] = $activityId;
            }
        }

        if (!empty($scoresDeletedActivities)) {
            $activityIds = implode(',', array_unique($scoresDeletedActivities));
            $updateActivitiesQuery = "UPDATE activities SET displayed = 0 WHERE id IN ($activityIds)";
            if (!mysqli_query($con, $updateActivitiesQuery)) {
                echo "Error updating activities display status: " . mysqli_error($con);
            }
        }

        echo '<script>alert("Scores saved and activities updated successfully!");window.location.href = "student.php?section_id=' . $sectionId . '";</script>';
    }
}

// Fetch section details
$sectionQuery = "SELECT * FROM sections WHERE id = $sectionId";
$sectionResult = mysqli_query($con, $sectionQuery);
$section = mysqli_fetch_assoc($sectionResult);
$sectionName = htmlspecialchars($section['section_name']); // Ensure section name is escaped
$sectionId = intval($section['id']); // Ensure section ID is an integer

// Fetch students in the selected section, sorted by student_name
$studentsQuery = "SELECT * FROM students WHERE section_id = $sectionId AND user_id = $userId ORDER BY student_name ASC";
$studentsResult = mysqli_query($con, $studentsQuery);

// Check if query execution was successful
if (!$studentsResult) {
    die("Error fetching students: " . mysqli_error($con));
}


// Fetch activities for the selected section
$activitiesQuery = "SELECT * FROM activities WHERE section_id = $sectionId AND user_id = $userId AND displayed = 1";
$activitiesResult = mysqli_query($con, $activitiesQuery);

// Fetch scores for each student and activity
$scoresQuery = "SELECT * FROM scores WHERE student_id IN (SELECT id FROM students WHERE section_id = $sectionId) AND activity_id IN (SELECT id FROM activities WHERE section_id = $sectionId AND displayed = 1)";
$scoresResult = mysqli_query($con, $scoresQuery);

// Organize scores in an associative array
$scores = [];
while ($score = mysqli_fetch_assoc($scoresResult)) {
    $scores[$score['student_id']][$score['activity_id']] = $score['score'];
}
?>


<!-- HTML Part -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
        }

        a {
            color: #3498db;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .back-button {
            position: absolute;
            top: 20px;
            left: 20px;
            text-decoration: none;
            color: #333;
        }

        .back-button svg {
            vertical-align: middle;
        }

        .add-student-form,
        .view {
            display: inline-block;
            padding: 10px 20px;
            margin-bottom: 20px;
            background-color: #3498db;
            color: white;
            border-radius: 4px;
            text-align: center;
        }

        .add-student-form:hover,
        .view:hover {
            background-color: #2980b9;
        }

        form {
            margin-bottom: 20px;
        }

        form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        form input[type="file"] {
            margin-bottom: 10px;

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

        .students {
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        .actions a {
            margin-right: 10px;
            color: #3498db;
        }

        .actions a.delete {
            color: #e74c3c;
        }

        .actions a.delete:hover {
            text-decoration: underline;
        }

        .actions a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            table {
                font-size: 14px;
            }

            th,
            td {
                padding: 8px;
            }
        }
    </style>
</head>

<body>
    <a href="homepage.php" style="position: absolute; top: 0px; left: 20px; text-decoration: none; color: black;">
        <svg width="54" height="74" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <!-- Outer circle -->
            <circle cx="12" cy="12" r="10" fill="#F7F7F7" stroke="black" stroke-width="2" />
            <!-- Inner arrow shape -->
            <path d="M8 12H16M8 12L12 8M8 12L12 16" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
    </a>

    <br>
    <br>
    <br>
    <br>


    <a href="add_student.php?section_id=<?php echo htmlspecialchars($sectionId); ?>" class="add-student-form">Add New Student</a>
    <button type="button" onclick="window.location.href='most_at_risk.php?section_id=<?php echo $sectionId; ?>'" class="view">View MOST at Risk</button>
    <form method="POST" action="upload_students.php?section_id=<?php echo $sectionId; ?>" enctype="multipart/form-data">
        <label for="file">Upload Excel File:</label>
        <input type="file" name="file" id="file" accept=".xlsx, .xls">
        <button type="submit">Upload</button>
    </form>
    <form method="POST" action="student.php?section_id=<?php echo $sectionId; ?>">
        <h3>Add Activity</h3>
        <label for="activity_type">Activity Type:</label>
        <select name="activity_type" id="activity_type" required>
            <option value="quiz">Quiz</option>
            <option value="exam">Exam</option>
            <option value="activity">Activity</option>
            <option value="attendance">Attendance</option>
        </select>
        <label for="total_score">Total Score:</label>
        <input type="number" name="total_score" id="total_score" placeholder="Input Total or over score" required>
        <button type="submit" name="add_activity">Add Activity</button>
    </form>



    <div class="students">
        <h2>Students in Section <?php echo htmlspecialchars($sectionName); ?></h2>

        <form method="POST" action="student.php?section_id=<?php echo $sectionId; ?>">
            <table>
                <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Program</th>
                        <th>Course</th>
                        <th>timestamp</th>
                        <?php
                        // Reset activities result pointer for score input
                        mysqli_data_seek($activitiesResult, 0);
                        while ($activity = mysqli_fetch_assoc($activitiesResult)) :
                        ?>
                            <th><?php echo htmlspecialchars($activity['activity_type']); ?> (<?php echo htmlspecialchars($activity['total_score']); ?>)</th>
                        <?php endwhile; ?>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Reset activities result pointer for score input
                    mysqli_data_seek($activitiesResult, 0);
                    while ($student = mysqli_fetch_assoc($studentsResult)) :
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($student['student_name']); ?></td>
                            <td><?php echo htmlspecialchars($student['email']); ?></td>
                            <td><?php echo htmlspecialchars($student['cp_number']); ?></td>
                            <td><?php echo htmlspecialchars($student['program']); ?></td>
                            <td><?php echo htmlspecialchars($student['course']); ?></td>
                            <td><?php echo htmlspecialchars($student['timestamp']); ?></td>
                            <?php
                            // Reset activities result pointer to start
                            mysqli_data_seek($activitiesResult, 0);
                            while ($activity = mysqli_fetch_assoc($activitiesResult)) :
                                $activityId = $activity['id'];
                                $score = isset($scores[$student['id']][$activityId]) ? $scores[$student['id']][$activityId] : '';
                            ?>
                                <td>
                                    <input type="number" name="scores[<?php echo $student['id']; ?>][<?php echo $activityId; ?>]" value="<?php echo htmlspecialchars($score); ?>" min="0" max="<?php echo $activity['total_score']; ?>" />
                                </td>
                            <?php endwhile; ?>
                            <td class='actions'>
                                <a href='edit_student.php?id=<?php echo $student['id']; ?>'>Edit</a>
                                <a href='delete_student.php?id=<?php echo $student['id']; ?>' class='delete' onclick='return confirm("Are you sure?")'>Delete</a>
                                <a href='student_records.php?student_id=<?php echo $student['id']; ?>'>Records</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <button type="submit" name="save_scores">Save Scores</button>
        </form>


    </div>

</body>

</html>