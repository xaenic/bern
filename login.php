<?php
// Assuming you have a connection to your MySQL database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "school";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the login form is submitted
if (isset($_POST['login_submit'])) {
    // Retrieve form data
    $email = $_POST['email'];
    $password = $_POST['password'];


    // Check user credentials against the student database
    $stmt = $conn->prepare("SELECT * FROM student_information WHERE email = ? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $student_result = $stmt->get_result();

    if ($student_result->num_rows > 0) {
        $row = $student_result->fetch_assoc();

        // Verify password for student
        if (password_verify($password, $row['password'])) {
            // Redirect to the student dashboard

            $_SESSION['id'] = $row['id'];
            header("Location: home.php");
            exit();
        } else {
            // Invalid password for student
            echo "Invalid email or password";
        }
    } else {
        // User not found
        echo "Invalid email or password";
    }

    $stmt->close();
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="wrapper">
        <div class="title">
            Login Form
        </div>
        <form action="#" method="post">
            <div class="field">
                <input type="text" name="email" required>
                <label>Email Address</label>
            </div>
            <div class="field">
                <input type="password" name="password" required>
                <label>Password</label>
            </div>
            <div class="field">
                <input type="submit" value="Login" name="login_submit">
            </div>
            <div class="signup-link">
                Not a member? <a href="registration.php">Signup now</a>
            </div>
        </form>
    </div>
</body>
</html>
