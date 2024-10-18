<?php
// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("User is not logged in. Please log in first.");
}

$userId = $_SESSION['user_id'];

// Include the database connection file
include 'db.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Import required files
require __DIR__ . '/vendor/autoload.php'; // Adjust this path if necessary
require 'C:\xampp\htdocs\idrop\PHPMailer\src\Exception.php';
require 'C:\xampp\htdocs\idrop\PHPMailer\src\PHPMailer.php';
require 'C:\xampp\htdocs\idrop\PHPMailer\src\SMTP.php';

// Fetch section ID
$sectionId = isset($_GET['section_id']) ? intval($_GET['section_id']) : 0;

$query = "SELECT students.id, students.student_name, students.email, 
            SUM(CASE WHEN activities.activity_type != 'attendance' THEN 1 ELSE 0 END) AS total_activities, 
            SUM(CASE WHEN (scores.score / activities.total_score) < 0.5 AND activities.activity_type != 'attendance' THEN 1 ELSE 0 END) AS low_scores,
            SUM(CASE WHEN activities.activity_type = 'attendance' AND scores.score = 0 THEN 1 ELSE 0 END) AS absences,
            SUM(CASE WHEN (scores.score / activities.total_score) >= 0.5 AND activities.activity_type != 'attendance' THEN 1 ELSE 0 END) AS high_scores
          FROM students
          LEFT JOIN scores ON students.id = scores.student_id
          LEFT JOIN activities ON scores.activity_id = activities.id
          WHERE students.user_id = $userId AND students.section_id = $sectionId
          GROUP BY students.id";


$result = mysqli_query($con, $query);

if (!$result) {
    die("Error fetching data: " . mysqli_error($con));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Most at Risk Students</title>
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
            color: #333333;
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 12px 15px;
            text-align: left;
        }

        th {
            background-color: #f5f5f5;
            color: #333;
            font-weight: bold;
        }

        td a {
            color: #3498db;
            text-decoration: none;
            font-weight: bold;
        }

        td a:hover {
            text-decoration: underline;
        }

        .risk-index {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 4px;
            color: #ffffff;
            font-weight: bold;
        }

        .risk-index.red {
            background-color: #e74c3c;
        }

        .risk-index.orange {
            background-color: #f39c12;
        }

        .risk-index.green {
            background-color: #2ecc71;
        }

        button[type="submit"] {
            background-color: #3498db;
            color: #ffffff;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #2980b9;
        }

        .back-button {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 15px;
            background-color: #3498db;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .back-button:hover {
            background-color: #2980b9;
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
        <a class="teacher-button" href="page.php?student&section_id=<?php echo htmlspecialchars($sectionId); ?>" class="back-button"><svg width="54" height="74" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">

                <circle cx="12" cy="12" r="10" fill="#E8F6F3" stroke="#00796B" stroke-width="2" />

                <path d="M8 12H16M8 12L12 8M8 12L12 16" stroke="#00796B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
    </style>
</head>

<body>
    <div class="container">
        <a class="teacher-button" href="page.php?student&section_id=<?php echo htmlspecialchars($sectionId); ?>">
            <svg width="54" height="74" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="12" cy="12" r="10" fill="#E8F6F3" stroke="#00796B" stroke-width="2" />
                <path d="M8 12H16M8 12L12 8M8 12L12 16" stroke="#00796B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </a>
        <br><br><br><br>
        <table>
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Email</th>
                    <th>Risk Index</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <?php
                        // Get the computed values
                        $total_activities = $row['total_activities'];
                        $low_scores = $row['low_scores'];
                        $absences = $row['absences'];
                        $high_scores = $row['high_scores'];
                        
                        // Call the Python script and get the predicted risk index
                        $command = escapeshellcmd("python C:\\xampp\\htdocs\\idrop\\predict_risk.py $total_activities $low_scores $absences $high_scores");

                        $predicted_risk_index = shell_exec($command);
                        $predicted_risk_index = floatval($predicted_risk_index); // Convert to float for calculations

                        // Determine risk color based on predicted risk index
                        $risk_color = $predicted_risk_index > 0.7 ? 'red' : ($predicted_risk_index > 0.4 ? 'orange' : 'green');

                        // Send email alert if risk index exceeds 70%
                        if ($predicted_risk_index >= 0.7) {
                            // Email alert function
                            $mail = new PHPMailer(true); {
                                // Server settings
                                $mail->isSMTP();
                                $mail->Host       = 'smtp.gmail.com';
                                $mail->SMTPAuth   = true;
                                $mail->Username   = 'dontdropassist@gmail.com'; // Replace with your email
                                $mail->Password   = 'zzqz kqfl ijry wjec';  // Replace with your email password
                                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                                $mail->Port       = 587;

                                // Recipients
                                $mail->setFrom('dontdropassist@gmail.com', 'Notification Service');
                                $mail->addAddress($row['email']);

                                // Content
                                $mail->isHTML(false);
                                $mail->Subject = "Risk Alert";
                                $mail->Body    = "Dear " . htmlspecialchars($row['student_name']) . ",\n\n" . 
                                                 "You are at risk with a risk level of " . round($predicted_risk_index * 100) . "%.\nPlease contact your counselor for assistance.";

                                $mail->send();
                            }
                        }
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row["student_name"]); ?></td>
                            <td><?php echo htmlspecialchars($row["email"]); ?></td>
                            <td>
                                <div class='risk-index <?php echo $risk_color; ?>'>
                                    <?php echo round($predicted_risk_index * 100); ?>%
                                </div>
                            </td>
                            <td>
                                <form method="POST" action="send_notification.php?section_id=<?php echo $sectionId; ?>">
                                    <input type="hidden" name="email" value="<?php echo htmlspecialchars($row["email"]); ?>" />
                                    <button type="submit" name="sendEmail">Send Alert</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">No students found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <a href="printmostatrisk.php?section_id=<?php echo htmlspecialchars($sectionId); ?>" class="mt-4 bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">Print PDF</a>
    </div>
</body>
</html>

<?php
// Close the database connection
mysqli_close($con);
?>
