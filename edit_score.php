<?php


// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("User is not logged in. Please log in first.");
}

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
                window.location.href = "page.php?student=records&student_id=' . $score['student_id'] . '&section_id=' . $sectionId . '";
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
    <a class="teacher-button" href="page.php?student=records&student_id=<?php echo urlencode($score['student_id']); ?>&section_id=<?php echo urlencode($sectionId); ?>"><svg width="54" height="74" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
      
      <circle cx="12" cy="12" r="10" fill="#E8F6F3" stroke="#00796B" stroke-width="2"/>
    
      <path d="M8 12H16M8 12L12 8M8 12L12 16" stroke="#00796B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
  </svg></a>
  <br>
    <br>
    <br>
    <br>
     <br>
        <center><h2>Edit Score</h2> </center>
        <form method="POST">
            <label for="activity_type">Activity Type:</label>
            <input type="text" id="activity_type" value="<?php echo htmlspecialchars($score['activity_type']); ?>" disabled>
            <label for="score">Score:</label>
            <input type="number" id="score" name="score" value="<?php echo htmlspecialchars($score['score']); ?>" min="0" max="<?php echo htmlspecialchars($score['total_score']); ?>" required>
            <button type="submit">Update Score</button>
        </form>
       
    </div>
</body>
</html>
