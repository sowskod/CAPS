<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];

include 'db.php';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_section'])) {
        if (isset($_POST['section_name']) && !empty($_POST['section_name'])) {
            $sectionName = mysqli_real_escape_string($con, $_POST['section_name']);
            $query = "INSERT INTO sections (user_id, section_name) VALUES ($userId, '$sectionName')";
            if (mysqli_query($con, $query)) {
                echo '<script>alert("Section added successfully!");window.location.href = "homepage.php";</script>';
            } else {
                echo "Error adding section: " . mysqli_error($con);
            }
        } else {
            echo "Section name is missing or empty.";
        }
    }

    
    // Update Section
    if (isset($_POST['update_section'])) {
        if (isset($_POST['edit_id']) && !empty($_POST['edit_id']) && isset($_POST['section_name']) && !empty($_POST['section_name'])) {
            $editId = intval($_POST['edit_id']);
            $sectionName = mysqli_real_escape_string($con, $_POST['section_name']);
            $query = "UPDATE sections SET section_name = '$sectionName' WHERE id = $editId AND user_id = $userId";
            if (mysqli_query($con, $query)) {
                echo '<script>alert("Section updated successfully!");window.location.href = "homepage.php";</script>';
            } else {
                echo "Error updating section: " . mysqli_error($con);
            }
        } else {
            echo "Section name or edit ID is missing or empty.";
        }
    }

    if (isset($_POST['upload_photo'])) {
        if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
            $uploadDirectory = 'futos/';
            $fileName = uniqid('photo_') . '_' . basename($_FILES["profile_picture"]["name"]);
            $filePath = $uploadDirectory . $fileName;
            if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $filePath)) {
                $updateQuery = "UPDATE user SET profile_picture = '$fileName' WHERE user_id = $userId";
                if (mysqli_query($con, $updateQuery)) {
                    echo '<script>alert("Profile picture uploaded successfully!");window.location.href = "account_settings.php";</script>';
                } else {
                    echo "Error updating profile picture in the database: " . mysqli_error($con);
                }
            } else {
                echo "Error uploading file.";
            }
        } else {
            echo '<script>alert("Please select a file.")</script>';
        }
    }
}

// Handle delete operation
if (isset($_GET['delete_id'])) {
    $deleteId = intval($_GET['delete_id']);
    $query = "DELETE FROM sections WHERE id = $deleteId AND user_id = $userId";
    if (mysqli_query($con, $query)) {
        echo '<script>alert("Section deleted successfully!");window.location.href = "homepage.php";</script>';
    } else {
        echo "Error deleting section: " . mysqli_error($con);
    }
}
// Fetch user data
$query = "SELECT * FROM user WHERE user_id = $userId";
$result = mysqli_query($con, $query);

if ($result) {
    $userData = mysqli_fetch_assoc($result);
} else {
    die("Error fetching user data: " . mysqli_error($con));
}

// Fetch sections
$query = "SELECT * FROM sections WHERE user_id = $userId";
$result = mysqli_query($con, $query);
if (!$result) {
    die("Query failed: " . mysqli_error($con));
}
// Initialize sort order and direction
$sortOrder = 'ASC';
$sortColumn = 'section_name'; // Default sort column

// Check if a sort column and direction are specified in the URL
if (isset($_GET['sort'])) {
    $sortColumn = $_GET['sort'];
    if (isset($_GET['order']) && $_GET['order'] === 'DESC') {
        $sortOrder = 'DESC';
    }
}

// Validate sort column (to prevent SQL injection)
$allowedColumns = ['section_name', 'id']; // Define which columns can be sorted
if (!in_array($sortColumn, $allowedColumns)) {
    $sortColumn = 'section_name'; // Fallback to default
}

// Fetch sections with sorting
$query = "SELECT * FROM sections WHERE user_id = $userId ORDER BY $sortColumn $sortOrder";
$result = mysqli_query($con, $query);
if (!$result) {
    die("Query failed: " . mysqli_error($con));
}
// Close the connection after all queries are done
mysqli_close($con);
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
   
    
    <style>
   
  body {
    background-color: #f4f4f9;
    color: #333;
    font-family: 'Roboto', sans-serif;
    margin: 0;
    padding: 0;
}

header {
    background-color: #333;
    color: #fff;
    padding: 15px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

header .logo {
    max-width: 100px;
}

header nav a {
    color: #fff;
    text-decoration: none;
    margin: 0 15px;
    font-size: 16px;
}

header nav a:hover {
    text-decoration: underline;
}

header .profile-picture {
    position: relative;
    cursor: pointer;
}

header .profile-picture img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: 2px solid #fff;
}

header .dropdown-content {
    display: none;
    position: absolute;
    right: 0;
    background-color: #fff;
    min-width: 160px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    z-index: 1;
    border-radius: 5px;
}

