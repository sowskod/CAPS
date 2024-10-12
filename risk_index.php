<?php
// Calculate risk index
$low_score_threshold = 0.5; // 50% threshold for considering a score as low
$absent_threshold = 3;
$total_activities = 0;
$low_scores = 0;
$absences = 0;

while ($row = $result->fetch_assoc()) {
    if ($row['activity_type'] != 'attendance') {
        // Count only non-attendance records
        $total_activities++;
        // Calculate the percentage of the score compared to the total score
        $score_percentage = ($row['score'] / $row['total_score']);
        // Check if the score percentage is below the threshold and not a perfect score
        if ($score_percentage < $low_score_threshold && $row['score'] != $row['total_score']) {
            // Calculate the additional risk based on how much the score is below half of the total score
            $additional_risk = max(0, 1 - 2 * $score_percentage);
            $low_scores += $additional_risk;
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

if ($total_activities > 0) {
    // Calculate risk index only if there are non-attendance activities
    $risk_index = ($low_scores / $total_activities) * 0.7 + ($absences / $absent_threshold) * 0.3;
    $risk_color = $risk_index > 0.7 ? 'red' : ($risk_index > 0.4 ? 'orange' : 'green');
} else {
    // If there are no non-attendance activities, risk index is 0
    $risk_index = 0;
    $risk_color = 'green';
}

?>

<tr>
    <td colspan="4" style="text-align: right; font-weight: bold;">Risk Index:</td>
    <td style="background-color: <?php echo $risk_color; ?>; color: white;"><?php echo round($risk_index * 100) . '%'; ?></td>
</tr>
