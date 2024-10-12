<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("User is not logged in. Please log in first.");
}

$userId = $_SESSION['user_id'];

// Include the database connection file
include 'db.php';

$scoreId = isset($_GET['score_id']) ? intval($_GET['score_id']) : 0;
$sectionId = isset($_GET['section_id']) ? intval($_GET['section_id']) : 0;

// Fetch current score details
$query = "SELECT sc.student_id, a.activity_type, sc.score, a.total_score 
          FROM scores sc 
          JOIN activities a ON sc.activity_id = a.id 
          WHERE sc.id = $scoreId";

$result = mysqli_query($con, $query);
if (!$result) {
    die("Query failed: " . mysqli_error($con));
}
$score = mysqli_fetch_assoc($result);

if (!$score) {
    die("Score not found.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newScore = intval($_POST['score']);
    $updateQuery = "UPDATE scores SET score = $newScore WHERE id = $scoreId";
    if (mysqli_query($con, $updateQuery)) {
        echo '<script>
                alert("Score updated successfully!");
                window.location.href = "student_records.php?student_id=' . $score['student_id'] . '&section_id=' . $sectionId . '";
              </script>';
    } else {
        echo "Error updating score: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Score</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }
        input[type="text"],
        input[type="number"] {
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        button {
            padding: 10px 20px;
            background-color: #3498db;
            border: none;
            color: white;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #2980b9;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #3498db;
            font-size: 16px;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Score</h2>
        <form method="POST">
            <label for="activity_type">Activity Type:</label>
            <input type="text" id="activity_type" value="<?php echo htmlspecialchars($score['activity_type']); ?>" disabled>
            <label for="score">Score:</label>
            <input type="number" id="score" name="score" value="<?php echo htmlspecialchars($score['score']); ?>" min="0" max="<?php echo htmlspecialchars($score['total_score']); ?>" required>
            <button type="submit">Update Score</button>
        </form>
        <a href="student_records.php?student_id=<?php echo urlencode($score['student_id']); ?>&section_id=<?php echo urlencode($sectionId); ?>">Back to Records</a>
    </div>
</body>
</html>
