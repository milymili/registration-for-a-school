<?php
session_start();
include "db.php";

if(isset($_POST["new_user"])){
    $username = $_POST['uname'];
    $passw = $_POST['pwd'];

    $passw = password_hash($passw, PASSWORD_DEFAULT);
    $check = $conn->prepare("SELECT * FROM user WHERE username=:username");
    $check->execute([":username"=>$username]);
    $st = $check->fetchAll(PDO::FETCH_ASSOC);
    if(count($st)>0){
        $_SESSION['message'] = "User with $username already exists";
        header("location: /");
    }
    $stmt = "INSERT INTO user SET username=:username, `password`=:pass";
    $s = $conn->prepare($stmt);
    $s->execute([":username"=>$username, ":pass"=>$passw]);
    $_SESSION["message"] = "User added successfully";
    header("location: /");
}

if(isset($_POST['login_button'])){
    $username = $_POST['uname'];
    $passw = $_POST['pwd'];
    
    $passw = password_hash($passw, PASSWORD_DEFAULT);
    $check = $conn->prepare("SELECT * FROM user WHERE username=:username LIMIT 1");
    $check->execute([":username"=>$username]);
    $st = $check->fetch(PDO::FETCH_ASSOC);
    // print_r($st);
    // die();
    if(count($st)>0){
        // die(json_encode($st[0]));
        if(password_verify($passw, $st['password'])){
            $_SESSION['message'] = "User with username $username is logged in";
            $_SESSION['user_id'] = $st['id'];
            header("location: /");
        }else{
            $_SESSION['message'] = "User with username $username doesn't exists";
        header("location: /");
        }
        
    }
    
    // $_SESSION["message"] = "Login was successfully";
    // header("location: /");
}

if(isset($_POST['add_student'])){
    $fname = $_POST['fname'];
    $age = $_POST['age'];
    $school = $_POST['school'];
    $year = $_POST['year'];
    $date = $_POST['date'];
    $contact = $_POST['contact'];

    $stmt = "INSERT INTO student SET `name`=:fname,	school=:school,	`year`=:yr,	age=:age,	contact=:contact, added_by=:user_id";
    $st = $conn->prepare($stmt);
    $st->execute([":fname"=>$fname, ":school"=>$school, ':yr'=>$year, ":age"=>$age, ":contact"=>$contact, ":user_id"=>4]);
    $_SESSION['message'] = "Student added successfully";
    header("location: /");
}

if(isset($_GET['delete'])){
    $stmt = "DELETE FROM student WHERE  id=:id";
    $s = $conn->prepare($stmt);
    $s->execute([":id"=>$_GET['delete']]);

    $_SESSION['message'] = "Student with ID ".$_GET['delete']." was deleted";
    header("location: /");
}

if(isset($_POST['edit_student'])){
    $fname = $_POST['fname'];
    $age = $_POST['age'];
    $school = $_POST['school'];
    $year = $_POST['year'];
    $date = $_POST['date'];
    $contact = $_POST['contact'];

    $stmt = "UPDATE student SET `name`=:fname,	school=:school,	`year`=:yr,	age=:age,	contact=:contact WHERE id=:id";
    $st = $conn->prepare($stmt);
    $st->execute([":fname"=>$fname, ":school"=>$school, ':yr'=>$year, ":age"=>$age, ":contact"=>$contact, ":id"=>$_POST['stud_id']]);
    $_SESSION['message'] = "Student updated successfully";
    header("location: /");
}