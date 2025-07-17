<?php
$conn = new mysqli("localhost", "root", "", "secure_project");

echo '<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Signup Status</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="login-box">
    <img src="https://cdn-icons-png.flaticon.com/512/2920/2920347.png" class="logo" />
    <h2 class="typing">Signup Status</h2>';

if ($conn->connect_error) {
    echo "<p style='color:red;'>❌ Database connection failed!</p>";
    echo "</div></body></html>";
    exit();
}

$username = $_POST['username'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);

// Check for duplicate username
$check = $conn->query("SELECT * FROM users WHERE username='$username'");
if ($check->num_rows > 0) {
    echo "<p style='color:red;'>⚠️ Username already exists! Try a new one.</p>";
} else {
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);

    if ($stmt->execute()) {
        echo "<p style='color:#00FFD1;'>✅ Signup successful!</p>";
        echo "<a href='login.html'>🔐 Click here to login</a>";
    } else {
        echo "<p style='color:red;'>❌ Signup failed. Please try again.</p>";
    }

    $stmt->close();
}

$conn->close();
echo '</div></body></html>';
?>
