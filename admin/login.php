<?php


session_start();

if(isset($_SESSION['role'])){

    header("Location: ./admin.php");
}
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

    if($email != "" && $password != ""){

        if($email == "admin@gmail.com" && $password == "admin123"){

            $_SESSION['role'] = 'admin';

            header('Location: ./admin.php');
        }
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>login</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="">
       <div class="border shadow-lg p-10 rounded-md">
         <div class="title text-xl font-semibold">
            Admin Login Dashboard
        </div>
        <form action="" method="post" class="flex flex-col gap-4">
            <div class="field flex flex-col">
                <label>Email Address</label>
                <input placeholder="Email" class="border px-3 p-2  rounded-md" name="email"type="text" name="email" required>
                
            </div>
            <div class="field flex flex-col">
                   <label>Password</label>
                <input placeholder="Password" class="border px-3 p-2  rounded-md" name="password"type="password" name="password" required>
             
            </div>
            <div class="field">
                <input class="w-full bg-blue-500 rounded-md  text-white p-2" type="submit" value="Login" name="login_submit">
            </div>
        </form>
       </div>
    </div>
</body>
</html>
