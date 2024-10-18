<?php


// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("User is not logged in. Please log in first.");
}

$userId = $_SESSION['user_id'];


include 'db.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTPDebug;

require 'C:\xampp\htdocs\idrop\PHPMailer\src\Exception.php';
require 'C:\xampp\htdocs\idrop\PHPMailer\src\PHPMailer.php';
require 'C:\xampp\htdocs\idrop\PHPMailer\src\SMTP.php';


$sectionId = isset($_GET['section_id']) ? intval($_GET['section_id']) : 0;


$query = "SELECT students.id, students.student_name, students.email, 
            SUM(CASE WHEN activities.activity_type != 'attendance' THEN 1 ELSE 0 END) AS total_activities, 
            SUM(CASE WHEN activities.activity_type = 'attendance' AND scores.score = 0 THEN 1 ELSE 0 END) AS absences, 
            SUM(CASE WHEN (scores.score / activities.total_score) < 0.5 AND activities.activity_type != 'attendance' THEN 1 ELSE 0 END) AS low_scores
          FROM students
          LEFT JOIN scores ON students.id = scores.student_id
          LEFT JOIN activities ON scores.activity_id = activities.id
          WHERE students.user_id = $userId AND students.section_id = $sectionId
          GROUP BY students.id";

$result = mysqli_query($con, $query);

if (!$result) {
    die("Error fetching data: " . mysqli_error($con));
}


while ($row = mysqli_fetch_assoc($result)) {
    $total_activities = $row['total_activities'];
    $low_scores = $row['low_scores'];
    $absences = $row['absences'];

    $risk_index = 0;

    if ($total_activities > 0) {
        $low_score_proportion = ($low_scores > 0) ? $low_scores / $total_activities : 0;
        $risk_index = ($low_score_proportion * 0.7) + (min($absences, 3) / 3 * 0.3);
    }


    if ($risk_index >= 0.7) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'dontdropassist@gmail.com';
            $mail->Password   = 'zzqz kqfl ijry wjec';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom('dontdropassist@gmail.com', 'Notification Service');
            $mail->addAddress($row['email']);

            $mail->isHTML(false);
            $mail->Subject = "Risk Alert";
            $mail->Body    = "Dear " . htmlspecialchars($row['student_name']) . ",\n\n" .
                "You are at risk with a risk level of " . round($risk_index * 100) . "%.\nPlease contact your counselor for assistance.";

            $mail->send();
        } catch (Exception $e) {
            error_log("Error sending email to {$row['email']}: {$mail->ErrorInfo}", 3, "errors.log");
        }
    }
}
