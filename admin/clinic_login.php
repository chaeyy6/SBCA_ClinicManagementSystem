<?php
// Include the database connection file
include('db_connect.php');
session_start();

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if username and password are not empty
    if (empty($username) || empty($password)) {
        $error_message = "Username and Password are required!";
    } else {
        // Check the number of failed login attempts
        $stmt = $conn->prepare("SELECT * FROM staff_users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Check if account is locked due to too many failed attempts
            if (isset($user['failed_attempts']) && $user['failed_attempts'] >= 3) {
                // Check if the account is still locked
                $lock_time = strtotime($user['last_failed_attempt']);
                $current_time = time();
                $time_diff = $current_time - $lock_time;

                if ($time_diff < 900) { // Lock duration = 15 minutes (900 seconds)
                    $error_message = "Your account is locked. Please try again after 15 minutes.";
                } else {
                    // Reset failed attempts after lock time
                    $stmt = $conn->prepare("UPDATE staff_users SET failed_attempts = 0 WHERE username = :username");
                    $stmt->bindParam(':username', $username);
                    $stmt->execute();
                }
            }

            // Check password
            if (password_verify($password, $user['password'])) {
                // Password is correct, reset failed attempts
                $stmt = $conn->prepare("UPDATE staff_users SET failed_attempts = 0 WHERE username = :username");
                $stmt->bindParam(':username', $username);
                $stmt->execute();

                // Start session and store user info
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['full_name'] = $user['full_name'];

                // Redirect to dashboard or home page
                header("Location: clinic_dashboard.php");
                exit();
            } else {
                // Incorrect password, increment failed attempts
                $stmt = $conn->prepare("UPDATE staff_users SET failed_attempts = failed_attempts + 1, last_failed_attempt = NOW() WHERE username = :username");
                $stmt->bindParam(':username', $username);
                $stmt->execute();

                // Error message
                $error_message = "Incorrect username or password!";
            }
        } else {
            $error_message = "User not found!";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SBCA Clinic Login</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Old+English+Text+MT&display=swap');
        
        body {
            background: url('clinic_bg.jpg') no-repeat center center/cover;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            font-family: Arial, sans-serif;
            color: #fff;
            position: relative;
            margin: 0;
        }
        .sbca-header {
            position: absolute;
            top: 20px;
            left: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .sbca-header img {
            width: 60px;
            height: 60px;
        }
        .sbca-header h2 {
            color: white;
            font-size: 24px;
            margin: 0;
            font-family: 'Old English Text MT', serif;
        }
        .title {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            font-size: 34px;
            color: white;
            font-weight: bold;
            margin-bottom: 25px;
            text-align: center;
        }
        .title img {
            width: 50px;
            height: 50px;
        }
        .message {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            color: white;
            margin-bottom: 25px;
            max-width: 600px;
        }
        .container {
            background: rgba(255, 255, 255, 0.95);
            padding: 40px 30px;
            border-radius: 12px;
            text-align: center;
            width: 420px;
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.2);
        }
        .input-box {
            display: flex;
            align-items: center;
            background: white;
            padding: 15px;
            border-radius: 8px;
            margin: 18px 0;
            border: 1px solid #ccc;
        }
        .input-box img {
            width: 24px;
            height: 24px;
            margin-right: 12px;
        }
        input {
            width: 100%;
            border: none;
            font-size: 18px;
            outline: none;
        }
        .buttons button {
            width: 100%;
            padding: 14px;
            margin: 10px 0;
            border: 1px solid white;
            border-radius: 6px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }
        .forgot {
            background: #800000;
            color: white;
        }
        .ok, .exit {
            background: #B22222;
            color: white;
        }
        .buttons button:hover {
            opacity: 0.85;
        }
        .footer {
            position: absolute;
            bottom: 12px;
            font-size: 16px;
            color: white;
            text-align: center;
        }
    </style>    
</head>
<body>
    <div class="sbca-header">
        <img src="sbca_logo.png" alt="SBCA Logo">
        <h2>San Beda College Alabang</h2>
    </div>
    <div class="title">
        <img src="hospital_icon.png" alt="Hospital Icon">
        <span>SBCA Clinic Management System</span>
    </div>
    <div class="message">
        <p>"We take care of our students with compassion and excellence."</p>
    </div>
    <div class="container">
        <!-- Display error message if login fails -->
        <?php if (isset($error_message)): ?>
            <div style="color: red; font-weight: bold;"><?= $error_message; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="input-box">
                <img src="username_icon.png" alt="Username Icon">
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <div class="input-box">
                <img src="password_icon.png" alt="Password Icon">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <div class="buttons">
                <button type="submit" class="ok">OK</button>
                <button type="button" class="exit" onclick="window.location.href='index.php';">EXIT</button>
            </div>
        </form>
    </div>
    <div class="footer">
        <p>&copy; 2025 SBCA Clinic Management System | Contact IT Support for Assistance</p>
    </div>
</body>
</html>
