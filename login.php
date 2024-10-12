<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
    <style>
        
        .message-container {
                text-align: center;
            }

            .message-container img {
                max-width: 250px;
                height: auto;
                margin-bottom: 20px;
                margin-top: 50px;
            }

            h3 {
                margin: 0;
                color: #333;
                font-size: 50px;
                margin-bottom: 25px;
            }

            a {
                text-decoration: none;
                color: #007bff;
                font-weight: bold;
                font-size: 30px;
                border: solid #007bff 2px;
                padding: 15px;
                border-radius: 5px;
            }
    </style>
</head>
<body>
    
</body>
</html>
<?php
session_start(); // Start the session

include 'db.php';

require_once 'vendor/autoload.php';
header("Content-Type: application/json");
ini_set('display_errors', 1);
error_reporting(E_ALL);




// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get email and password from the form
    $email = $_POST['email'];
    $password = $_POST['password'];

  // Use prepared statements to prevent SQL injection
  $stmt = $con->prepare("SELECT user_id FROM user WHERE email = ? AND password = ?");
  $stmt->bind_param('ss', $email, $password);
  $stmt->execute();
  $stmt->store_result();
  
  if ($stmt->num_rows > 0) {
      $stmt->bind_result($user_id);
      $stmt->fetch();
      $_SESSION['user_id'] = $user_id;
      header("Location: homepage.php");
  } else {
      echo "Invalid credentials";
  }

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
             
                    // Check if the password is correct
                    if ($user['password'] == $password) {
                        // After validating credentials
                        $_SESSION['user_id'] = $user['user_id']; // assuming customer_id is the unique identifier
                        $_SESSION['logged_in'] = true;
                        

                        // Set a JavaScript variable to indicate successful login
    echo '<script>var loggedIn = true;</script>';
                        
                        // You can set session variables or perform other login actions here

                         // Redirect to homepage.php after a delay
    echo '<script>
    setTimeout(function(){
        if(loggedIn){
            alert("Logged In Successfully!");
            window.location.href = "homepage.php";
        }
    }, 1000); // Adjust the delay (in milliseconds) as needed
  </script>';
exit();
                    } else {
                        echo '<script>alert("Invalid Password");window.location.href = "signin.html";</script>';
                     }
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

   // Initialize the $data variable
// Initialize $data to avoid undefined variable warnings
$data = [];
file_put_contents('debug.log', print_r($_SERVER, true)); // Log request method and headers

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    // Handle form submission
    if (isset($_POST['email']) && isset($_POST['first_name']) && isset($_POST['last_name'])) {
        $email = $_POST['email'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
    }
    // Check if CONTENT_TYPE is set and is JSON
    elseif (isset($_SERVER['CONTENT_TYPE']) && $_SERVER['CONTENT_TYPE'] === 'application/json') {
        $data = json_decode(file_get_contents('php://input'), true);

        // Log the received data for debugging purposes
        error_log(print_r($data, true));

        // Check if email, first_name, and last_name are present
        if (isset($data['email']) && isset($data['first_name']) && isset($data['last_name'])) {
            $email = $data['email'];
            $first_name = $data['first_name'];
            $last_name = $data['last_name'];
        } else {
            echo json_encode(['success' => false, 'error' => 'Invalid input']);
            exit();
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid request']);
        exit();
    }

    // Proceed with database operations
    $stmt = $con->prepare("SELECT * FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Check confirmation status
        if ($user['confirmation_status'] !== 'confirmed') {
            echo json_encode(['success' => false, 'error' => 'Account not confirmed']);
        } else {
            $_SESSION['user_id'] = $user['user_id'];
            echo json_encode(['success' => true]);
        }
    } else {
        // Insert new user into the database
        $stmt = $con->prepare("INSERT INTO user (first_name, last_name, email) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $first_name, $last_name, $email);
        if ($stmt->execute()) {
            $_SESSION['user_id'] = $stmt->insert_id;
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $stmt->error]);
        }
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}
    
// Close the database connection
mysqli_close($con);
?>