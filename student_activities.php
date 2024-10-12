<?php
include 'db.php';

if (!isset($_GET['student_id']) || empty($_GET['student_id'])) {
    die('Error: Missing student ID.');
}

$student_id = $_GET['student_id'];

// Fetch student information
$student_result = $con->query("SELECT student_name FROM students WHERE id=$student_id");
if ($student_result->num_rows == 0) {
    die('Error: Student not found.');
}
$student = $student_result->fetch_assoc();
$student_name = $student['student_name'];
if (isset($_GET['print_pdf'])) {
    // Include TCPDF library
    require_once('tcpdf/tcpdf.php');

    // Create a new PDF instance
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('JAYR');
    $pdf->SetTitle('Student Records');
    $pdf->SetSubject('Student Records');
    $pdf->SetKeywords('Student, Records, Activities');

    // Remove default header/footer
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);

    // Add a page
    $pdf->AddPage();

    // Generate HTML content for PDF
    $html_content = '
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }
        th {
            font-weight: bold;
            border: 20px solid #000;
            background-color: #f2f2f2;
        }
        h1 {
            text-align: center;
        }
    </style>
    <h1>Student Records</h1>
    <h6>Student Name:<h5>'. $student_name . '</h5>';


    // Fetch filtered records
    $filter_type = isset($_GET['filter_type']) ? $_GET['filter_type'] : 'all';
    $filter_condition = '';

    if ($filter_type !== 'all') {
        $filter_condition = " AND activity_type='$filter_type'";
    }

    $result = $con->query("SELECT * FROM student_activities WHERE student_id=$student_id $filter_condition");

    // Add table for filtered records
    $html_content .= '<table>';
    $html_content .= '<tr><th>ID</th><th>Record Type</th><th>Score</th><th>Total Score</th><th>Date</th></tr>';
    while ($row = $result->fetch_assoc()) {
        $html_content .= '<tr>';
        $html_content .= '<td>' . $row['id'] . '</td>';
        $html_content .= '<td>' . $row['activity_type'] . '</td>';
        $html_content .= '<td>' . $row['score'] . '</td>';
        $html_content .= '<td>' . $row['total_score'] . '</td>';
        $html_content .= '<td>' . $row['datetime'] . '</td>';
        $html_content .= '</tr>';
    }
    $html_content .= '</table>';

    // Write HTML content to PDF
    $pdf->writeHTML($html_content, true, false, true, false, '');

    // Output PDF
    $pdf->Output('student_records.pdf', 'I');
    exit;
}

// Fetch activities with applied filter
$filter_type = isset($_GET['filter_type']) ? $_GET['filter_type'] : 'all';
$filter_condition = '';

if ($filter_type !== 'all') {
    // Filter condition based on the selected filter type
    $filter_condition = " AND activity_type='$filter_type'";
}
// Add or Update activity
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save_activity'])) {
    $activity_id = $_POST['activity_id'] ?? null;
    $activity_type = $_POST['activity_type'];
    $score = $_POST['score'];
    $total_score = $_POST['total_score'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $datetime = $date . ' ' . $time;

    if ($activity_id) {
        // Update existing activity
        $query = "UPDATE student_activities SET activity_type=?, score=?, total_score=?, datetime=? WHERE id=? AND student_id=?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("ssssii", $activity_type, $score, $total_score, $datetime, $activity_id, $student_id);
        $stmt->execute();
        $stmt->close();
    } else {
        // Insert new activity
        $query = "INSERT INTO student_activities (student_id, activity_type, score, total_score, datetime) VALUES (?, ?, ?, ?, ?)";
        $stmt = $con->prepare($query);
        $stmt->bind_param("issss", $student_id, $activity_type, $score, $total_score, $datetime);
        $stmt->execute();
        $stmt->close();
    }
}



$result = $con->query("SELECT * FROM student_activities WHERE student_id=$student_id $filter_condition");

// Delete activity
if (isset($_GET['delete'])) {
    $activity_id = $_GET['delete'];
    $query = "DELETE FROM student_activities WHERE id='$activity_id' AND student_id='$student_id'";
    $con->query($query);
}

// Handle deletion process
if (isset($_POST['delete_selected'])) {
    if (!empty($_POST['delete_ids'])) {
        $delete_ids = implode(',', $_POST['delete_ids']);
        $query = "DELETE FROM student_activities WHERE id IN ($delete_ids) AND student_id='$student_id'";
        $con->query($query);
    }
}
// Fetch activities
$result = $con->query("SELECT * FROM student_activities WHERE student_id=$student_id");

$low_score_threshold = 0.5; // 50% threshold for considering a score as low
$absent_threshold = 3;
$total_activities = 0;
$low_scores = 0;
$absences = 0;
$total_high_scores = 0; // Initialize total high scores counter

while ($row = $result->fetch_assoc()) {
    if ($row['activity_type'] != 'attendance') {
        // Count only non-attendance records
        $total_activities++;
        // Calculate the percentage of the score compared to the total score
        $score_percentage = ($row['score'] / $row['total_score']);
        // Check if the score percentage is below the threshold and not a perfect score
        if ($score_percentage < $low_score_threshold && $row['score'] != $row['total_score']) {
            $low_scores++;
        } elseif ($score_percentage >= $low_score_threshold) {
            $total_high_scores++; // Increment the total high scores counter
        }
    } else {
        // Check if the student is absent
        if ($row['score'] == 0) {
            $absences++;
            // Increment total activities for absent records
            $total_activities++;
        }
    }
}

