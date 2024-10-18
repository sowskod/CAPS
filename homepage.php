<?php

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];

include 'db.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_section'])) {
        if (isset($_POST['section_name']) && !empty($_POST['section_name'])) {
            $sectionName = mysqli_real_escape_string($con, $_POST['section_name']);
            $query = "INSERT INTO sections (user_id, section_name) VALUES ($userId, '$sectionName')";
            if (mysqli_query($con, $query)) {
                echo '<script>alert("Section added successfully!");window.location.href = "page.php";</script>';
            } else {
                echo "Error adding section: " . mysqli_error($con);
            }
        } else {
            echo "Section name is missing or empty.";
        }
    }



    if (isset($_POST['update_section'])) {
        if (isset($_POST['edit_id']) && !empty($_POST['edit_id']) && isset($_POST['section_name']) && !empty($_POST['section_name'])) {
            $editId = intval($_POST['edit_id']);
            $sectionName = mysqli_real_escape_string($con, $_POST['section_name']);
            $query = "UPDATE sections SET section_name = '$sectionName' WHERE id = $editId AND user_id = $userId";
            if (mysqli_query($con, $query)) {
                echo '<script>alert("Section updated successfully!");window.location.href = "page.php";</script>';
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


if (isset($_GET['delete_id'])) {
    $deleteId = intval($_GET['delete_id']);
    $query = "DELETE FROM sections WHERE id = $deleteId AND user_id = $userId";
    if (mysqli_query($con, $query)) {
        echo '<script>alert("Section deleted successfully!");window.location.href = "page.php";</script>';
    } else {
        echo "Error deleting section: " . mysqli_error($con);
    }
}

$query = "SELECT * FROM user WHERE user_id = $userId";
$result = mysqli_query($con, $query);

if ($result) {
    $userData = mysqli_fetch_assoc($result);
} else {
    die("Error fetching user data: " . mysqli_error($con));
}


$query = "SELECT * FROM sections WHERE user_id = $userId";
$result = mysqli_query($con, $query);
if (!$result) {
    die("Query failed: " . mysqli_error($con));
}

$sortOrder = 'ASC';
$sortColumn = 'section_name';


if (isset($_GET['sort'])) {
    $sortColumn = $_GET['sort'];
    if (isset($_GET['order']) && $_GET['order'] === 'DESC') {
        $sortOrder = 'DESC';
    }
}

$allowedColumns = ['section_name', 'id'];
if (!in_array($sortColumn, $allowedColumns)) {
    $sortColumn = 'section_name';
}


$query = "SELECT * FROM sections WHERE user_id = $userId ORDER BY $sortColumn $sortOrder";
$result = mysqli_query($con, $query);
if (!$result) {
    die("Query failed: " . mysqli_error($con));
}

mysqli_close($con);
?>

<link rel="stylesheet" href="css\global.css">
<link rel="stylesheet" href="css\homepage.css">
<link rel="icon" href="css/img/logo.ico">
<div class="wrapper">
    <div class="header">
        <h2>Dashboard</h2>
    </div>
    <div class="content">
        <div class="form">
            <form method="POST" action="page.php">
                <input type="hidden" name="page" value="homepage">
                <h2>Add Year Section&Course</h2>
                <input type="text" name="section_name" placeholder="eg. 4A G1 CAPSTONE" required>
                <button type="submit" name="add_section">Add Section&Course</button>
            </form>
        </div>
        <div class="section">
            <h2>Sections</h2>
            <table>
                <thead>
                    <tr>
                        <th>
                            Year Section&Course Name
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
                                <a href='page.php?student=student&section_id=" . htmlspecialchars($row['id']) . "'>View Students</a>
                                <a href='page.php?edit_id=" . htmlspecialchars($row['id']) . "' class='edit-link'>Edit</a>
                                <a href='page.php?delete_id=" . htmlspecialchars($row['id']) . "' class='delete-link' onclick='return confirm(\"Are you sure you want to delete this section?\")'>Delete</a>
                            </td>
                          </tr>";

                            if ($isEditing) {
                                echo "<tr>
                                <td colspan='2'>
                                    <form method='POST' action='page.php'>
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


    document.addEventListener('click', function(event) {
        if (!event.target.closest('.section-item')) {
            document.querySelectorAll('.actions').forEach(a => a.style.display = 'none');
        }
    });
</script>
</body>

</html>