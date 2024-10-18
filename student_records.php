<?php

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("User is not logged in. Please log in first.");
}

$userId = $_SESSION['user_id'];

// Include the database connection file
include 'db.php';

$studentId = isset($_GET['student_id']) ? intval($_GET['student_id']) : 0;

// Fetch the student's details
$studentQuery = "SELECT id, student_name, section_id FROM students WHERE id = $studentId";
$studentResult = mysqli_query($con, $studentQuery);

if (!$studentResult) {
    die("Query failed: " . mysqli_error($con));
}

$studentRow = mysqli_fetch_assoc($studentResult);

if ($studentRow) {
    $studentName = $studentRow['student_name'];
    $sectionId = $studentRow['section_id'];
} else {
    die("Student not found.");
}

// Fetch the student's scores including timestamp
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


?>

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
        font-size: 24px;
        text-align: center;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    thead {
        background-color: #3498db;
        color: #fff;
    }

    th,
    td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        font-weight: bold;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    td {
        color: #333;
    }

    a {
        color: #3498db;
        text-decoration: none;
        font-weight: bold;
    }

    a:hover {
        text-decoration: underline;
    }

    .actions a {
        margin-right: 10px;
    }

    .actions a.delete {
        color: #e74c3c;
    }

    .actions a.delete:hover {
        text-decoration: underline;
    }

    .back-button {
        display: block;
        width: fit-content;
        margin: 20px auto;
        padding: 10px 20px;
        background-color: #3498db;
        color: #fff;
        text-align: center;
        border-radius: 4px;
        text-decoration: none;
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

<div class="container">
    <a class="teacher-button" href="page.php?student&section_id=<?php echo htmlspecialchars($sectionId); ?>" class="back-button"><svg width="54" height="74" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="12" cy="12" r="10" fill="#E8F6F3" stroke="#00796B" stroke-width="2" />

            <path d="M8 12H16M8 12L12 8M8 12L12 16" stroke="#00796B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg></a>
    <br>
    <br>
    <h2>Records for <?php echo htmlspecialchars($studentName); ?></h2>
    <table>
        <thead>
            <tr>
                <th>Activity Type</th>
                <th>Score</th>
                <th>Total Score</th>
                <th>Date and Time</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['activity_type']); ?></td>
                        <td><?php echo htmlspecialchars($row['score']); ?></td>
                        <td><?php echo htmlspecialchars($row['total_score']); ?></td>
                        <td><?php echo htmlspecialchars(date('Y-m-d H:i:s', strtotime($row['created_at']))); ?></td>
                        <td class="actions">
                            <a href="page.php?student=records&edit_score=true&score_id=<?php echo htmlspecialchars($row['score_id']); ?>">Edit</a>
                            <a href="delete_score.php?score_id=<?php echo htmlspecialchars($row['score_id']); ?>" class="delete" onclick="return confirm('Are you sure you want to delete this score?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No records found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <a href="print.php?student_id=<?php echo htmlspecialchars($studentId); ?>" class="mt-4 bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">Print PDF</a>

</div>