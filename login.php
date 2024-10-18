<link rel="icon" href="css/img/logo.ico">
<?php
session_start();


include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = $_POST['email'];
    $password = $_POST['password'];


    if (!empty($email) && !empty($password)) {

        $checkEmailQuery = "SELECT * FROM user WHERE email = '$email'";
        $result = mysqli_query($con, $checkEmailQuery);

        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);


            if ($user['confirmation_status'] === 'confirmed') {

                if ($user['password'] == $password) {

                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['logged_in'] = true;

                    echo '<script>var loggedIn = true;</script>';


                    echo '<script>
    setTimeout(function(){
        if(loggedIn){
            alert("Logged In Successfully!");
            window.location.href = "page.php";
        }
    }, 1000); // Adjust the delay (in milliseconds) as needed
  </script>';
                    exit();
                } else {
                    echo '<script>alert("Invalid Password");window.location.href = "signin.html";</script>';
                }
            } else {


                echo '<script>alert("Account not registered.");window.location.href = "signin.html";</script>';
            }
        } else {

            echo '<script>alert("Email not found. Please register.");window.location.href = "signin.html";</script>';
        }
    } else {

        echo '<script>alert("Please enter both email and password.");window.location.href = "signin.html";</script>';
    }
}

mysqli_close($con);
?>