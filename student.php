<?php


if (!isset($_SESSION['user_id'])) {
    die("User is not logged in. Please log in first.");
}
$userId = $_SESSION['user_id'];

$sectionId = isset($_GET['section_id']) ? intval($_GET['section_id']) : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_student'])) {
        $studentName = mysqli_real_escape_string($con, $_POST['student_name']);
        $studentEmail = mysqli_real_escape_string($con, $_POST['student_email']);
        $query = "INSERT INTO students (user_id, section_id, student_name, email) VALUES ($userId, $sectionId, '$studentName', '$studentEmail')";
        if (mysqli_query($con, $query)) {
            echo '<script>alert("Student added successfully!");window.location.href = "page.php?student&section_id=' . $sectionId . '";</script>';
        } else {
            echo "Error adding student: " . mysqli_error($con);
        }
    }

    if (isset($_POST['add_activity'])) {
        $activityType = mysqli_real_escape_string($con, $_POST['activity_type']);
        $totalScore = intval($_POST['total_score']);

        $query = "INSERT INTO activities (section_id, user_id, activity_type, total_score) VALUES ($sectionId, $userId, '$activityType', $totalScore)";
        echo $query;

        if (mysqli_query($con, $query)) {
            echo '<script>alert("Activity added successfully!");window.location.href = "page.php?student&section_id=' . $sectionId . '";</script>';
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

        echo '<script>alert("Scores saved and activities updated successfully!");window.location.href = "page.php?student&section_id=' . $sectionId . '";</script>';
    }
}

$sectionQuery = "SELECT * FROM sections WHERE id = $sectionId";
$sectionResult = mysqli_query($con, $sectionQuery);
$section = mysqli_fetch_assoc($sectionResult);
$sectionName = htmlspecialchars($section['section_name']); // Ensure section name is escaped
$sectionId = intval($section['id']); // Ensure section ID is an integer

$studentsQuery = "SELECT * FROM students WHERE section_id = $sectionId AND user_id = $userId ORDER BY student_name ASC";
$studentsResult = mysqli_query($con, $studentsQuery);

if (!$studentsResult) {
    die("Error fetching students: " . mysqli_error($con));
}


$activitiesQuery = "SELECT * FROM activities WHERE section_id = $sectionId AND user_id = $userId";
$activitiesResult = mysqli_query($con, $activitiesQuery);

$scoresQuery = "SELECT * FROM scores WHERE student_id IN (SELECT id FROM students WHERE section_id = $sectionId) AND activity_id IN (SELECT id FROM activities WHERE section_id = $sectionId AND displayed = 1)";
$scoresResult = mysqli_query($con, $scoresQuery);

$scores = [];
while ($score = mysqli_fetch_assoc($scoresResult)) {
    $scores[$score['student_id']][$score['activity_id']] = $score['score'];
}
?>

<link rel="stylesheet" href="css/student.css">

<a href="page.php" class="teacher-button">
    <svg width="54" height="74" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">

        <circle cx="12" cy="12" r="10" fill="#E8F6F3" stroke="#00796B" stroke-width="2" />

        <path d="M8 12H16M8 12L12 8M8 12L12 16" stroke="#00796B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
    </svg>
</a>


<br>
<br>
<br>
<br>
<br>
<br>


<a href="page.php?student=add_student&section_id=<?php echo htmlspecialchars($sectionId); ?>" class="add-student-form">Add New Student</a>

<button type="button" onclick="window.location.href='page.php?student=most_at_risk&section_id=<?php echo $sectionId; ?>'" class="view">View MOST at Risk</button>

<form method="POST" action="upload_students.php?section_id=<?php echo $sectionId; ?>" enctype="multipart/form-data">
    <label for="file">Upload Excel File:</label>
    <input type="file" name="file" id="file" accept=".xlsx, .xls">
    <button type="submit">Upload</button>
</form>
<form method="POST" action="page.php?student&section_id=<?php echo $sectionId; ?>">
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

    <form method="POST" action="page.php?student&section_id=<?php echo $sectionId; ?>">
        <table>
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Email</th>
                    <?php
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
                mysqli_data_seek($activitiesResult, 0);
                while ($student = mysqli_fetch_assoc($studentsResult)) :
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars($student['student_name']); ?></td>
                        <td><?php echo htmlspecialchars($student['email']); ?></td>
                        <?php
                        mysqli_data_seek($activitiesResult, 0);
                        while ($activity = mysqli_fetch_assoc($activitiesResult)) :
                            $activityId = $activity['id'];
                            $score = isset($scores[$student['id']][$activityId]) ? $scores[$student['id']][$activityId] : '';

                            $studid = $student['id'];
                            $getscore = "SELECT * FROM scores WHERE activity_id = $activityId AND student_id = $studid";
                            $actscore = mysqli_query($con, $getscore);
                            $studscore = mysqli_fetch_assoc($actscore);
                        ?>
                            <td>
                                <input style=" all: unset; width: 100%; height: 100%; " type="number"
                                    name="scores[<?php echo $student['id']; ?>][<?php echo $activityId; ?>]"
                                    value="<?php echo htmlspecialchars($studscore['score']); ?>"
                                    min="0"
                                    max="<?php echo $activity['total_score']; ?>" />
                            </td>
                        <?php endwhile; ?>

                        <td class='actions'>
                            <a href="page.php?student=edit&student_id=<?php echo $student['id']; ?>&section_id=<?php echo $student['section_id']; ?>">Edit</a>
                            <a href='delete_student.php?id=<?php echo $student['id']; ?>' class='delete' onclick='return confirm("Are you sure?")'>Delete</a>
                            <a href="page.php?student=records&student_id=<?php echo $student['id']; ?>&section_id=<?php echo $student['section_id']; ?>">Records</a>

                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <button type="submit" name="save_scores">Save Scores</button>
    </form>
</div>