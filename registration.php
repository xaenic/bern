<?php
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

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Retrieve form data and sanitize inputs
    $fullName = $conn->real_escape_string($_POST['fullName']);
    $idNumber = $conn->real_escape_string($_POST['idNumber']);
    $email = $conn->real_escape_string($_POST['email']);
    $phoneNumber = $conn->real_escape_string($_POST['phoneNumber']);
    $password = $conn->real_escape_string($_POST['password']);
    $confirmPassword = $conn->real_escape_string($_POST['confirmPassword']);

    // Check if password and confirm password match
    if ($password != $confirmPassword) {
        $response = "Password and Confirm Password do not match.";
    } else {
        // Check if email or ID already exists in the database
        $checkDuplicate = "SELECT * FROM student_information WHERE email = '$email' OR idNumber = '$idNumber'";
        $result = $conn->query($checkDuplicate);

        if ($result && $result->num_rows > 0) {
            $response = "duplicate";
        } else {
            // Hash the password before storing in the database
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert data into the "student_information" table
            $sql = "INSERT INTO student_information (fullName, idNumber, email, phoneNumber, password) VALUES ('$fullName', '$idNumber', '$email', '$phoneNumber', '$hashedPassword')";

            if ($conn->query($sql) === TRUE) {
                $response = "success";
                // Redirect to the login page
                header("Location: login.php");
                exit(); // Ensure that script execution stops after redirection
            } else {
                $response = "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title>Registration</title>
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
        var fullName = document.getElementsByName("fullName")[0].value;
        var idNumber = document.getElementsByName("idNumber")[0].value;
        var email = document.getElementsByName("email")[0].value;
        var phoneNumber = document.getElementsByName("phoneNumber")[0].value;

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
        } else if (fullName === '' || idNumber === '' || email === '' || phoneNumber === '' || password === '' || confirmPassword === '') {
            // Use SweetAlert to display an error message for empty fields
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Please fill in all fields.',
                timer: 60000, // 1 minute
                showConfirmButton: true
            });
            return false;
        } else {
            errorElement.innerHTML = "";
            return true;
        }
    }

    // Function to handle duplicate email or ID
    function handleDuplicate() {
        if (response === "duplicate") {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Email or ID Number is already in use.',
                timer: 3000, // 3 seconds
                showConfirmButton: true
            }).then((result) => {
                // Reset response if submit button is clicked again
                if (result.isConfirmed) {
                    response = "";
                }
            });
        } else if (response === "success") {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Registration successful!',
                timer: 60000, // 1 minute
                showConfirmButton: true
            });
        }
    }

    // Call handleDuplicate function when the document is ready
    document.addEventListener("DOMContentLoaded", function(event) {
        handleDuplicate();
    });
</script>
</head>
<body>
    <div class="container">
        <div class="title">Registration</div>
        <div class="content">
            <form action="" method="post" onsubmit="return validatePassword();">
                <div class="user-details">
                    <div class="input-box">
                        <span class="details">Full Name</span>
                        <input type="text" name="fullName" placeholder="Enter your name" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Id Number</span>
                        <input type="text" name="idNumber" placeholder="Enter your ID number" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Email</span>
                        <input type="text" name="email" placeholder="Enter your email" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Phone Number</span>
                        <input type="text" name="phoneNumber" placeholder="Enter your phone number" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Password</span>
                        <input type="password" name="password" id="password" placeholder="Enter your password" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Confirm Password</span>
                        <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirm your password" required>
                        <span id="passwordError" style="color: red;"></span>
                    </div>
                </div>
                <div class="gender-details">
                    <input type="radio" name="gender" id="dot-1">
                    <input type="radio" name="gender" id="dot-2">
                    <input type="radio" name="gender" id="dot-3">
                    <span class="gender-title">Gender</span>
                    <div class="category">
                        <label for="dot-1">
                            <span class="dot one"></span>
                            <span class="gender">Male</span>
                        </label>
                        <label for="dot-2">
                            <span class="dot two"></span>
                            <span class="gender">Female</span>
                        </label>
                        <label for="dot-3">
                            <span class="dot three"></span>
                            <span class="gender">Prefer not to say</span>
                        </label>
                    </div>
                </div>
                <div class="button">
                    <input type="submit" name="submit" value="Register">
                </div>
                <div class="signup-link">
                    Already have an account? <a href="login.php">Login now</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>