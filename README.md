# secure-login-otp-system
🔐 A secure PHP-based login system with OTP email verification, brute-force protection, and session-based 2FA. Designed with a cyber-themed UI for real-world authentication use. 

# 🔐 Cyber Secure OTP Login System

A full-stack secure login system built with **HTML, CSS, PHP, MySQL**, and **PHPMailer**, featuring:
- Encrypted password storage
- OTP-based email verification
- Rate-limited brute force protection
- Cyber-themed UI for real-world cybersecurity demonstration

---

## 🚀 Features

- ✅ Secure Login & Signup
- 🔐 Password Hashing (`bcrypt`)
- 📩 Email-based OTP (One Time Password)
- ⏳ Countdown-based OTP validation (2 minutes)
- 🔁 Resend OTP feature (with rate limit)
- 🔐 Brute Force Attack Protection (IP-based logging)
- 📊 Recent Login Log Display
- 🚪 Secure Logout
- 💻 Fully styled cyber-dark UI

---

## 📸 Screenshots

> Login
   <img width="1360" height="679" alt="image" src="https://github.com/user-attachments/assets/79ec5cb4-4906-49dc-a726-da3f507eafcd" />

> Signup
   <img width="1361" height="643" alt="image" src="https://github.com/user-attachments/assets/ffe80029-7ac8-4264-b4eb-fa5336068947" />

> OTP Input
   <img width="1366" height="646" alt="image" src="https://github.com/user-attachments/assets/45ea530e-1de7-4a8f-9376-308005bc324b" />

   <img width="1366" height="633" alt="image" src="https://github.com/user-attachments/assets/8e46539f-376a-4dcf-8f36-fa0c1a7efc0c" />

> Dashboard
   <img width="1337" height="640" alt="image" src="https://github.com/user-attachments/assets/d07b932a-2255-40af-9467-a7fd2b385929" />

>  Resend OTP
   After 120 sec OTP becomes invalid , Therefore New OTP should be generated so, click on resend OTP and enter the new OTP.
---

## ⚙️ Tech Stack

| Layer       | Tech                         |
|-------------|------------------------------|
| Frontend    | HTML, CSS, JavaScript        |
| Backend     | PHP                          |
| Database    | MySQL                        |
| Mail System | PHPMailer + Gmail SMTP       |

---

## 🏗️ Folder Structure

CyberSecureLoginSystem/
login.html
signup.html
verify.html
login.php
signup.php
verify.php
resend_otp.php
dashboard.php
logout.php
style.css
PHPMailer/
README.md


---

## 🧠 Learning Outcomes

- Real-world implementation of **OTP-based 2FA**
- **Password security** with `password_hash()` and `verify()`
- Handling **user sessions**, rate limits, and IP logs
- Creating **user-friendly error/success flows**
- Integrating PHPMailer for email security workflows

---

## 🧪 Setup Instructions (Localhost using XAMPP)

1. 📁 Clone this repository  
   ```bash
   git clone https://github.com/srohith99/CyberSecureLoginSystem.git

  -> use XAMPP and place at C:\xampp\htdocs\CyberSecureLoginSystem
  
2.🔌 Start XAMPP (Apache + MySQL)

3.🗃️ Create MySQL Database:

  DB Name: secure_project

  Create tables:
  CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100),
  email VARCHAR(255),
  password VARCHAR(255)
);

CREATE TABLE login_logs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100),
  ip_address VARCHAR(45),
  status VARCHAR(50),
  time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

4.✉️ Setup PHPMailer/ inside root folder
    📦 1. Install PHPMailer (Once Only)
            Download from:
              👉 [link](https://github.com/PHPMailer/PHPMailer);
        2. Extract zip and place the PHPMailer folder inside your CyberSecureLoginSystem directory.

5.🔐 Use your Gmail + App Password in all mail files:

   -> use App Passwords (if 2FA enabled): [](https://myaccount.google.com/apppasswords);
   -> Create App and name it as PHPMailer 
   -> Copy the generated password , paste into code @login.php

  find @ login.php
  $mail->Username = 'your-email@gmail.com';
  $mail->Password = 'your-app-password'; // NOT Gmail login its password geneated during app creation.
  
6.✅ Visit http://localhost/CyberSecureLoginSystem/login.html

7.Start Working on it..


🔐 For Further Security Enhancements We Can Add,
  -Google Authenticator (TOTP)

  -Device fingerprinting

  -reCAPTCHA v3

  -Login notification emails

  -Multi-device OTP logs


