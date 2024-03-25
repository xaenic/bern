<?php

session_start();

if(!isset($_SESSION['role']))
  header("Location: ./login.php");

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title>registration</title>
    <link rel="stylesheet" href="../css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
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
      <a href="#">
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
    
  <div class="frame">
    <div class="card card1">
      <h5>LAB 526</h5>
      <p>weeeeeelcome</p>
    </div>
    <div class="card card1">
      <h5>LAB 524</h5>
      <p>weeeeeelcome</p>
    </div>
    <div class="card card1">
      <h5>LAB 528</h5>
      <p>weeeeeelcome</p>
    </div>
    <div class="card card1">
      <h5>LAB 542</h5>
      <p>weeeeeelcome</p>
    </div>
    
</body>

</html>