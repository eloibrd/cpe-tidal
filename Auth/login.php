<?php
include '../API/DatabaseDriver.php';
session_start();

if (isset($_POST['log_user'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $errors = array();
    $dbd = new DatabaseDriver;
    $db_pass = $dbd->getUserPassword($username);
    if(empty($db_pass)){
        array_push($errors, "Username not found");
        var_dump($errors);
        $_POST['errors'] = $errors;
        header("Location: ../Application/connexion.html");
        exit();
    }else{
        if(password_verify($password, $db_pass[0]['password'])){
            $_SESSION['username'] = $username;
  	        $_SESSION['success'] = "You are now logged in";
            header("Location: ../Application/home.php");
            exit();
        }
        else{
            array_push($errors, "Wrong password");
            var_dump($errors);
            $_POST['errors'] = $errors;
            header("Location: ../Application/connexion.html");
            exit();
        }
    }
}

print_r('test');
?>
