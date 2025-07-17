<?php
session_start();
$enteredOTP = $_POST['otp_digit_1'] . $_POST['otp_digit_2'] . $_POST['otp_digit_3'] . $_POST['otp_digit_4'];

echo '<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>OTP Verification</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="login-box">
    <img src="https://cdn-icons-png.flaticon.com/512/2920/2920347.png" class="logo" />
    <h2 class="typing">OTP Check</h2>';

if ($enteredOTP == $_SESSION['otp']) {
    echo "<p style='color:lime;'>✅ OTP Verified! Welcome, <b>" . $_SESSION['username'] . "</b></p>";
    echo "<a href='dashboard.php'>📊 Go to Dashboard</a>";
} else {
    echo "<p style='color:red;'>❌ Invalid OTP. Try again.</p>";
    echo "<a href='verify.html'>🔁 Retry OTP</a>";
}

echo '</div></body></html>';
?>
