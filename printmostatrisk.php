<?php
session_start();


if (!isset($_SESSION['user_id'])) {
    die("User is not logged in. Please log in first.");
}

$userId = $_SESSION['user_id'];


include 'db.php';

// Fetch section ID
$sectionId = isset($_GET['section_id']) ? intval($_GET['section_id']) : 0;


$query = "SELECT students.id, students.student_name, students.email, 
            SUM(CASE WHEN activities.activity_type != 'attendance' THEN 1 ELSE 0 END) AS total_activities, 
            SUM(CASE WHEN activities.activity_type = 'attendance' AND scores.score = 0 THEN 1 ELSE 0 END) AS absences, 
            SUM(CASE WHEN (scores.score / activities.total_score) < 0.5 AND activities.activity_type != 'attendance' THEN 1 ELSE 0 END) AS low_scores,
            SUM(CASE WHEN (scores.score / activities.total_score) >= 0.5 AND activities.activity_type != 'attendance' THEN 1 ELSE 0 END) AS high_scores
          FROM students
          LEFT JOIN scores ON students.id = scores.student_id
          LEFT JOIN activities ON scores.activity_id = activities.id
          WHERE students.user_id = $userId AND students.section_id = $sectionId
          GROUP BY students.id
          ORDER BY ((SUM(CASE WHEN (scores.score / activities.total_score) < 0.5 AND activities.activity_type != 'attendance' THEN 1 ELSE 0 END) / 
                     NULLIF(SUM(CASE WHEN activities.activity_type != 'attendance' THEN 1 ELSE 0 END), 0)) * 0.7 + 
                    (SUM(CASE WHEN activities.activity_type = 'attendance' AND scores.score = 0 THEN 1 ELSE 0 END) / 3) * 0.3) DESC";

$result = mysqli_query($con, $query);

if (!$result) {
    die("Error fetching data: " . mysqli_error($con));
}


require_once('tcpdf/tcpdf.php');

$pdf = new TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Most at Risk Students');
$pdf->SetMargins(10, 10, 10);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->AddPage();


$pdf->SetFont('helvetica', '', 12);


$html = '
<h2 style="text-align:center;">Most at Risk Students</h2>
<table border="1" cellpadding="4">
    <thead>
        <tr>
            <th>Student Name</th>
            <th>Email</th>
            <th>Risk Index</th>
           
        </tr>
    </thead>
    <tbody>';

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $total_activities = $row['total_activities'];
        $low_scores = $row['low_scores'];
        $absences = $row['absences'];

        $low_score_threshold = 0.5;
        $absent_threshold = 3;
        $risk_index = 0;
        $risk_color = 'green';

        if ($total_activities > 0) {
            $low_score_proportion = $low_scores / $total_activities;
            $risk_index = ($low_score_proportion * 0.7 + ($absences / $absent_threshold) * 0.3);
            $risk_color = $risk_index > 0.7 ? 'red' : ($risk_index > 0.4 ? 'orange' : 'green');
        }


        $risk_index_color = $risk_color == 'red' ? '#e74c3c' : ($risk_color == 'orange' ? '#f39c12' : '#2ecc71');

        $html .= '<tr>
                    <td>' . htmlspecialchars($row["student_name"]) . '</td>
                    <td>' . htmlspecialchars($row["email"]) . '</td>
                    <td>
                        <div style="background-color:' . $risk_index_color . '; color: #ffffff; padding: 5px; border-radius: 4px;">
                            ' . round($risk_index * 100) . '% 
                        </div>
                    </td>
                  
                </tr>';
    }
} else {
    $html .= '<tr><td colspan="4">No students found</td></tr>';
}

$html .= '</tbody></table>';


$pdf->writeHTML($html, true, false, true, false, '');


$pdf->Output('most_at_risk_students.pdf', 'I');


mysqli_close($con);
