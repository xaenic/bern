<?php 

date_default_timezone_set('Asia/Manila');
session_start();
if(!isset($_SESSION['role'])) {
    header("Location: ./login.php");
}
if(!isset($_GET['id']))
    header("Location: ./records.php");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "school";
$conn = new mysqli($servername, $username, $password, $dbname);
$student = null;
$newTimeOut = date("Y-m-d H:i:s");
$studentId = $_GET['id']; 
$s_id = $_GET['s_id']; 

$query = "UPDATE sitin SET time_out = '$newTimeOut' WHERE student_id = '$studentId' AND s_id = '$s_id'";
$result = $conn->query($query);

if (!$result) {
    $errorMessage = "Error: " . $conn->error;
}
$student = null;
$query = "SELECT * FROM student_information WHERE id = '$studentId' LIMIT 1";
$result = mysqli_query($conn, $query);
if($result && mysqli_num_rows($result) > 0)
{
    $student = mysqli_fetch_assoc($result);
}
$newSession = $student['sessions'] - 1;
$query = "UPDATE student_information SET sessions = '$newSession' WHERE id = '$studentId'";
$result = $conn->query($query);

if (!$result) {
    $errorMessage = "Error: " . $conn->error;
} else {
    header("Location: ./records.php");
}
?>