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
$query = "SELECT * FROM sitin INNER JOIN student_information ON student_information.id = sitin.student_id WHERE time_out IS NOT NULL ORDER BY time_out";
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
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
      <a href="./generate.php">
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
        <div class="flex justify-between items-center mb-3">
            <div class="flex  items-center gap-2">
                <input type="text" placeholder="Search" id="search" class="border border-gray-200 rounded-md px-3 p-2"/>
                    <div class="bg-sky-500 text-white px-3 p-2 rounded-md flex items-center gap-3">
                   
                    <button id="generate" class="">Download Data</button>
                </div>
            </div>
             <div class="flex items-center gap-2">
                <select name="status" id="purpose" class="flex-1 text-gray-700 border p-2 rounded-md">
                                  <option value="Lab 524" selected disabled hidden>Purpose</option>
                                  <option value="Java">Java</option>
                                  <option value="Python">Python</option>
                                  <option value="C">C</option>
                                  <option value="C++">C++</option>
                                  <option value="C#">C#</option>
                                  <option value="Others">Others</option>
              </select>
               <select name="laboratory" id="laboratory" class="flex-1 text-gray-700 border p-2 rounded-md">
                        <option value="Lab 524" selected disabled hidden>Laboratory</option>
                        <option value="Lab 524">Lab 524</option>
                        <option value="Lab 526">Lab 526</option>
                        <option value="Lab 528">Lab 528</option>
                        <option value="Lab 542">Lab 542</option>
                        <option value="Lab 543">Lab 543</option>
              </select>
              <div class="">
                <input type="text" id="datetimepicker" placeholder="From Date" class="outline-none px-3 rounded-md form-input w-full border border-gray-200 px-3 p-2">
              </div>
            </div>
        </div>
        <table id="oktable"class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 ">
                <thead class="text-xs border    text-black uppercase ">
                    <tr>
                        <th class="border px-4 py-4 font-medium border-none text-black text-center font-bold">ID NO</th>
                        <th class="border px-4 py-4 font-medium border-none text-black text-center">FULL NAME</th>
                        <th class="border px-4 py-4 font-medium border-none text-black text-center">Purpose</th>
                      
                        
                        <th class="border px-4 py-4 font-medium border-none text-black text-center">Laboratory</th>
                          <th class="border px-4 py-4 font-medium border-none text-black text-center">EMAIL</th>
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
                              
                                <td class="border px-4 py-4 border-none text-center text-xs md:text-sm text-black">'.$student['purpose'].'</td>
                                <td class="border px-4 py-4 border-none text-center text-xs md:text-sm text-black">'.$student['laboratory'].'</td>
                                  <td class="border px-4 py-4 border-none text-center text-xs md:text-sm text-black">'.$student['email'].'</td>
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
      <script src="xlsx.full.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  
    <script>

        $(document).ready(function() {

           
            const students = <?php echo json_encode($students); ?>;
            
             $("#generate").click(function(){

                var table = document.getElementById('oktable');
               var wb = XLSX.utils.table_to_book(table);

    // Save the workbook as an Excel file
                XLSX.writeFile(wb, `downloaded_data.xlsx`);
            })
            function studentRow(student,statusElement,time_in,time_out) {
                return `<tr class=""><td class="border px-4 py-4 border-none text-center text-xs md:text-sm text-black">${student.idNumber}</td><td class="border px-4 py-4 border-none text-center text-xs md:text-sm text-black">${student.fullName}</td><td class="border px-4 py-4 border-none text-center text-xs md:text-sm text-black">${student.purpose}</td><td class="border px-4 py-4 border-none text-center text-xs md:text-sm text-black">${student.laboratory}</td><td class="border px-4 py-4 border-none text-center text-xs md:text-sm text-black">${student.email}</td><td class="border px-4 py-4 border-none text-center text-xs md:text-sm text-black">${student.time_in}</td><td class="border px-4 py-4 border-none text-center text-xs md:text-sm text-black">${student.time_out}</td></tr>`
            }
            $("#search").on('input', function() {
                 
               
                 if(this.value == "")
                   return restore(students);
                 let data = "";
                    students.forEach(student => {
                        const studentDate = student.time_in.split(' ')[0];
                        const time_in = new Date(student.time_in).toLocaleString('en-US', { month: 'long', day: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' });
                         const time_out = new Date(student.time_in).toLocaleString('en-US', { month: 'long', day: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' });
                        if(student.idno == this.value) {
                            const statusElement = student.time_out !== null 
                            ? `<span href="#" class="text-white bg-green-500 px-3 p-2 rounded-md">Finished</span>` 
                            : `<a href="./timeout.php?id=${student['id']}&s_id=${student['session_id']}" class="text-white bg-red-500 px-3 p-2 rounded-md">Logout</a>`;
                            data += studentRow(student,statusElement,time_in,time_out);
                        }
                       
                    })
                   if(data != "")
                   $("#tbody").html(data)
                   else 
                    $("#tbody").html('<span class="text-xl font-semibold text-black text-center w-full">No records found</span>')
            })
            $("#purpose").change(function() {
               
                 if(this.value == "")
                   return restore(students);
                 let data = "";
                    students.forEach(student => {
                        const studentDate = student.time_in.split(' ')[0];
                        const time_in = new Date(student.time_in).toLocaleString('en-US', { month: 'long', day: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' });
                         const time_out = new Date(student.time_in).toLocaleString('en-US', { month: 'long', day: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' });
                        if(student.purpose == this.value) {
                            const statusElement = student.time_out !== null 
                            ? `<span href="#" class="text-white bg-green-500 px-3 p-2 rounded-md">Finished</span>` 
                            : `<a href="./timeout.php?id=${student['id']}&s_id=${student['session_id']}" class="text-white bg-red-500 px-3 p-2 rounded-md">Logout</a>`;
                            data += studentRow(student,statusElement,time_in,time_out);
                        }
                       
                    })
                   if(data != "")
                   $("#tbody").html(data)
                   else 
                    $("#tbody").html('<span class="text-xl font-semibold text-black text-center w-full">No records found</span>')
            })
             $("#laboratory").change(function() {
               
                 if(this.value == "")
                   return restore(students);
                 let data = "";
                    students.forEach(student => {
                        const studentDate = student.time_in.split(' ')[0];
                        const time_in = new Date(student.time_in).toLocaleString('en-US', { month: 'long', day: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' });
                         const time_out = new Date(student.time_in).toLocaleString('en-US', { month: 'long', day: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' });
                        if(student.laboratory == this.value) {
                            const statusElement = student.time_out !== null 
                            ? `<span href="#" class="text-white bg-green-500 px-3 p-2 rounded-md">Finished</span>` 
                            : `<a href="./timeout.php?id=${student['id']}&s_id=${student['session_id']}" class="text-white bg-red-500 px-3 p-2 rounded-md">Logout</a>`;
                            data += studentRow(student,statusElement,time_in,time_out);
                        }
                       
                    })
                   if(data != "")
                   $("#tbody").html(data)
                   else 
                    $("#tbody").html('<span class="text-xl font-semibold text-black text-center w-full">No records found</span>')
            })
          
            flatpickr('#datetimepicker', {
                dateFormat: "F j, Y",
                onChange: function(selectedDates, dateStr, instance) {
                    
                    const selectedDate = formatDate(dateStr);
                   
                    let data = "";
                    students.forEach(student => {
                        const studentDate = student.time_in.split(' ')[0];
                        const time_in = new Date(student.time_in).toLocaleString('en-US', { month: 'long', day: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' });
                         const time_out = new Date(student.time_in).toLocaleString('en-US', { month: 'long', day: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' });
                        if(selectedDate == studentDate) {
                            const statusElement = student.time_out !== null 
                            ? `<span href="#" class="text-white bg-green-500 px-3 p-2 rounded-md">Finished</span>` 
                            : `<a href="./timeout.php?id=${student['id']}&s_id=${student['session_id']}" class="text-white bg-red-500 px-3 p-2 rounded-md">Logout</a>`;
                           data += studentRow(student,statusElement,time_in,time_out);
                        }
                       
                    })
                   if(data != "")
                   $("#tbody").html(data)
                   else 
                    $("#tbody").html('<span class="text-xl font-semibold text-black text-center w-full">No records found</span>')
                }
            
            });


            function formatDate(dateString) {
    
                const date = new Date(dateString);

                
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0'); 
                const day = String(date.getDate()).padStart(2, '0');
                const formattedDate = `${year}-${month}-${day}`;

                return formattedDate;
            }

            function restore(students) {
                let data= "";
               
                students.forEach(student => {

                    const studentDate = student.time_in.split(' ')[0];
                        const time_in = new Date(student.time_in).toLocaleString('en-US', { month: 'long', day: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' });
                    const time_out = new Date(student.time_in).toLocaleString('en-US', { month: 'long', day: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' });
                     const statusElement = student.time_out !== null 
                            ? `<span href="#" class="text-white bg-green-500 px-3 p-2 rounded-md">Finished</span>` 
                            : `<a href="./timeout.php?id=${student['id']}&s_id=${student['session_id']}" class="text-white bg-red-500 px-3 p-2 rounded-md">Logout</a>`;
                            data += studentRow(student,statusElement,time_in,time_out);
                })

                  if(data != "")
                   $("#tbody").html(data)
                   else 
                    $("#tbody").html('<span class="text-xl font-semibold text-black text-center w-full">No records found</span>')
                        
            }

        });
        // Initialize Flatpickr
        
    </script>
</body>

</html>