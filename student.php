<?php
include 'score_update.php';

if (!isset($_SESSION['user_id'])) {
    die("User is not logged in. Please log in first.");
}
$userId = $_SESSION['user_id'];

$sectionId = isset($_GET['section_id']) ? intval($_GET['section_id']) : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_student'])) {
        $studentNumber = mysqli_real_escape_string($con, $_POST['student_number']);
        $studentName = mysqli_real_escape_string($con, $_POST['student_name']);
        $studentEmail = mysqli_real_escape_string($con, $_POST['student_email']);
        $query = "INSERT INTO students (user_id, student_number, student_name, email) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, 'iiss', $userId, $studentNumber, $studentName, $studentEmail);

        if (mysqli_stmt_execute($stmt)) {
            echo '<script>alert("Student added successfully!");window.location.href = "page.php?student&section_id=' . $sectionId . '";</script>';
        } else {
            echo "Error adding student: " . mysqli_error($con);
        }
        mysqli_stmt_close($stmt);
    }

    if (isset($_POST['add_activity'])) {
        $activityType = mysqli_real_escape_string($con, $_POST['activity_type']);
        $totalScore = intval($_POST['total_score']);
        $query = "INSERT INTO activities (section_id, user_id, activity_type, total_score) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, 'iisi', $sectionId, $userId, $activityType, $totalScore);

        if (mysqli_stmt_execute($stmt)) {
            echo '<script>alert("Activity added successfully!");window.location.href = "page.php?student&section_id=' . $sectionId . '";</script>';
        } else {
            echo "Error adding activity: " . mysqli_error($con);
        }
        mysqli_stmt_close($stmt);
    }

    if (isset($_POST['save_scores'])) {
        updateScores($con, $userId, $sectionId, $_POST['scores']);
    }
}

$sectionQuery = "SELECT * FROM sections WHERE id = ?";
$sectionStmt = mysqli_prepare($con, $sectionQuery);
mysqli_stmt_bind_param($sectionStmt, 'i', $sectionId);
mysqli_stmt_execute($sectionStmt);
$sectionResult = mysqli_stmt_get_result($sectionStmt);
$section = mysqli_fetch_assoc($sectionResult);
$sectionName = htmlspecialchars($section['section_name']);
$sectionId = intval($section['id']);
mysqli_stmt_close($sectionStmt);

$studentsQuery = "SELECT * FROM students WHERE section_id = ? AND user_id = ? ORDER BY student_name ASC";
$studentsStmt = mysqli_prepare($con, $studentsQuery);
mysqli_stmt_bind_param($studentsStmt, 'ii', $sectionId, $userId);
mysqli_stmt_execute($studentsStmt);
$studentsResult = mysqli_stmt_get_result($studentsStmt);

if (!$studentsResult) {
    die("Error fetching students: " . mysqli_error($con));
}

$activitiesQuery = "SELECT * FROM activities WHERE section_id = ? AND user_id = ?";
$activitiesStmt = mysqli_prepare($con, $activitiesQuery);
mysqli_stmt_bind_param($activitiesStmt, 'ii', $sectionId, $userId);
mysqli_stmt_execute($activitiesStmt);
$activitiesResult = mysqli_stmt_get_result($activitiesStmt);

$scoresQuery = "SELECT * FROM scores WHERE student_id IN (SELECT id FROM students WHERE section_id = ?) AND activity_id IN (SELECT id FROM activities WHERE section_id = ? AND displayed = 1)";
$scoresStmt = mysqli_prepare($con, $scoresQuery);
mysqli_stmt_bind_param($scoresStmt, 'ii', $sectionId, $sectionId);
mysqli_stmt_execute($scoresStmt);
$scoresResult = mysqli_stmt_get_result($scoresStmt);

$scores = [];
while ($score = mysqli_fetch_assoc($scoresResult)) {
    $scores[$score['student_id']][$score['activity_id']] = $score['score'];
}
mysqli_stmt_close($scoresStmt);
?>

<link rel="stylesheet" href="css/student.css">

<div id="notification" style="display:none; position:sticky; top:0; left:50%; top: 20px; background-color:#4CAF50; color:white; padding:10px; z-index:1000;">Scores saved successfully!</div>

<a href="page.php" class="teacher-button">
    <svg width="54" height="74" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <circle cx="12" cy="12" r="10" fill="#E8F6F3" stroke="#00796B" stroke-width="2" />
        <path d="M8 12H16M8 12L12 8M8 12L12 16" stroke="#00796B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
    </svg>
</a>

