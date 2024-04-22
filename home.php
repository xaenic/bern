<?php

session_start();

if(!isset($_SESSION['id']))
    header("location: ./login.php");
// Assuming you have a connection to your MySQL database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "school";

// Establish connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



$response = "";
$id = ""; // Initialize $id variable
$fullName = ""; // Initialize $fullName variable
$email = "";    // Initialize $email variable
$phoneNumber = "";  // Initialize $phoneNumber variable

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Retrieve form data and sanitize inputs
    $id = $conn->real_escape_string($_POST['id']);
    $fullName = $conn->real_escape_string($_POST['fullName']);
    $email = $conn->real_escape_string($_POST['email']);
    $phoneNumber = $conn->real_escape_string($_POST['phoneNumber']);
    $password = $conn->real_escape_string($_POST['password']);
    $confirmPassword = $conn->real_escape_string($_POST['confirmPassword']);

    // Check if password and confirm password match
    if ($password != $confirmPassword) {
        $response = "Password and Confirm Password do not match.";
    } else {
        // Hash the password before storing in the database
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Update data in the "student_information" table
        $sql = "UPDATE student_information SET fullName='$fullName', email='$email', phoneNumber='$phoneNumber'";
        
        // Update password only if a new password is provided
        if (!empty($password)) {
            $sql .= ", password='$hashedPassword'";
        }
        
        $sql .= " WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
            $response = "success";
            // Redirect to the profile page or any other desired location
            header("Location: profile.php");
            exit(); // Ensure that script execution stops after redirection
        } else {
            $response = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
} else {
    // If the form is not submitted, fetch the existing data based on $id
    $id = isset($_GET['id']) ? $_GET['id'] : "";
    if (!empty($id)) {
        $sql = "SELECT * FROM student_information WHERE id = $id";
        $result = $conn->query($sql);
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $fullName = $row['fullName'];
            $email = $row['email'];
            $phoneNumber = $row['phoneNumber'];
        } else {
            echo "No data found for ID: $id";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Include SweetAlert CSS and JS from CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
    var response = "<?php echo $response; ?>"; // Initialize response variable

    // Function to validate password and confirm password
    function validatePassword() {
        var password = document.getElementById("password").value;
        var confirmPassword = document.getElementById("confirmPassword").value;
        var errorElement = document.getElementById("passwordError");

        if (password !== confirmPassword) {
            // Use SweetAlert to display an error message
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Password and Confirm Password do not match.',
                timer: 60000, // 1 minute
                showConfirmButton: true
            });
            return false;
        } else {
            errorElement.innerHTML = "";
            return true;
        }
    }

    // Function to handle response messages
    function handleResponse() {
        if (response === "success") {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Profile updated successfully!',
                timer: 60000, // 1 minute
                showConfirmButton: true
            });
        }
    }

    // Call handleResponse function when the document is ready
    document.addEventListener("DOMContentLoaded", function(event) {
        handleResponse();
    });
</script>
</head>
<body>

asdasdas
    <input type="checkbox" id="check">
    <label for="check">
      <i class="fas fa-bars" id="btn"></i>
      <i class="fas fa-times" id="cancel"></i>
    </label>
    <div class="sidebar">
      <header>Welcome</header>
      <a href="#" class="active">
        <i class="fas fa-edit"></i>
        <span>Edit Profile</span>
      </a>
      <a href="#">
        <i class="fas fa-search"></i>
        <span>Search</span>
      </a>
      <a href="#">
        <i class="fas fa-solid fa-trash"></i>
        <span>Delete</span>
      </a>
      <a href="logout.php">
         <i class="fas fa-arrow-left"></i>
        <span>Logout</span>
      </a>
    </div>
    <div class="frame">
    <div class="card card1">
        <h5>Edit Profile</h5>
        <div id="profile-form">
            <form action="" method="post" onsubmit="return validatePassword();">
                <div class="input-box">
                    <span class="details">ID</span>
                    <input type="text" name="id" value="<?php echo $id; ?>" readonly>
                </div>
                <div class="input-box">
                    <span class="details">Full Name</span>
                    <input type="text" name="fullName" value="<?php echo $fullName; ?>" required>
                </div>
                <div class="input-box">
                    <span class="details">Email</span>
                    <input type="text" name="email" value="<?php echo $email; ?>" required>
                </div>
                <div class="input-box">
                    <span class="details">Phone Number</span>
                    <input type="text" name="phoneNumber" value="<?php echo $phoneNumber; ?>" required>
                </div>
                <div class="input-box">
                    <span class="details">Password</span>
                    <input type="password" name="password" id="password" placeholder="Enter your new password">
                </div>
                <div class="input-box">
                    <span class="details">Confirm Password</span>
                    <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirm your new password">
                    <span id="passwordError" style="color: red;"></span>
                </div>
                <div class="button">
                    <input type="submit" name="submit" value="Update Profile">
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
