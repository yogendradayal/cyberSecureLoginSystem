<?php
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: login.html");
  exit();
}

$conn = new mysqli("localhost", "root", "", "secure_project");
$username = $_SESSION['username'];
$ip = $_SERVER['REMOTE_ADDR'];

echo '<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  <link rel="stylesheet" href="style.css">
  <style>
    table {
      width: 100%;
      margin-top: 20px;
      border-collapse: collapse;
      font-size: 14px;
      color: #00ffd1;
    }
    th, td {
      border: 1px solid #00ffd1;
      padding: 8px;
      text-align: center;
    }
    th {
      background-color: #0f0f0f;
    }
    .logout-btn {
      background-color: #ff0044;
      color: white;
      padding: 8px 20px;
      border: none;
      border-radius: 6px;
      margin-top: 15px;
      cursor: pointer;
    }
    .logout-btn:hover {
      background-color: #cc0033;
      box-shadow: 0 0 10px #ff0044;
    }
  </style>
</head>
<body>
  <div class="login-box" style="max-width: 800px;">
    <img src="https://cdn-icons-png.flaticon.com/512/2920/2920347.png" class="logo" />
    <h2 class="typing">Welcome, ' . $username . '</h2>
    <p>🛡️ You are logged in from IP: <b>' . $ip . '</b></p>
    <p>✅ OTP session active</p>
    <form action="logout.php" method="post">
      <button class="logout-btn" type="submit">Logout</button>
    </form>';

    // Show recent login attempts
    $result = $conn->query("SELECT * FROM login_logs WHERE username='$username' ORDER BY time DESC LIMIT 5");
    if ($result->num_rows > 0) {
      echo '<h3 style="margin-top:30px;">📜 Recent Login Attempts</h3>';
      echo '<table><tr><th>IP Address</th><th>Status</th><th>Time</th></tr>';
      while ($row = $result->fetch_assoc()) {
        echo '<tr><td>' . $row['ip_address'] . '</td><td>' . $row['status'] . '</td><td>' . $row['time'] . '</td></tr>';
      }
      echo '</table>';
    } else {
      echo '<p>No login logs found.</p>';
    }

echo '</div></body></html>';
?>
