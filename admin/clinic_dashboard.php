<?php
session_start();

// Block access if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: clinic_login.php");
    exit();
}

$name = $_SESSION['full_name'] ?? 'Staff';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SBCA Clinic Dashboard</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Old+English+Text+MT&display=swap');
        
        body {
            background: url('clinic_bg.jpg') no-repeat center center/cover;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            min-height: 100vh;
            font-family: Arial, sans-serif;
            color: #fff;
            margin: 0;
            padding-top: 100px;
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
            font-size: 26px;
            margin: 0;
            font-family: 'Old English Text MT', serif;
        }
        .logout-button {
            position: absolute;
            top: 20px;
            right: 20px;
            background: linear-gradient(to right, #B22222, #8B0000);
            color: white;
            border: 1px solid white;
            padding: 15px 30px; /* Increased padding for a larger button */
            border-radius: 8px; /* Slightly more rounded corners */
            cursor: pointer;
            font-size: 18px; /* Increased font size for better readability */
            font-weight: bold; /* Makes the text bold for better visibility */
            transition: 0.3s;
            min-width: 180px; /* Ensures the button is wide enough */
            text-align: center;
        }

        /* Hover effect */
        .logout-button:hover {
            background: linear-gradient(to right, #8B0000, #B22222); /* Inverts gradient on hover for visual feedback */
            opacity: 0.9;
            transform: scale(1.05); /* Slightly enlarges the button on hover */
        }

        /* Focus effect */
        .logout-button:focus {
            outline: none;
            border: 2px solid #fff; /* White border on focus */
        }
        .main-label {
            font-size: 50px;
            font-weight: bold;
            color: white;
            text-align: center;
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .main-label img {
            width: 60px;
            height: 60px;
            margin-right: 15px;
        }
        .greeting {
            font-size: 24px;
            margin-bottom: 10px;
            text-align: center;
        }
        .sub-label {
            font-size: 20px;
            font-weight: 300;
            color: white;
            margin-bottom: 40px;
            text-align: center;
        }
        .dashboard-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 40px;
            animation: fadeIn 1.5s ease-in-out;
        }
        .dashboard-box {
            background: #8B0000;
            padding: 30px;
            border-radius: 14px;
            text-align: center;
            width: 300px;
            height: 280px;
            box-shadow: 0px 6px 20px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: transform 0.3s ease, background 0.3s;
        }
        .dashboard-box:hover {
            background: #B22222;
            transform: scale(1.05);
        }
        .dashboard-box img {
            width: 100px;
            height: 100px;
            margin-bottom: 20px;
            transition: filter 0.3s ease;
        }
        .dashboard-box:hover img {
            filter: brightness(1.3);
        }
        .dashboard-box span {
            font-size: 24px;
            font-weight: bold;
        }
        .footer {
            position: absolute;
            bottom: 12px;
            font-size: 16px;
            color: white;
            text-align: center;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
    <script>
        function confirmLogout() {
            if (confirm("Are you sure you want to logout?")) {
                window.location.href = 'clinic_login.php';
            }
        }
    </script>
</head>
<body>

    <div class="sbca-header">
        <img src="sbca_logo.png" alt="SBCA Logo">
        <h2>San Beda College Alabang</h2>
    </div>

    <button class="logout-button" onclick="confirmLogout()">Logout</button>

    <div class="main-label">
        <img src="healing_icon.png" alt="Healing Icon">
        SBCA Clinic Management Center
    </div>
    <div class="greeting">
        Welcome, <?php echo htmlspecialchars($name); ?>!
    </div>
    <div class="sub-label">
        We take good care of our students
    </div>

    <div class="dashboard-container">
        <div class="dashboard-box" onclick="window.location.href='health_records.php'">
            <img src="records.png" alt="Health Records">
            <span>Student Health Records</span>
        </div>
        <div class="dashboard-box" onclick="window.location.href='vaccinations.php'">
            <img src="vaccinations.png" alt="Vaccinations">
            <span>Vaccinations</span>
        </div>
        <div class="dashboard-box" onclick="window.location.href='dental_records.php'">
            <img src="dental.png" alt="Dental Records">
            <span>Dental Records</span>
        </div>
    </div>

    <div class="footer">
        <p>&copy; 2025 SBCA Clinic Management System | For assistance, please contact IT Support.</p>
    </div>

</body>
</html>
