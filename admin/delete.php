<?php 

session_start();


if(!isset($_SESSION['role']))
    header("Location: ./login.php");


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "school";
$conn = new mysqli($servername, $username, $password, $dbname);
$student = null;

if(isset($_GET['query'])){
    $query =  $_GET['query'];

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    // Check if the login form is submitted
    $stmt = $conn->prepare("SELECT * FROM student_information WHERE idNumber = ? LIMIT 1");
    $stmt->bind_param("s", $query);
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc();
}

$message= "";
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])){


    $id = $_POST['id'];
    $query = "DELETE FROM sitin WHERE student_id = '$id'";
    $result = $conn->query($query);

    // Check if the deletion was successful
    if (!$result) {
        $errorMessage = "Error: " . $conn->error;
        // Handle the error here, e.g., display an error message
        return;
    }
    $query = "DELETE FROM student_information WHERE id = '$id'";
    $result = $conn->query($query);

    // Check if the deletion was successful
    if (!$result) {
        $errorMessage = "Error: " . $conn->error;
        // Handle the error here, e.g., display an error message
    } else {
       header("Location: ./records.php");
    }
   
}
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title>registration</title>
    <link rel="stylesheet" href="../css/style.css">
      <script src="https://cdn.tailwindcss.com"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<head>
   <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
<link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
  </head>
  <body>
    <input type="checkbox" id="check">
    <label for="check">
      <i class="fas fa-bars" id="btn"></i>
      <i class="fas fa-times" id="cancel"></i>
    </label>
    <div class="sidebar">
      <header>Welcome</header>
      <a href="#" class="active">
        <i class="fas fa-edit"></i>
        <span>Home</span>
      </a>
      <a href="./search.php">
        <i class="fas fa-search"></i>
        <span>Search</span>
      </a>
      <a href="./delete.php">
        <i class="fas fa-solid fa-trash"></i>
        <span>Delete</span>
      </a>
      <a href="./records.php">
        <i class="fas fa-regular fa-eye"></i>
        <span>Sitin Records</span>
      </a>
      <a href="#">
        <i class="fas fa-solid fa-book"></i>
        <span>Reports</span>
      </a>
      <a href="#">
        <i class="fas fa-solid fa-arrow-up"></i>
        <span>Reset Session</span>
      </a>
      <a href="logout.php">
         <i class="fas  fa-arrow-left"></i> 
        <span>Logout</span>
      </a>
    </div>
</body>
    
  <div class="mx-auto container">
        <form method="get" action="" class="">
            <input type="text" name="query" placeholder="Search student..." class="border rounded-md px-3 p-2"/>  
            <input type="submit" value="Search" class="bg-purple-500 text-white px-3 p-2 rounded-md cursor-pointer"/>
        </form>
         <h1 class="text-xl font-bold text-center">DELETE STUDENT</h1>
        <?php if($student != null ){ ?>
        <p class="text-lg text-red-500"><?php echo $message;?></p>
       
        <form action="" method="post" class="mt-10 p-5 border rounded-md grid grid-cols-3 gap-4">
            <div class="flex flex-col">
                <label>IDNO</label>
                <div>
                    <input disabled type="text" value="<?php echo $student['idNumber']?>" class="border rounded-md px-3 p-2"/>
                </div>
            </div> 
     
                    <input type="hidden" name="id" value="<?php echo $student['id']?>" class="border rounded-md px-3 p-2"/>

            <div class="flex flex-col">
                <label>NAME</label>
                <div>
                    <input disabled type="text" value="<?php echo $student['fullName']?>" class="border rounded-md px-3 p-2"/>
                </div>
            </div> 
             <div class="flex flex-col">
                <label>Email</label>
                <div>
                    <input disabled type="text"  value="<?php echo $student['email']?>" class="border rounded-md px-3 p-2"/>
                   
                </div>
            </div> 
              <div class="flex flex-col">
                <label>Phone Number</label>
                <div>
                    <input disabled type="text"  value="<?php echo $student['phoneNumber']?>" class="border rounded-md px-3 p-2"/>
                   
                </div>
            </div> 
              <div class="flex flex-col">
                <label>Sessions Available</label>
                <div>
                    <input disabled type="text"  value="<?php echo $student['sessions']?>" class="border rounded-md px-3 p-2"/>
                    
                </div>
            </div> 
             <div class="flex flex-col">
                <label>Sessions Available</label>
                <div>
                    <input disabled type="text"  value="<?php echo $student['sessions']?>" class="border rounded-md px-3 p-2"/>
                    <input  type="hidden" name="sessions" value="<?php echo $student['sessions']?>" class="border rounded-md px-3 p-2"/>
                </div>
            </div> 
          
           
            <div class="col-span-3">
                <input type="submit" value="Delete" class="px-3 p-2 bg-red-500 rounded-md w-full text-white  cursor-pointer"/>
            </div>
        </form>
        <?php }?>
  </div>
    
</body>

</html>