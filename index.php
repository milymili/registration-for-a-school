<?php
session_start();
include_once "db.php";
// include "session_manage.php";
if(!isset($_SESSION['user_id'])){
    // header("location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body>
    <form name="search" method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <input class="w3-input" placeholder="search for student" type="text" name="q">
    <button class="w3-btn w3-black">Search</button>
    </form>

    <?php if(!empty($_SESSION['message'])){?>
        <div class="w3-panel w3-yellow">
  
  <p><?php echo $_SESSION['message'];?></p>
</div> 
    <?php 
    $_SESSION['message'] = '';
    }?>


    <h1 style="text-align:center">Registered Students</h1>
    <div class="w3-container">
  
  <table class="w3-table w3-striped">
    <tr>
        <td>#</td>
      <th>Full Name</th>
      <th>School</th>
      <th>Year</th>
      <th>Contact</th>
      <th>Age</th>
      <!-- <th>Date</th> -->
      <th><button onclick="document.getElementById('addStudent').style.display='block'" class="w3-button w3-black">New Student</button></th>
      <th><button onclick="document.getElementById('addUser').style.display='block'" class="w3-button w3-khaki">New User</button></th>
    </tr>
    
   <?php 
   $stmt = "SELECT * FROM student";
   $q = $conn->prepare($stmt);
   $q->execute();
   if(isset($_GET['q'])){
    $stmt = "SELECT * FROM student WHERE `name` LIKE :q OR school LIKE :q";
    $q = $conn->prepare($stmt);
    $q->execute([":q"=>"%".$_GET['q']."%"]);
   }
   
//    die($ro);
   foreach($q->fetchAll(PDO::FETCH_ASSOC) as $row){
    $id = $row['id'];
   ?>
    <tr>
      <td><?php echo $row["id"];?></td>
      <td><?php echo $row["name"];?></td>
      <td><?php echo $row["school"];?></td>
      <td><?php echo $row["year"];?></td>
      <td><?php echo $row["contact"];?></td>
      <td><?php echo $row["age"];?></td>
      <td>
        <a class="w3-red w3-button" href="control.php?delete=<?php echo $row['id'];?>">Delete</a>
      </td>
      <td>
      <button onclick="document.getElementById('editStudent<?php echo $id;?>').style.display='block'" class="w3-button w3-black">Edit</button>

      <div id="editStudent<?php echo $id; ?>" class="w3-modal">
  <div class="w3-modal-content">
    <header class="w3-container w3-teal"> 
      <span onclick="document.getElementById('editStudent<?php echo $id; ?>').style.display='none'" 
      class="w3-button w3-display-topright">&times;</span>
      <h2>Add Student</h2>
    </header>
    <form class="w3-container w3-padding-24" action="control.php" method="post">
        <p>
        <label>Full Name</label>
        <input class="w3-input" type="text" name="fname"  value='<?php echo $row["name"]; ?>'></p>
        <p>
        <label>Age</label>
        <input class="w3-input" type="number" name="age" value='<?php echo $row["age"]; ?>'></p>
        <p>
        <label>School</label>
        <input class="w3-input" type="text" name="school" value='<?php echo $row["school"]; ?>'></p>
        <p>
        <label>Year</label>
        <input class="w3-input" type="number" name="year" value='<?php echo $row["year"]; ?>'></p>
        <p>
            <input type="hidden" name="stud_id" value="<?php echo $id?>">
        <label>Contact</label>
        <input class="w3-input" type="text" name="contact" value='<?php echo $row["contact"]; ?>'></p>
        <input class="w3-btn w3-black" value="Submit" type="submit" name="edit_student">
      </form>
   
  </div>
</div>

      </td>
    </tr>
    <?php }?>
  </table>
  <?php
//    echo $_SESSION['user_id'];
//   print_r($_SESSION);
   ?>
</div>
</body>


<div id="addStudent" class="w3-modal">
  <div class="w3-modal-content">
    <header class="w3-container w3-teal"> 
      <span onclick="document.getElementById('addStudent').style.display='none'" 
      class="w3-button w3-display-topright">&times;</span>
      <h2>Add Student</h2>
    </header>
    <form class="w3-container w3-padding-24" action="control.php" method="post">
        <p>
        <label>Full Name</label>
        <input class="w3-input" type="text" name="fname"></p>
        <p>
        <label>Age</label>
        <input class="w3-input" type="number" name="age"></p>
        <p>
        <label>School</label>
        <input class="w3-input" type="text" name="school"></p>
        <p>
        <label>Year</label>
        <input class="w3-input" type="number" name="year"></p>
        <p>
        <label>Contact</label>
        <input class="w3-input" type="text" name="contact" ></p>
        <p>
        <!-- <label>Date</label>
        <input class="w3-input" type="date" name="date"></p> -->
        <input class="w3-btn w3-black" value="Submit" type="submit" name="add_student">
      </form>
   
  </div>
</div>

  

<div id="addUser" class="w3-modal">
  <div class="w3-modal-content">
    <header class="w3-container w3-teal"> 
      <span onclick="document.getElementById('addUser').style.display='none'" 
      class="w3-button w3-display-topright">&times;</span>
      <h2>Add User</h2>
    </header>
    <form method="post" class="w3-container w3-padding-24" action="control.php">
        <p>
        <label>Username</label>
        <input class="w3-input" type="text" name="uname"></p>
        <p>
        <label>Password</label>
        <input class="w3-input" type="password" name="pwd"></p>
       
        <input class="w3-btn w3-black" type="submit" name="new_user" value="submit">
      </form>
   
  </div>
</div>
</html>