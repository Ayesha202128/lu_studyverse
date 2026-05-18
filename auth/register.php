<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - LU StudyVerse</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <link rel="stylesheet"
    href="/lu_studyverse/assets/css/auth.css">
</head>

<body>

<div class="container">

    <!-- LEFT SIDE -->
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

    <!-- RIGHT SIDE -->
    <div class="right">

        <h2>Create Account</h2>

        <p>Join the community of scholars today.</p>

        <!-- TABS -->
        <div class="tabs">
            <button class="active" type="button">
                Register
            </button>

            <button
                type="button"
                onclick="window.location.href='login.php'">
                Login
            </button>
        </div>

        <!-- ERROR MESSAGE -->
        <?php if(isset($_SESSION['error']) && $_SESSION['error'] != ""){ ?>

            <div style="
                background:#ffdddd;
                color:#a30000;
                padding:10px;
                border-radius:8px;
                margin-bottom:10px;
                font-size:13px;
            ">
                <?php echo $_SESSION['error']; ?>
            </div>

        <?php } ?>

        <!-- SUCCESS MESSAGE -->
        <?php if(isset($_SESSION['success']) && $_SESSION['success'] != ""){ ?>

            <div style="
                background:#ddffdd;
                color:#0a6b0a;
                padding:10px;
                border-radius:8px;
                margin-bottom:10px;
                font-size:13px;
            ">
                <?php echo $_SESSION['success']; ?>
            </div>

        <?php } ?>

        <?php
        unset($_SESSION['error']);
        unset($_SESSION['success']);
        ?>

        <!-- REGISTER FORM -->
        <form action="register_action.php" method="POST">

            <!-- FULL NAME -->
            <label>Full Name</label>
            <input type="text" name="fullname" placeholder="Enter your full name" required>

            <!-- EMAIL -->
            <label>Academic Email</label>
            <input type="email" name="email" placeholder="name@university.edu" required>

            <!-- PASSWORD -->
            <label>Password</label>
            <input type="password" name="password" placeholder="••••••••" required>

            <!-- CONFIRM PASSWORD -->
            <label>Confirm Password</label>
            <input type="password" name="confirm_password" placeholder="••••••••" required>

            <!-- BUTTON -->
            <button type="submit" name="register" class="btn">
                Create Account
            </button>

        </form>

    </div>

</div>

</body>
</html>