<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iDropAlert</title>
    <link rel="stylesheet" href="css/global.css">
    <link rel="icon" href="css/img/logo.ico">
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
                    <a href="account_settings.php">Profile Settings</a>
                    <form action="account_settings.php" method="post">
                        <input type="submit" id="logout" name="logout" value="Logout">
                    </form>
                </div>
            </div>
            <div class="headsecgroup">
                <div class="headersec">
                    <p>Dashboard</p>
                </div>
                <div class="headersec">
                    <p>Sign out</p>
                </div>
            </div>
        </div>
    </header>
    <div class="dom">
        <?php
        if (isset($_GET['dashboard'])) {
            include("dashboard.php");
        } else if (isset($_GET['student'])) {
            include("student.php");
        } else if (isset($_GET['view_ingredients'])) {
            include("read_ingredients.php");
        } else if (isset($_GET['view_category'])) {
            include("read_category.php");
        } else if (isset($_GET['view_user'])) {
            include("read_user.php");
        } else if (isset($_GET['edit_meal'])) {
            include("edit_meal.php");
        } else if (isset($_GET['insert_meal'])) {
            include("insert_meal.php");
        } else {
            include("homepage.php");
        }
        ?>
    </div>
</body>

</html>