<?php
require_once('tcpdf/tcpdf.php');
session_start();


if (!isset($_SESSION['user_id'])) {
    die("User is not logged in. Please log in first.");
}

$userId = $_SESSION['user_id'];

include 'db.php';

$studentId = isset($_GET['student_id']) ? intval($_GET['student_id']) : 0;


$studentQuery = "SELECT id, student_name, section_id FROM students WHERE id = $studentId";
$studentResult = mysqli_query($con, $studentQuery);

if (!$studentResult) {
    die("Query failed: " . mysqli_error($con));
}

$studentRow = mysqli_fetch_assoc($studentResult);

if (!$studentRow) {
    die("Student not found.");
}

$studentName = $studentRow['student_name'];
$sectionId = $studentRow['section_id'];


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
    die("No records found for this student.");
}


$pdf = new TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Student Records');
$pdf->SetHeaderData('', 0, 'Student Records', "Records for " . htmlspecialchars($studentName));
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(10, 10, 10);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->AddPage();


$pdf->SetFont('helvetica', '', 12);

$html = '
<table border="1" cellpadding="4">
    <thead>
        <tr>
            <th>Activity Type</th>
            <th>Score</th>
            <th>Total Score</th>
            <th>Date and Time</th>
        </tr>
    </thead>
    <tbody>';

while ($row = mysqli_fetch_assoc($result)) {
    $html .= '<tr>
                <td>' . htmlspecialchars($row['activity_type']) . '</td>
                <td>' . htmlspecialchars($row['score']) . '</td>
                <td>' . htmlspecialchars($row['total_score']) . '</td>
                <td>' . htmlspecialchars(date('Y-m-d H:i:s', strtotime($row['created_at']))) . '</td>
              </tr>';
}

$html .= '</tbody></table>';


$pdf->writeHTML($html, true, false, true, false, '');

$pdf->Output('student_records.pdf', 'I');

mysqli_close($con);
