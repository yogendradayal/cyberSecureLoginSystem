<?php
session_start();
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$conn = new mysqli("localhost", "root", "", "secure_project");

if (!isset($_SESSION['username'])) {
    echo "⚠️ Session expired. Please <a href='login.html'>login again</a>";
    exit();
}

$username = $_SESSION['username'];

// 🔐 Step 1: Check rate limit (60 sec cooldown)
if (isset($_SESSION['last_otp_time']) && (time() - $_SESSION['last_otp_time'] < 60)) {
    $remaining = 60 - (time() - $_SESSION['last_otp_time']);
    echo "<p style='color:red;'>⏱️ Please wait <b>$remaining seconds</b> before requesting OTP again.</p>";
    echo "<a href='verify.html'>🔙 Go Back</a>";
    exit();
}

// 🕒 Step 2: Update rate limit timestamp
$_SESSION['last_otp_time'] = time();

// 🔎 Step 3: Get email from database
$result = $conn->query("SELECT email FROM users WHERE username='$username'");
if ($result->num_rows === 0) {
    echo "⚠️ User not found.";
    exit();
}
$row = $result->fetch_assoc();
$email = $row['email'];

// 🔐 Step 4: Generate and store new OTP
$otp = rand(1000, 9999);
$_SESSION['otp'] = $otp;

// 📩 Step 5: Send the OTP
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'securelogin9999@gmail.com';
    $mail->Password = 'njjd cdww mfko ytzb'; // App password
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('securelogin9999@gmail.com', 'Secure Login System');
    $mail->addAddress($email, $username);

    $mail->isHTML(true);
    $mail->Subject = '🔁 Your New OTP';
    $mail->Body    = "<h3>Your new OTP is: <b>$otp</b></h3><p>This OTP is valid for 2 minutes.</p>";

    $mail->send();

    // ✅ Log OTP resend
    $ip = $_SERVER['REMOTE_ADDR'];
    $conn->query("INSERT INTO login_logs (username, ip_address, status) VALUES ('$username', '$ip', 'OTP Resent')");

    // 🔄 Redirect back to verify screen
    header("Location: verify.html");
    exit();

} catch (Exception $e) {
    echo "<p style='color:red;'>❌ Could not resend OTP. Mailer Error: {$mail->ErrorInfo}</p>";
}
?>
