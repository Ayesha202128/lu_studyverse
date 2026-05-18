<?php

session_start(); // ⭐ MUST ADD

error_reporting(E_ALL);
ini_set('display_errors', 1);

include __DIR__ . '/../config/db.php';

if(isset($_POST['register'])){

    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    if(empty($fullname) || empty($email) || empty($password)){
        die("All fields are required.");
    }

    if($password !== $confirm_password){
        die("Passwords do not match.");
    }

    // check email
    $checkEmail = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $checkEmail);

    if(mysqli_num_rows($result) > 0){
        die("Email already registered.");
    }

    // hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $verification_code = md5(rand());

    $sql = "INSERT INTO users 
    (fullname, email, password, verification_code)
    VALUES 
    ('$fullname', '$email', '$hashed_password', '$verification_code')";

    if(mysqli_query($conn, $sql)){

        // ⭐ SESSION SET
        $_SESSION['user_id'] = mysqli_insert_id($conn);
        $_SESSION['fullname'] = $fullname;

        // ⭐ REDIRECT TO HOME
        header("Location: ../dashboard/dashboard.php");
        exit();

    } else {
        die("Insert Failed: " . mysqli_error($conn));
    }
}
?>