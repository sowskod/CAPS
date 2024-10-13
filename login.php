
<?php
session_start(); // Start the session


include 'db.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get email and password from the form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if email and password are not empty
    if (!empty($email) && !empty($password)) {
        // Check if the email exists in the database
        $checkEmailQuery = "SELECT * FROM user WHERE email = '$email'";
        $result = mysqli_query($con, $checkEmailQuery);

        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);

            // Check if the account is confirmed
            if ($user['confirmation_status'] === 'confirmed') {
                // Check if the account is blocked



                if ($user['password'] == $password) {
                    // After validating credentials
                    $_SESSION['user_id'] = $user['user_id']; // assuming customer_id is the unique identifier
                    $_SESSION['logged_in'] = true;


                    // Set a JavaScript variable to indicate successful login
                    echo '<script>var loggedIn = true;</script>';

                    // You can set session variables or perform other login actions here

                    // Redirect to page.php after a delay
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

// Close the database connection
mysqli_close($con);
?>