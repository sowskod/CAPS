<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iDropAlert</title>
    <link rel="stylesheet" href="css/global.css">
    <link rel="icon" href="css/img/logo.ico">
    <style>
        .headsecgroup {
            display: flex;
            justify-content: space-around;
            padding: 20px;

        }

        .headersec a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            font-family: Arial, sans-serif;
        }

        .headersec a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<?php
session_start();
include 'db.php';
$userId = $_SESSION['user_id'];
$query = "SELECT * FROM user WHERE user_id = $userId";
$result = mysqli_query($con, $query);
if ($result) {
    $userData = mysqli_fetch_assoc($result);
} else {
    die("Error fetching user data: " . mysqli_error($con));
}
if (isset($_GET['action']) && $_GET['action'] == 'signout') {
    session_destroy();
    header('Location: signin.html');
    exit;
}
?>

<body>
    <header>
        <div class="headergrop">
            <div class="profile-picture">
                <img src="futos/<?php echo $userData['profile_picture']; ?>" alt="Profile Picture" onclick="toggleDropdown()">
                <div class="userinfo">
                    <h4><?= $userData['first_name'] . " " . $userData['last_name']  ?></h4>
                    <p><?= $userData['email'] ?></p>
                </div>
                <div id="dropdownContent" class="dropdown-content">
                    <a href="page.php?settings">Profile Settings</a>
                    <form action="account_settings.php" method="post">
                        <input type="submit" id="logout" name="logout" value="Logout">
                    </form>
                </div>
            </div>
            <div class="headsecgroup">
                <div class="headersec">
                    <a href="page.php">Dashboard</a>
                </div>
                <div class="headersec">
                    <a href="page.php?settings">Profile Settings</a>
                </div>
                <div class="headersec">
                    <a href="page.php?action=signout">Sign Out</a>
                </div>
            </div>
        </div>
    </header>
    <div class="dom">
        <?php
        if (isset($_GET['dashboard'])) {
            include("dashboard.php");
        } else if (isset($_GET['student'])) {
            if ($_GET['student'] == 'most_at_risk' && isset($_GET['section_id'])) {
                include("most_at_risk.php");
            } else if ($_GET['student'] == 'records' && isset($_GET['student_id']) && isset($_GET['section_id'])) {
                include("student_records.php");
            } else if ($_GET['student'] == 'edit' && isset($_GET['student_id']) && isset($_GET['section_id'])) {
                include("edit_student.php");
            } else if ($_GET['student'] == 'add_student' && isset($_GET['section_id'])) {
                include("add_student.php");
            } else if (isset($_GET['edit_score']) && isset($_GET['score_id'])) {
                include("edit_score.php");
            } else {
                include("student.php");
            }
        } else if (isset($_GET['settings'])) {
            include("account_settings.php");
        } else {
            include("homepage.php");
        }
        ?>
    </div>
</body>

</html>