// Adjust the risk index calculation
if ($total_activities > 0) {
    // Calculate the proportion of low scores relative to total activities
    $low_score_proportion = $low_scores / $total_activities;
    // If there are high scores in all activities and exams, reduce the risk index
    if ($total_high_scores == $total_activities - $absences) {
        $risk_index = max(0, ($low_score_proportion - 0.3) * 0.7 + ($absences / $absent_threshold) * 0.3); // Reduce the risk index by 30%
    } else {
        $risk_index = ($low_score_proportion * 0.7 + ($absences / $absent_threshold) * 0.3);
    }
    $risk_color = $risk_index > 0.7 ? 'red' : ($risk_index > 0.4 ? 'orange' : 'green');
} else {
    // If there are no non-attendance activities, risk index is 0
    $risk_index = 0;
    $risk_color = 'green';
}



$result->data_seek(0);
 // Reset the result set pointer for table display
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Activities</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h1 {
            color: #333;
            margin: 20px 0;
        }

        form {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            width: 100%;
            max-width: 500px;
        }

        select, input[type="number"], input[type="date"], input[type="time"], button {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }
        .print, .filter {
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
            max-width: 10%;
        }.delete{
            background-color: red;
            color: #fff;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
            max-width: 10%;
        }

        .delete:hover {
            background-color: maroon;
        }

        table {
            width: 100%;
            max-width: 800px;
            border-collapse: collapse;
            margin: 20px 0;
            background: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f4f4f9;
            color: #333;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .edit-form {
            display: none;
        }

        .risk-index {
            padding: 10px;
            color: #fff;
            font-weight: bold;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<a href="students.php" style="position: absolute; top: 20px; left: 40px; text-decoration: none; color: black;">
    <svg width="54" height="74" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <!-- Outer circle -->
        <circle cx="12" cy="12" r="10" fill="#F7F7F7" stroke="black" stroke-width="2"/>
        <!-- Inner arrow shape -->
        <path d="M8 12H16M8 12L12 8M8 12L12 16" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
</a>
<h1>Student Records</h1>
    <form id="activity-form" method="POST" action="student_activities.php?student_id=<?php echo $student_id; ?>">
        <input type="hidden" name="activity_id" id="activity_id">
        <select name="activity_type" id="activity_type" required>
            <option value="quiz">Quiz</option>
            <option value="activity">Activity</option>
            <option value="exam">Exam</option>
            <option value="attendance">Attendance</option>
        </select>
        <input type="number" name="score" id="score" placeholder="Score" required>
        <input type="number" name="total_score" id="total_score" placeholder="Total Score" required>
        <input type="date" name="date" id="date" required>
        <input type="time" name="time" id="time" required>
        <button type="submit" name="save_activity">Save Record</button>
    </form>
    
    <table>
    <form method="GET" action="student_activities.php">
        <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">
        
        <button type="submit" name="print_pdf" class="print">PRINT PDF</button>
        <div class="risk-index" style="background-color: <?php echo $risk_color; ?>">
        Risk Index: <?php echo round($risk_index * 100); ?>%
    </div>

        

    </form>
    <form method="POST" action="student_activities.php?student_id=<?php echo $student_id; ?>">
    <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">
    <table>
        
        <tr>
            <th>ID</th>
            <th>Activity Type</th>
            <th>Score</th>
            <?php 
                // Check if there are any activities with total scores
                $has_total_scores = false;
                $result->data_seek(0); // Reset the result set pointer
                while($row = $result->fetch_assoc()) {
                    if ($row['total_score'] > 0) {
                        $has_total_scores = true;
                        break;
                    }
                }
                // Display the total score column if there are activities with total scores
                if ($has_total_scores) {
                    echo '<th>Total Score</th>';
                }
            ?>
            <th>Date</th>
            <th>Actions</th>
            <th>Select</th>
        </tr>
        <?php 
            // Reset the result set pointer for table display
            $result->data_seek(0);
            
            // Initialize an array to store total scores for each activity type
            $total_scores = array();

            while($row = $result->fetch_assoc()): 
                // Initialize the total score for the current activity type if not set
                if (!isset($total_scores[$row['activity_type']])) {
                    $total_scores[$row['activity_type']] = 0;
                }
                
                // Add the current score to the total score for the activity type
                $total_scores[$row['activity_type']] += $row['score'];
            ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['activity_type']; ?></td>
            <td><?php echo $row['score']; ?></td>
            <td><?php echo $row['total_score']; ?></td>

            <td><?php echo $row['datetime']; ?></td>
            <td>
                <button type="button" onclick="editActivity(<?php echo $row['id']; ?>, '<?php echo $row['activity_type']; ?>', <?php echo $row['score']; ?>, '<?php echo $row['datetime']; ?>')">Edit</button>
                <a href="student_activities.php?student_id=<?php echo $student_id; ?>&delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this record?')">Delete</a>
            </td>
            <td><input type="checkbox" name="delete_ids[]" value="<?php echo $row['id']; ?>"></td>
            
            <input type="hidden" name="activity_id[]" value="<?php echo $row['id']; ?>">
            
        </tr>
        <?php endwhile; ?>
    </table>
    <button type="submit" name="delete_selected" class="delete">Delete Selected</button>
</form>


   
    <script>
        function editActivity(id, activityType, score, date) {
            document.getElementById('activity_id').value = id;
            document.getElementById('activity_type').value = activityType;
            document.getElementById('score').value = score;
            document.getElementById('date').value = date;
            window.scrollTo(0, 0);
        }
    </script>
</body>
</html>
