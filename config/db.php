<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "lu_studyverse";

// Database-er sathe connection toiri
$conn = mysqli_connect($host, $user, $pass, $dbname);

// Connection check kora
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>