<div class="toppart">
    <div class="configs">
        <div class="mainbtns">
            <a href="page.php?student=add_student&section_id=<?php echo htmlspecialchars($sectionId); ?>" class="add-student-form">Add New Student</a>
            <button type="button" onclick="window.location.href='page.php?student=most_at_risk&section_id=<?php echo $sectionId; ?>'" class="view">View MOST at Risk</button>
        </div>

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
            <input type="number" name="total_score" id="total_score" min="10" placeholder="Input Total or over score" required>
            <button type="submit" name="add_activity">Add Activity</button>
        </form>
    </div>
    <div class="hits">
        <style>
            .hits {
                background-color: #E8F6F3;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                margin-top: 20px;
            }

            h1 {
                color: #4CAF50;
                text-align: center;
                margin-bottom: 20px;
            }

            ol {

                background: #fff;
                border-radius: 8px;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                margin: 0 auto;
                padding: 25px 50px;
                padding-left: 50px;
                margin-bottom: 20px;

            }

            li {
                margin-bottom: 15px;
                font-size: 20px;
            }

            a {
                color: #007BFF;
                text-decoration: none;
            }

            a:hover {
                text-decoration: underline;
            }

            .footer {
                color: gray;
                text-align: center;
                margin-top: 20px;
                font-size: 14px;
            }
        </style>

        <h1>Instructions for Uploading Students via Excel</h1>
        <ol>
            <li>
                Go to the link and make a copy of your form:
                <a href="https://docs.google.com/forms/d/1xmoafAtRgYG48hRnGRLs7L3dw-sIxJK4Aa1oIZ-roac/copy" target="_blank">Google Form Link</a>
            </li>
            <li>
                After creating your own form, send it to your student class.
            </li>
            <li>
                Once all students have answered the form, download the responses as an Excel file.
            </li>
        </ol>
        <h3>That's it! Upload the Excel file as needed.</h3>

        <div class="footer">
            <h3>Thank you for your cooperation!</h3>
        </div>
    </div>
</div>

<div class="students">
    <h2>Students in Section <?php echo htmlspecialchars($sectionName); ?></h2>
    <form method="POST" action="page.php?student&section_id=<?php echo $sectionId; ?>" style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th>STUDENT NO:</th>
                    <th>FULLNAME (Surname, Firstname MI)</th>
                    <th>Email</th>
                    <?php
                    mysqli_data_seek($activitiesResult, 0);
                    while ($activity = mysqli_fetch_assoc($activitiesResult)) :
                    ?>
                        <th><?php echo htmlspecialchars($activity['activity_type']); ?> (<?php echo htmlspecialchars($activity['total_score']); ?>)</th>
                    <?php endwhile; ?>
                    <th style=" width: 100%; ">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                mysqli_data_seek($activitiesResult, 0);
                while ($student = mysqli_fetch_assoc($studentsResult)) :
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars($student['student_number']); ?></td>
                        <td style="text-wrap: nowrap;"><?php echo htmlspecialchars($student['student_name']); ?></td>
                        <td><?php echo htmlspecialchars($student['email']); ?></td>
                        <?php
                        mysqli_data_seek($activitiesResult, 0);
                        while ($activity = mysqli_fetch_assoc($activitiesResult)) :
                            $activityId = $activity['id'];
                            $score = isset($scores[$student['id']][$activityId]) ? $scores[$student['id']][$activityId] : '';

                            $studid = $student['id'];
                            $getscore = "SELECT * FROM scores WHERE activity_id = ? AND student_id = ?";
                            $actscoreStmt = mysqli_prepare($con, $getscore);
                            mysqli_stmt_bind_param($actscoreStmt, 'ii', $activityId, $studid);
                            mysqli_stmt_execute($actscoreStmt);
                            $actscoreResult = mysqli_stmt_get_result($actscoreStmt);
                            $studscore = mysqli_fetch_assoc($actscoreResult);
                            mysqli_stmt_close($actscoreStmt);

                        ?>
                            <td>
                                <input style="all: unset; width: 100%; height: 100%;" type="number"
                                    name="scores[<?php echo $student['id']; ?>][<?php echo $activityId; ?>]"
                                    value="<?php echo htmlspecialchars(isset($studscore['score']) ? $studscore['score'] : 0); ?>"
                                    min="0"
                                    max="<?php echo $activity['total_score']; ?>"
                                    onchange="saveScore(<?php echo $student['id']; ?>, <?php echo $activityId; ?>, this.value)" />
                            </td>
                        <?php endwhile; ?>

                        <td class='actions' style="text-wrap: nowrap;">
                            <a href="page.php?student=edit&student_id=<?php echo $student['id']; ?>&section_id=<?php echo $student['section_id']; ?>">Edit</a>
                            <a href='delete_student.php?id=<?php echo $student['id']; ?>' class='delete' onclick='return confirm("Are you sure?")'>Delete</a>
                            <a href="page.php?student=records&student_id=<?php echo $student['id']; ?>&section_id=<?php echo $student['section_id']; ?>">Records</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <input type="hidden" name="save_scores" value="1">
        <button type="submit" name="save_scores">Save Scores</button>
    </form>
</div>

<script>
    function saveScore(studentId, activityId, score) {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "page.php?student", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    document.getElementById("notification").style.display = "block";
                    setTimeout(function() {
                        document.getElementById("notification").style.display = "none";
                    }, 3000);
                } else {
                    console.error("Error saving score: " + xhr.statusText);
                    alert("Error saving score: " + xhr.statusText);
                }
            }
        };

        console.log("Saving score for Student ID: " + studentId + ", Activity ID: " + activityId + ", Score: " + score);

        xhr.send("save_scores=1&scores[" + studentId + "][" + activityId + "]=" + encodeURIComponent(score));
    }
</script>