header .dropdown-content a, 
header .dropdown-content input[type="submit"] {
    color: #333;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

header .dropdown-content a:hover, 
header .dropdown-content input[type="submit"]:hover {
    background-color: #f4f4f4;
}

.container {
    padding: 20px;
    max-width: 1200px;
    margin: 0 auto;
}

h2 {
    color: #007bff;
    font-size: 28px;
    margin-bottom: 20px;
}

form {
    background: #fff;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
}

form input[type="text"], 
form button {
    display: block;
    width: 100%;
    margin-bottom: 15px;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

form button {
    background-color: #007bff;
    color: #fff;
    border: none;
    cursor: pointer;
    font-size: 16px;
}

form button:hover {
    background-color: #0056b3;
}


        table th, table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #007bff;
            color: #fff;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table td a {
            color: #007bff;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 4px;
            display: inline-block;
            transition: background-color 0.3s;
        }

        table td a:hover {
            background-color: #0056b3;
            color: #fff;
        }

        table td a.edit-link {
            background-color: #ffc107;
            color: #333;
        }

        table td a.edit-link:hover {
            background-color: #e0a800;
        }

        table td a.delete-link {
            background-color: #dc3545;
            color: #fff;
        }

        table td a.delete-link:hover {
            background-color: #c82333;
        }

.dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: #fff;
            min-width: 160px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }
        .dropdown-content a, .dropdown-content form {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    .dropdown-content a:hover, .dropdown-content input[type="submit"]:hover {
        background-color: #f1f1f1;
    }

    .dropdown-content form {
        margin: 0;
    }

    .dropdown-content input[type="submit"] {
        width: 100%;
        border: none;
        background: none;
        padding: 12px 16px;
        text-align: left;
        cursor: pointer;
        color: black;
        font-size: 14px;
    }

    .dropdown-content input[type="submit"]:hover {
        background-color: #f1f1f1;
    }

        .dropdown-content a {
            color: #333;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .dropdown-content.show {
            display: block;
        }

    </style>
   
</head>
<body>
<!-- Navigation Bar -->


<header>
        <div>
            <img src="images/dont.png" alt="Your Logo" class="logo">
        </div>
        <nav>
            <a href="homepage.php">Home</a>
            <a href="about.html">About Us</a>
            <a href="contact.html">Contact Us</a>
            
        </nav>
        <div class="profile-picture">
           
            <img src="futos/<?php echo $userData['profile_picture']; ?>" alt="Profile Picture" onclick="toggleDropdown()">
            <div id="dropdownContent" class="dropdown-content">
                <a href="account_settings.php">Profile Settings</a>
                
                <form action="account_settings.php" method="post">
        <input type="submit" id="logout"  name="logout" value="Logout">
    </form>
            </div>
        </div>
    </header>

<div class="container">
        <div class="homepage">
            <h2>Dashboard</h2>
           
            <div class="container">
    <!-- Form for adding new sections -->
    <form method="POST" action="homepage.php">
        <h2>Add New Section&Course</h2>
        <input type="text" name="section_name" placeholder="Enter section&couurse name" required>
        <button type="submit" name="add_section">Add Section&Course</button>
    </form>

   <!-- Display existing sections -->
   <h2>Sections</h2>
   <table>
        <thead>
            <tr>
                <th>
                   Section&Course Name
                </th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $isEditing = isset($_GET['edit_id']) && $_GET['edit_id'] == $row['id'];

                    echo "<tr>
                            <td>" . htmlspecialchars($row['section_name']) . "</td>
                            <td>
                                <a href='student.php?section_id=" . htmlspecialchars($row['id']) . "'>View Students</a>
                                <a href='homepage.php?edit_id=" . htmlspecialchars($row['id']) . "' class='edit-link'>Edit</a>
                                <a href='homepage.php?delete_id=" . htmlspecialchars($row['id']) . "' class='delete-link' onclick='return confirm(\"Are you sure you want to delete this section?\")'>Delete</a>
                            </td>
                          </tr>";

                    if ($isEditing) {
                        echo "<tr>
                                <td colspan='2'>
                                    <form method='POST' action='homepage.php'>
                                        <input type='hidden' name='edit_id' value='" . htmlspecialchars($row['id']) . "'>
                                        <input type='text' name='section_name' value='" . htmlspecialchars($row['section_name']) . "' required>
                                        <button type='submit' name='update_section'>Update Section</button>
                                    </form>
                                </td>
                              </tr>";
                    }
                }
            } else {
                echo "<tr><td colspan='2'>No sections found</td></tr>";
            }
            ?>
        </tbody>
    </table>
        </div>
    </div>


  <script>
        function toggleDropdown() {
            var dropdownContent = document.getElementById("dropdownContent");
            dropdownContent.classList.toggle("show");
        }

        window.onclick = function(event) {
            if (!event.target.matches('.profile-picture img')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }

        function toggleActions(element) {
        const actions = element.querySelector('.actions');
        const currentlyVisible = actions.style.display === 'block';
        document.querySelectorAll('.actions').forEach(a => a.style.display = 'none');
        actions.style.display = currentlyVisible ? 'none' : 'block';
    }

    // Optional: Hide actions when clicking outside
    document.addEventListener('click', function(event) {
        if (!event.target.closest('.section-item')) {
            document.querySelectorAll('.actions').forEach(a => a.style.display = 'none');
        }
    });
    </script>
</body>
</html>
