<?php
session_start();
include '../config/db.php';

if(isset($_POST['login'])){

    $email = $_POST['email'];
    $password = $_POST['password'];

    // database থেকে user খুঁজবে
    $sql = "SELECT * FROM users WHERE email='$email'";

    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0){

        $user = mysqli_fetch_assoc($result);

        // password check
        if(password_verify($password, $user['password'])){

            // session start
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['fullname'] = $user['fullname'];
            $_SESSION['email'] = $user['email'];

           header("Location: ../dashboard/dashboard.php");
            exit();

        }else{
            echo "Wrong Password!";
        }

    }else{
        echo "Email Not Found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Login - LU StudyVerse</title>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<link rel="stylesheet"
href="/lu_studyverse/assets/css/auth.css">

</head>

<body>

<div class="container">

<!-- LEFT -->
<div class="left">

<div>
<h2>📘 LU StudyVerse</h2>

<h1>Elevate Your Academic Journey.</h1>

<p>
Access a curated ecosystem of research materials,
lecture notes, and collaborative study tools designed for excellence.
</p>
</div>

<div class="quote">
"The most efficient way to organize my research papers and collaborate with my lab team."
<br><br>
<b>Dr. Example User</b>
</div>

</div>

<!-- RIGHT -->
<div class="right">

<h2>Welcome Back</h2>
<p>Please enter your credentials to continue</p>

<div class="tabs">
<button onclick="window.location.href='register.php'">
Register
</button>

<button class="active">
Login
</button>
</div>

<!-- IMPORTANT: FORM -->
<form method="POST">

<label>Email</label>
<input
type="email"
name="email"
placeholder="name@university.edu"
required>

<label>Password</label>
<input
type="password"
name="password"
placeholder="••••••••"
required>

<button
type="submit"
name="login"
class="btn">

Sign In

</button>

</form>

<div class="small">
Forgot password?
</div>

</div>

</div>

</body>
</html>

