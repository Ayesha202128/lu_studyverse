<?php
session_start();
include __DIR__ . '/../config/db.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php';

if(isset($_POST['register'])){

    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // RESET messages
    unset($_SESSION['error']);
    unset($_SESSION['success']);

    // VALIDATION
    if(empty($fullname) || empty($email) || empty($password)){
        $_SESSION['error'] = "All fields are required.";
        header("Location: register.php");
        exit();
    }

    if($password !== $confirm_password){
        $_SESSION['error'] = "Passwords do not match.";
        header("Location: register.php");
        exit();
    }

    if(strlen($password) < 6){
        $_SESSION['error'] = "Password must be at least 6 characters.";
        header("Location: register.php");
        exit();
    }

    // CHECK EMAIL
    $check = "SELECT id FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $check);

    if(mysqli_num_rows($result) > 0){
        $_SESSION['error'] = "Email already registered.";
        header("Location: register.php");
        exit();
    }

    // HASH PASSWORD
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // VERIFY CODE
    $verification_code = bin2hex(random_bytes(32));

    // INSERT USER
    $sql = "INSERT INTO users
    (fullname, email, password, is_verified, verification_code)
    VALUES
    ('$fullname', '$email', '$hashed_password', 0, '$verification_code')";

    if(mysqli_query($conn, $sql)){

        // =========================
        // SEND EMAIL (ONLY LINK)
        // =========================
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;

            $mail->Username = 'cse_0182310012101086@lus.ac.bd';
            $mail->Password = 'iwdc jdas ywzm mazz';

            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('cse_0182310012101086@lus.ac.bd', 'LU StudyVerse');
            $mail->addAddress($email);

            $verify_link = "http://localhost/lu_studyverse/auth/verify.php?code=".$verification_code;

            $mail->isHTML(true);
            $mail->Subject = "Verify Your Account";
            $mail->Body = "
                <h3>Account Verification</h3>
                <p>Click the link below to verify your account:</p>
                <a href='$verify_link'>Verify Account</a>
            ";

            $mail->send();

            $_SESSION['success'] = "Registration successful! Please check your email to verify your account.";
            header("Location: register.php");
            exit();

        } catch (Exception $e) {
            $_SESSION['error'] = "Verification email could not be sent.";
            header("Location: register.php");
            exit();
        }

    } else {
        $_SESSION['error'] = "Database error.";
        header("Location: register.php");
        exit();
    }
}
?>