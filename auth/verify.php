<?php
include __DIR__ . '/../config/db.php';

if(isset($_GET['code'])){

    $code = $_GET['code'];

    $sql = "SELECT * FROM users WHERE verification_code='$code'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0){

        $update = "UPDATE users 
        SET is_verified=1, verification_code=NULL
        WHERE verification_code='$code'";

        mysqli_query($conn, $update);

        echo "Account Verified Successfully! You can now login from you login in page..";

    } else {
        echo "Invalid verification link!";
    }

} else {
    echo "No verification code found!";
}
?>