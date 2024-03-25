<?php 

session_start();


if(!isset($_SESSION['role']))
    header("Location: ./login.php");


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "school";
$conn = new mysqli($servername, $username, $password, $dbname);
$students = [];
$query = "SELECT * FROM sitin INNER JOIN student_information ON student_information.id = sitin.student_id ORDER BY time_out";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $students[] = $row;
        }
    }
$message= "";
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id = $_POST['id'];
    $s_id = $_POST['s_id'];

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
       
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 ">
                <thead class="text-xs border    text-black uppercase ">
                    <tr>
                        <th class="border px-4 py-4 font-medium border-none text-black text-center font-bold">ID NO</th>
                        <th class="border px-4 py-4 font-medium border-none text-black text-center">FIRST NAME</th>
                        <th class="border px-4 py-4 font-medium border-none text-black text-center">EMAIL</th>
                        <th class="border px-4 py-4 font-medium border-none text-black text-center">Purpose</th>
                        <th class="border px-4 py-4 font-medium border-none text-black text-center">Laboratory</th>
                        <th class="border px-4 py-4 font-medium border-none text-black text-center">Time In</th>
                        <th class="border px-4 py-4 font-medium border-none text-black text-center">Time Out</th>
                        
                    </tr>
                </thead>
                <tbody id="tbody" class="relative">
                    
                
               

                <?php 
                if(count($students) > 0 ){
                     foreach ($students as $student) {
                   echo '<tr class="border">
                                <td class="border px-4 py-4 border-none text-center text-xs md:text-sm text-black">'.$student['idNumber'].'</td>
                                <td class="border px-4 py-4 border-none text-center text-xs md:text-sm text-black">'.$student['fullName'].'</td>
                                <td class="border px-4 py-4 border-none text-center text-xs md:text-sm text-black">'.$student['email'].'</td>
                                <td class="border px-4 py-4 border-none text-center text-xs md:text-sm text-black">'.$student['purpose'].'</td>
                                <td class="border px-4 py-4 border-none text-center text-xs md:text-sm text-black">'.$student['laboratory'].'</td>
                                <td class="border px-4 py-4 border-none text-center text-xs md:text-sm text-black">'.$student['time_in'].'</td>
                              <td class="border px-4 py-4 border-none text-center text-xs md:text-sm text-black">' . ($student['time_out'] !== null ? $student['time_out'] : '<a href="./timeout.php?id='.$student['id'].'&s_id='.$student['s_id'].'" class="text-white bg-purple-500 px-3 p-2 rounded-md">Logout</a>') . '</td>
                                </tr>';
                }
                }
                else {
                    echo '<tr><span class="text-semibold text-red-500">No Student found</span></tr>';
                }
           
            ?>

                </tbody>

            </table>
  </div>
    
</body>

</html>