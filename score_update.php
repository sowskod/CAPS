<?php
function updateScores($con, $userId, $sectionId, $scores)
{
    // Begin transaction
    mysqli_begin_transaction($con);

    try {
        foreach ($scores as $studentId => $activityScores) {
            foreach ($activityScores as $activityId => $score) {
                // Prepare the query to check if the score already exists
                $checkQuery = "SELECT * FROM scores WHERE student_id = ? AND activity_id = ?";
                $stmt = mysqli_prepare($con, $checkQuery);
                mysqli_stmt_bind_param($stmt, 'ii', $studentId, $activityId);
                mysqli_stmt_execute($stmt);
                $checkResult = mysqli_stmt_get_result($stmt);

                if (mysqli_num_rows($checkResult) > 0) {
                    // Update the existing score
                    $updateQuery = "UPDATE scores SET score = ? WHERE student_id = ? AND activity_id = ?";
                    $updateStmt = mysqli_prepare($con, $updateQuery);
                    mysqli_stmt_bind_param($updateStmt, 'iii', $score, $studentId, $activityId);
                    mysqli_stmt_execute($updateStmt);
                } else {
                    // Insert a new score
                    $insertQuery = "INSERT INTO scores (student_id, activity_id, score) VALUES (?, ?, ?)";
                    $insertStmt = mysqli_prepare($con, $insertQuery);
                    mysqli_stmt_bind_param($insertStmt, 'iii', $studentId, $activityId, $score);
                    mysqli_stmt_execute($insertStmt);
                }
            }
        }

        // Commit transaction
        mysqli_commit($con);
    } catch (Exception $e) {
        // Rollback transaction on error
        mysqli_rollback($con);
        // Log the error message (or handle it as needed)
        error_log("Failed to update scores: " . $e->getMessage());
        echo "Error updating scores. Please try again.";
    } finally {
        // Close statements
        if (isset($stmt)) mysqli_stmt_close($stmt);
        if (isset($updateStmt)) mysqli_stmt_close($updateStmt);
        if (isset($insertStmt)) mysqli_stmt_close($insertStmt);
    }
}
