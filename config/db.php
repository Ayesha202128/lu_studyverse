<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "lu_studyverse";

$conn = mysqli_connect(
    $host,
    $user,
    $password,
    $database
);

if(!$conn){
    die("Database Connection Failed");
}

?>