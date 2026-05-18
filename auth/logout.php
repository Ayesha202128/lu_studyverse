<?php

session_start();

// সব session remove করবে
session_unset();

// session destroy করবে
session_destroy();

// login page এ পাঠাবে
header("Location: ../index.php");
exit();

?>