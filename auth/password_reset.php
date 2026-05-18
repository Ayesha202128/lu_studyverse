<?php
session_start();
include '../config/db.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

use PHPMailer\PHPMailer\PHPMailer;
require __DIR__ . '/../vendor/autoload.php';

$base_url = "http://localhost/lu_studyverse/auth/password_reset.php";


// =============================
// EMAIL FUNCTION
// =============================
function sendMail($to, $subject, $body){

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
        $mail->addAddress($to);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;

        return $mail->send();

    } catch (Exception $e) {
        return false;
    }
}


// =============================
// SEND RESET LINK
// =============================
if(isset($_POST['send_link'])){

    $email = trim($_POST['email']);

    $stmt = $conn->prepare("SELECT id FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows == 0){
        $_SESSION['error'] = "Email not found!";
        header("Location: password_reset.php");
        exit();
    }

    $token = bin2hex(random_bytes(32));

    $stmt = $conn->prepare("UPDATE users SET reset_token=? WHERE email=?");
    $stmt->bind_param("ss", $token, $email);
    $stmt->execute();

    $reset_link = $base_url . "?token=" . $token;

    $subject = "Password Reset Request";

    $body = "
        <h3>Password Reset Request</h3>
        <p>Click the link below to reset your password:</p>
        <a href='$reset_link'>Reset Password</a>
    ";

    if(sendMail($email, $subject, $body)){
        $_SESSION['success'] = "A password reset link has been sent to your email address.";
        $_SESSION['sent'] = true;
        $_SESSION['email'] = $email;
    } else {
        $_SESSION['success'] = "Mail not configured. Use this link: $reset_link";
        $_SESSION['sent'] = true;
        $_SESSION['email'] = $email;
    }

    header("Location: password_reset.php");
    exit();
}


// =============================
// UPDATE PASSWORD
// =============================
if(isset($_POST['update_pass'])){

    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    if($password !== $confirm){
        $_SESSION['error'] = "Passwords do not match!";
        header("Location: password_reset.php?token=".$_GET['token']);
        exit();
    }

    $hashed = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("
        UPDATE users 
        SET password=?, reset_token=NULL 
        WHERE email=?
    ");

    $stmt->bind_param("ss", $hashed, $email);

    if($stmt->execute()){
        $_SESSION['success'] = "Password updated successfully!";
        header("Location: login.php");
        exit();
    } else {
        $_SESSION['error'] = "Update failed!";
        header("Location: password_reset.php");
        exit();
    }
}


// =============================
// TOKEN PAGE (RESET FORM)
// =============================
if(isset($_GET['token'])){

    $token = $_GET['token'];

    $stmt = $conn->prepare("SELECT email FROM users WHERE reset_token=?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows == 0){
        die("Invalid or expired token");
    }

    $user = $result->fetch_assoc();
    $email = $user['email'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <link rel="stylesheet" href="/lu_studyverse/assets/css/auth.css">
</head>
<body>

<div class="container">
    <div class="right">

        <h2>Reset Password</h2>

        <?php if(isset($_SESSION['error'])) echo "<p style='color:red'>".$_SESSION['error']."</p>"; unset($_SESSION['error']); ?>

        <form method="POST">

            <input type="hidden" name="email" value="<?php echo $email; ?>">

            <label>New Password</label>
            <input type="password" name="password" required>

            <label>Confirm Password</label>
            <input type="password" name="confirm_password" required>

            <button type="submit" name="update_pass" class="btn">
                Update Password
            </button>

        </form>

    </div>
</div>

</body>
</html>

<?php exit(); } ?>


<!-- ========================= -->
<!-- FORGOT PASSWORD PAGE -->
<!-- ========================= -->

<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <link rel="stylesheet" href="/lu_studyverse/assets/css/auth.css">
</head>
<body>

<div class="container">

    <div class="right">

        <h2>Forgot Password</h2>

        <?php if(isset($_SESSION['success'])): ?>
            <div style="background:#e6fff0;padding:10px;border-radius:8px;margin-bottom:10px;color:#1b7a3a;">
                <b><?php echo $_SESSION['success']; ?></b>
                <br><br>
                <?php if(isset($_SESSION['email'])): ?>
                    <small>Check inbox: <?php echo $_SESSION['email']; ?></small>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if(!isset($_SESSION['sent'])): ?>

        <form method="POST">

            <label>Email</label>
            <input type="email" name="email" required>

            <button type="submit" name="send_link" class="btn">
                Send Reset Link
            </button>

        </form>

        <?php else: ?>

            <p style="color:gray;text-align:center;">
                If you didn’t receive email, check spam folder or try again later.
            </p>

            <form method="POST">
                <input type="hidden" name="email" value="<?php echo $_SESSION['email']; ?>">
                <button type="submit" name="send_link" class="btn">
                    Resend Link
                </button>
            </form>

        <?php endif; ?>

    </div>

</div>

</body>
</html>

<?php
unset($_SESSION['success']);
?>