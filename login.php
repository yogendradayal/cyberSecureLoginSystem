<?php
session_start();
$conn = new mysqli("localhost", "root", "", "secure_project");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Start HTML Output
echo '<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login Status</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="login-box">
    <img src="https://cdn-icons-png.flaticon.com/512/2920/2920347.png" class="logo" />
    <h2 class="typing">Login Response</h2>';

$uname = $_POST['username'];
$pass = $_POST['password'];
$ip = $_SERVER['REMOTE_ADDR'];

// 🚨 Brute force check
$check = $conn->query("SELECT COUNT(*) as fail FROM login_logs WHERE ip_address='$ip' AND status='Failed' AND time > NOW() - INTERVAL 5 MINUTE");
$data = $check->fetch_assoc();
if ($data['fail'] >= 3) {
    echo "<p style='color:red;'>⛔ Too many failed attempts. Try again after 5 minutes.</p>";
    echo "</div></body></html>";
    exit();
}

// ✅ Validate user
$res = $conn->query("SELECT * FROM users WHERE username='$uname'");
if ($res->num_rows > 0) {
    $row = $res->fetch_assoc();
    if (password_verify($pass, $row['password'])) {

        // Generate OTP
        $otp = rand(1000, 9999);
        $_SESSION['otp'] = $otp;
        $_SESSION['username'] = $uname;

        // Send OTP via Email
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'Your Gmail address'; // Your Gmail App pasword enabled
            $mail->Password   = 'Your App Password';        // App Password Got after creating of app
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->setFrom('Replace With your Gmail Address', 'Secure Login System'); //Your Gmail App pasword enabled
            $mail->addAddress($row['email'], $uname);

            $mail->isHTML(true);
            $mail->Subject = 'Your One-Time Password (OTP)';
            $mail->Body    = "<h3>Your OTP is: <b>$otp</b></h3>";

            $mail->send();

            // Log it
            $conn->query("INSERT INTO login_logs (username, ip_address, status) VALUES ('$uname', '$ip', 'OTP Sent')");
            echo "<p style='color:#00FFD1;'>📩 OTP sent to your email</p>";
            echo "<a href='verify.html'>🔐 Click here to verify OTP</a>";

        } catch (Exception $e) {
            echo "<p style='color:red;'>Mailer Error: {$mail->ErrorInfo}</p>";
        }

    } else {
        $conn->query("INSERT INTO login_logs (username, ip_address, status) VALUES ('$uname', '$ip', 'Failed')");
        echo "<p style='color:red;'>❌ Wrong password</p>";
    }
} else {
    $conn->query("INSERT INTO login_logs (username, ip_address, status) VALUES ('$uname', '$ip', 'Failed')");
    echo "<p style='color:red;'>❌ User not found</p>";
}

echo '</div></body></html>';
?>
