<?php
include '../config/db.php';
session_start();

if(isset($_GET['code'])){

    $code = $_GET['code'];

    $sql = "SELECT * FROM users WHERE verification_code='$code'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0){

        $user = mysqli_fetch_assoc($result);

        // UPDATE USER VERIFIED
        $update = "UPDATE users 
                   SET is_verified=1, verification_code=NULL 
                   WHERE id=".$user['id'];

        mysqli_query($conn, $update);

        $_SESSION['success'] = "Email verified successfully. You can now login.";

        // 🔥 DIRECT LOGIN REDIRECT
        header("Location: login.php");
        exit();

    } else {
        $_SESSION['error'] = "Invalid or expired verification link.";
        header("Location: login.php");
        exit();
    }

} else {
    header("Location: login.php");
    exit();
}
?>