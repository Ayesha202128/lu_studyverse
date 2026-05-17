<?php

session_start();

if(!isset($_SESSION['user_id'])){

    header("Location: /studyverse/auth/login.php");
    exit();
}

?>

<h1>

Welcome
<?php
echo $_SESSION['fullname'];
?>

</h1>

<a href="../auth/logout.php">

Logout

</a>