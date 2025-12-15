<?php
session_start();
$name = $_SESSION['full_name'] ?? 'Staff';

// Replace with your Hostinger credentials
$host = "localhost";
$user = "u659680966_2022300091";  // your actual DB username on Hostinger
$pass = "Sonchaeyoung6";          // your actual DB password
$db = "u659680966_SBCA_CMS";      // your actual DB name on Hostinger

$conn = new mysqli($host, $user, $pass, $db);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to select data from dental_records table (ensure this table exists)
$sql = "SELECT * FROM dental_records"; // change table name if needed
$dentalResult = $conn->query($sql);
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dental Records</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Old+English+Text+MT&display=swap');

        body {
            background: url('clinic_bg.jpg') no-repeat center center/cover;
            font-family: Arial, sans-serif;
            color: #fff;
            margin: 0;
            padding-top: 120px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
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
            font-family: 'Old English Text MT', serif;
            font-size: 26px;
            margin: 0;
        }

        .back-to-dashboard-button {
            position: absolute;
            top: 20px;
            right: 220px;
            background: linear-gradient(to right, #2196F3, #0D47A1);
            color: white;
            border: 1px solid white;
            padding: 15px 30px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
            transition: 0.3s;
            min-width: 180px;
            text-align: center;
        }

        .back-to-dashboard-button:hover {
            background: linear-gradient(to right, #0D47A1, #2196F3);
            opacity: 0.9;
            transform: scale(1.05);
        }

        .back-to-dashboard-button:focus {
            outline: none;
            border: 2px solid #fff;
        }

        .logout-button {
            position: absolute;
            top: 20px;
            right: 20px;
            background: linear-gradient(to right, #B22222, #8B0000);
            color: white;
            border: 1px solid white;
            padding: 15px 30px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
            transition: 0.3s;
            min-width: 180px;
            text-align: center;
        }

        .logout-button:hover {
            background: linear-gradient(to right, #8B0000, #B22222);
            opacity: 0.9;
            transform: scale(1.05);
        }

        .logout-button:focus {
            outline: none;
            border: 2px solid #fff;
        }

        h1 {
            font-size: 32px;
            margin-bottom: 20px;
        }

        form {
            background-color: rgba(0, 0, 0, 0.6);
            padding: 25px;
            border-radius: 10px;
            width: 95%;
            max-width: 1100px;
            margin-bottom: 30px;
        }

        .footer {
            position: absolute;
            bottom: 10px;
            text-align: center;
            font-size: 14px;
        }

        /* Placeholder layout elements */
        .placeholder {
            text-align: center;
            font-size: 18px;
            padding: 40px;
            border: 2px dashed #fff;
            border-radius: 10px;
            background-color: rgba(255,255,255,0.1);
        }

        select {
            width: 30px;
            font-size: 14px;
            text-align: center;
            margin: 5px; /* Adds a gap between each dropdown */
        }

        /* Style for CRUD buttons */
        .crud-buttons {
            display: flex;
            justify-content: center;
            gap: 30px; /* Increased gap for better spacing */
            margin-top: 30px; /* Slightly increased top margin */
        }

        .crud-btn {
            background-color: #4CAF50; /* Green for Create */
            color: white;
            padding: 15px 30px; /* Increased padding for bigger buttons */
            border: none;
            border-radius: 8px; /* Slightly more rounded corners */
            cursor: pointer;
            font-size: 18px; /* Increased font size */
            font-weight: bold; /* Make the font bold for better readability */
            transition: background-color 0.3s, transform 0.2s;
            min-width: 150px; /* Ensures buttons are wide enough */
            text-align: center;
        }

        /* Hover effect */
        .crud-btn:hover {
            opacity: 0.9;
            transform: scale(1.05); /* Slightly enlarges the button on hover */
        }

        /* Specific button colors */
        .crud-btn:nth-child(2) { background-color: #FF9800; } /* Orange for Update */
        .crud-btn:nth-child(3) { background-color: #F44336; } /* Red for Delete */
        .crud-btn:nth-child(4) { background-color: #2196F3; } /* Blue for Refresh */

        /* Focus state for better visibility */
        .crud-btn:focus {
            outline: none;
            border: 2px solid #fff; /* White border when focused */
        }

        /* Table container for scrollable effect */
        .table-container {
            max-height: 500px; /* Adjust the height based on your needs */
            overflow-y: auto;  /* Make the table scrollable vertically */
            margin: 20px auto;
            background-color: rgba(255, 255, 255, 0.85); /* Slightly darker, better contrast against red background */
            padding: 20px;
            border-radius: 10px;
            width: 90%;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3); /* Increased shadow for more definition */
        }

        /* Table styling */
        .records-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed; /* Ensures columns have equal width */
        }

        .records-table th, .records-table td {
            padding: 15px;  /* Increase padding to make cells a bit longer */
            border: 1px solid #ddd;
            text-align: left;
            word-wrap: break-word; /* Allows for longer text without overflow */
            color: black;  /* Ensure text in the record cells is black */
        }

        /* Adjust header background color for contrast */
        .records-table th {
            background-color: #d32f2f; /* Red color to match clinic theme */
            color: white; /* White text for contrast */
            text-align: center;
        }

        /* Row styling with alternating background for better readability */
        .records-table tr:nth-child(even) {
            background-color: #f9f9f9; /* Light grey for even rows */
        }

        .records-table tr:nth-child(odd) {
            background-color: #ffffff; /* White for odd rows */
        }

        /* Action button */
        .view-btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 0; /* Remove left and right padding */
            border: none;
            cursor: pointer;
            border-radius: 5px;
            width: 100%; /* Make button take up full width of the cell */
            height: 100%; /* Make button take up full height of the cell */
            text-align: center; /* Center text */
            margin-bottom: 10px;
        }

        .view-btn:hover {
            background-color: #45a049;
        }


        .delete-btn {
            background-color: red;
            color: white;
            padding: 10px 0; /* Remove left and right padding */
            border: none;
            cursor: pointer;
            border-radius: 5px;
            width: 100%; /* Make button take up full width of the cell */
            height: 100%; /* Make button take up full height of the cell */
            text-align: center; /* Center text */
        }
        .delete-btn:hover {
            background-color: #c0392b;
        }


        /* Responsive design */
        @media screen and (max-width: 768px) {
            .records-table th, .records-table td {
                padding: 8px;
                font-size: 12px; /* Smaller font for mobile devices */
            }

            .records-table th {
                font-size: 14px;
            }
        }

        @media screen and (max-width: 480px) {
            .table-container {
                width: 100%; /* Ensure table takes full width on mobile */
            }
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

    <button class="back-to-dashboard-button" onclick="window.location.href='clinic_dashboard.php'">Back to Dashboard</button>
    <button class="logout-button" onclick="confirmLogout()">Logout</button>

    <h1>Dental Records</h1>

    <form method="POST" action="process_dental_records.php">

    <!-- add this inside your <form> somewhere -->
    <input type="hidden" id="record_id" name="record_id" />

    <!-- Personal Info - 1st Row -->
    <div style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 20px; margin-bottom: 20px;">
        <div>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" style="width: 100%; height: 35px; font-size: 16px;">
        </div>
        <div>
            <label for="age">Age:</label>
            <input type="number" id="age" name="age" style="width: 100%; height: 35px; font-size: 16px;">
        </div>
        <div>
            <label for="sex">Sex:</label>
            <select id="sex" name="sex" style="width: 100%; height: 35px; font-size: 16px;">
                <option value="">Select</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
        </div>
        <div>
            <label for="dob">Date of Birth:</label>
            <input type="date" id="dob" name="dob" style="width: 100%; height: 35px; font-size: 16px;">
        </div>
        <div>
            <label for="contact">Contact No.:</label>
            <input type="text" id="contact" name="contact" style="width: 100%; height: 35px; font-size: 16px;">
        </div>
    </div>

    <!-- Emergency Contact - 2nd Row -->
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px;">
        <div>
            <label for="emergency_person">Emergency Contact Person:</label>
            <input type="text" id="emergency_person" name="emergency_person" style="width: 100%; height: 35px; font-size: 16px;">
        </div>
        <div>
            <label for="relationship">Relationship:</label>
            <input type="text" id="relationship" name="relationship" style="width: 100%; height: 35px; font-size: 16px;">
        </div>
        <div>
            <label for="emergency_contact">Contact No.:</label>
            <input type="text" id="emergency_contact" name="emergency_contact" style="width: 100%; height: 35px; font-size: 16px;">
        </div>
    </div>

    <!-- Date and Level & Section Row -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div style="display: flex; align-items: center;">
            <label for="date" style="margin-right: 10px;">Date:</label>
            <input type="datetime-local" id="date" name="date" style="width: 250px; height: 40px; font-size: 16px;">
        </div>
        <div style="display: flex; align-items: center;">
            <label for="level" style="margin-right: 10px;">Level & Section:</label>
            <input type="text" id="level" name="level" style="width: 250px; height: 40px; font-size: 16px;">
        </div>
    </div>

    <!-- Last Dental Visit -->
    <label for="last_visit">Date of Last Dental Visit:</label>
<input type="datetime-local" id="last_visit" name="last_visit" style="margin-left:10px; width: 300px; height: 30px; font-size: 16px;"><br><br>

        <!-- Procedure -->
        <label for="procedures">Procedure/s Done:</label>
        <input type="textarea" id="procedures" name="procedures" style="margin-left:10px; width: 600px; height: 30px; font-size: 16px;"><br><br>

        <!-- Tooth Chart -->
        <div style="text-align:center;">
            <!-- Top Permanent Teeth -->
            <div style="margin-bottom: 15px;">
                <?php
                $top_teeth = [18, 17, 16, 15, 14, 13, 12, 11, 21, 22, 23, 24, 25, 26, 27, 28];
                foreach ($top_teeth as $tooth) {
                    echo "<div style='display: inline-block; text-align: center; margin: 2px;'>
                            <div style='font-size: 12px; margin-bottom: 5px;'>$tooth</div>
                            <select name='tooth_$tooth'>
                                <option value=''>Select</option>
                                <option value='C'>C</option>
                                <option value='/' selected>/</option>
                                <option value='S'>S</option>
                                <option value='CO'>CO</option>
                                <option value='TF'>TF</option>
                                <option value='AM'>AF</option>
                                <option value='X'>X</option>
                                <option value='EX'>EX</option>
                                <option value='UN'>UN</option>
                                <option value='P'>P</option>
                                <option value='FR'>FR</option>
                            </select>
                            <div style='width:30px; height:30px; border:1px solid #ccc; margin-top:2px;'>
                                <img src='images/$tooth.jpg' alt='Tooth $tooth' style='width:100%; height:100%; object-fit:contain;' />
                            </div>
                        </div>";
                }
                ?>
            </div>
        </div>

        <!-- Top Primary Teeth -->
        <div style="margin-bottom: 15px; display: flex; justify-content: center; flex-wrap: wrap;">
            <?php
            $top_primary = [55, 54, 53, 52, 51, 61, 62, 63, 64, 65];
            foreach ($top_primary as $tooth) {
                echo "<div style='text-align: center; margin: 4px;'>
                        <div style='font-size: 12px; margin-bottom: 5px;'>$tooth</div>
                        <select name='tooth_$tooth'>
                            <option value=''>Select</option>
                            <option value='C'>C</option>
                            <option value='/' selected>/</option>
                            <option value='S'>S</option>
                            <option value='CO'>CO</option>
                            <option value='TF'>TF</option>
                            <option value='AM'>AF</option>
                            <option value='X'>X</option>
                            <option value='EX'>EX</option>
                            <option value='UN'>UN</option>
                            <option value='P'>P</option>
                            <option value='FR'>FR</option>
                        </select>
                        <div style='width:30px; height:30px; border:1px solid #ccc; margin-top:2px;'>
                            <img src='images/$tooth.jpg' alt='Tooth $tooth' style='width:100%; height:100%; object-fit:contain;' />
                        </div>
                    </div>";
            }
            ?>
        </div>

        <!-- Bottom Primary Teeth -->
        <div style="margin-bottom: 15px; display: flex; justify-content: center; flex-wrap: wrap;">
            <?php
            $bottom_primary = [85, 84, 83, 82, 81, 71, 72, 73, 74, 75];
            foreach ($bottom_primary as $tooth) {
                echo "<div style='text-align: center; margin: 4px;'>
                        <div style='font-size: 12px; margin-bottom: 5px;'>$tooth</div>
                        <select name='tooth_$tooth'>
                            <option value=''>Select</option>
                            <option value='C'>C</option>
                            <option value='/' selected>/</option>
                            <option value='S'>S</option>
                            <option value='CO'>CO</option>
                            <option value='TF'>TF</option>
                            <option value='AM'>AF</option>
                            <option value='X'>X</option>
                            <option value='EX'>EX</option>
                            <option value='UN'>UN</option>
                            <option value='P'>P</option>
                            <option value='FR'>FR</option>
                        </select>
                        <div style='width:30px; height:30px; border:1px solid #ccc; margin-top:2px;'>
                            <img src='images/$tooth.jpg' alt='Tooth $tooth' style='width:100%; height:100%; object-fit:contain;' />
                        </div>
                    </div>";
            }
            ?>
        </div>

        <!-- Bottom Permanent Teeth -->
        <div style="margin-bottom: 15px; display: flex; justify-content: center; flex-wrap: wrap;">
            <?php
            $bottom_teeth = [48, 47, 46, 45, 44, 43, 42, 41, 31, 32, 33, 34, 35, 36, 37, 38];
            foreach ($bottom_teeth as $tooth) {
                echo "<div style='text-align: center; margin: 4px;'>
                        <div style='font-size: 12px; margin-bottom: 5px;'>$tooth</div>
                        <select name='tooth_$tooth'>
                            <option value=''>Select</option>
                            <option value='C'>C</option>
                            <option value='/' selected>/</option>
                            <option value='S'>S</option>
                            <option value='CO'>CO</option>
                            <option value='TF'>TF</option>
                            <option value='AM'>AF</option>
                            <option value='X'>X</option>
                            <option value='EX'>EX</option>
                            <option value='UN'>UN</option>
                            <option value='P'>P</option>
                            <option value='FR'>FR</option>
                        </select>
                        <div style='width:30px; height:30px; border:1px solid #ccc; margin-top:2px;'>
                            <img src='images/$tooth.jpg' alt='Tooth $tooth' style='width:100%; height:100%; object-fit:contain;' />
                        </div>
                    </div>";
            }
            ?>
        </div>



        <!-- Legend -->
        <div style="font-size: 14px;">
            <strong>Legend:</strong><br>
            C – with Caries | / – without Caries | S – Sealant | CO – Composite Filling |
            TF – Temporary Filling | AM – Amalgam Filling | X – Missing/Extracted |
            EX – for Extraction | UN – Unerupted | P – FPD/Pontic/Veneer | FR – Fractured
        </div><br>

        <!-- Oral Hygiene -->
        <label>Oral Hygiene:</label>
        <label><input type="radio" name="hygiene" value="Poor"> Poor</label>
        <label><input type="radio" name="hygiene" value="Fair"> Fair</label>
        <label><input type="radio" name="hygiene" value="Good"> Good</label><br><br>

        <!-- Ortho -->
        <label>Under Orthodontic Treatment:</label>
        <label><input type="radio" name="ortho" value="Yes"> Yes</label>
        <label><input type="radio" name="ortho" value="No"> No</label><br><br>

        <!-- Recommendations -->
        <fieldset style="padding: 10px; border: 1px solid #ccc;">
            <legend><strong>Recommendations:</strong></legend>
            <label>Oral Prophylaxis:</label>
            <label><input type="radio" name="prophy" value="Light"> Light</label>
            <label><input type="radio" name="prophy" value="Moderate"> Moderate</label>
            <label><input type="radio" name="prophy" value="Heavy"> Heavy</label><br><br>

            <label>Tooth Restoration/s:</label> <input type="checkbox" name="restorations" value="1"><label>(refer to chart above)</label><br><br>
            <label>Tooth Extractions/s:</label> <input type="checkbox" name="extractions" value="1"><label>(refer to chart above)</label><br><br>
        </fieldset><br>

        <!-- Remarks -->
        <label for="remarks">Remarks:</label><br>
        <textarea name="remarks" id="remarks" rows="4" cols="80" style="margin-top: 5px; width: 1100px;"></textarea><br><br>

        <!-- Dentist & Student -->
        <div style="text-align: center; margin-top: 20px;">
            <br>School Dentist</label><br><br>
            <input type="text" id="student_dentist" name="student_dentist" style="width: 300px;">
        </div>

          <!-- CRUD Buttons Section -->
            <div class="crud-buttons" style="text-align: center; margin-top: 30px;">
                <button type="submit" class="crud-btn" style="padding: 10px 20px; font-size: 16px;">Create</button>
                <button type="button" class="crud-btn" onclick="updateRecord()" style="padding: 10px 20px; font-size: 16px;">Update</button>
                <button type="reset" class="crud-btn" onclick="clearForm()" style="padding: 10px 20px; font-size: 16px;">Clear</button>
            </div>
    </form>
    

    <?php if (isset($_GET['msg'])): ?>
    <div class="alert">
        <?php
        switch ($_GET['msg']) {
            case 'deleted':       echo "Record was successfully deleted."; break;
            case 'error_delete':  echo "Failed to delete record.";        break;
            case 'error_no_id':   echo "No record specified.";           break;
        }
        ?>
    </div>
    <?php endif; ?>

    <?php
    // Set up database connection
    $recordsPerPage = 5;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $page = max($page, 1);
    $offset = ($page - 1) * $recordsPerPage;

    // Grab & sanitize search term
    $search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

    // Build WHERE clause for search functionality
    $whereClause = '';
    $searchTerm = "%$search%";
    if (!empty($search)) {
        $whereClause = "WHERE name LIKE ? OR level LIKE ?";
    }

    // Count total records for pagination
    $countQuery = "SELECT COUNT(*) AS cnt FROM dental_records $whereClause";
    $countStmt = $conn->prepare($countQuery);

    // Bind parameters for COUNT query
    if (!empty($search)) {
        // If search term is provided, bind the parameters
        $countStmt->bind_param("ss", $searchTerm, $searchTerm);
    } else {
        // If search term is empty, don't bind parameters
        $countStmt->execute();
    }

    $countStmt->execute();
    $countResult = $countStmt->get_result();
    $totalRow = $countResult->fetch_assoc();
    $totalRecords = $totalRow['cnt'];
    $totalPages = ceil($totalRecords / $recordsPerPage);

    // Fetch data with LIMIT and OFFSET
    $query = "SELECT id, name, date, level FROM dental_records $whereClause ORDER BY id DESC LIMIT ? OFFSET ?";
    $dataStmt = $conn->prepare($query);

    // Bind parameters for the SELECT query
    if (!empty($search)) {
        // If search term is provided, bind the parameters for SELECT query
        $dataStmt->bind_param("ssi", $searchTerm, $searchTerm, $recordsPerPage, $offset);
    } else {
        // If search term is empty, don't bind parameters for SELECT query
        $dataStmt->bind_param("ii", $recordsPerPage, $offset);
    }

    $dataStmt->execute();
    $dataResult = $dataStmt->get_result();
    ?>

    <!-- Search Form -->
    <form method="GET" style="margin-bottom: 20px; text-align: center;">
        <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>"
            placeholder="Search by name or grade..."
            style="padding: 10px; font-size: 16px; width: 300px; border-radius: 5px; border: none;">
        <button type="submit" class="crud-btn">Search</button>
    </form>

    <?php
    if ($dataResult && $dataResult->num_rows > 0) {
        echo "<h2>Existing Dental Records</h2>";
        echo "<div class='table-container'>";
        echo "<table class='records-table'>";
        echo "<thead><tr>";

        $headers = ['ID', 'Name', 'Examination Date', 'Grade', 'Actions'];
        foreach ($headers as $header) {
            echo "<th>" . htmlspecialchars($header) . "</th>";
        }

        echo "</tr></thead><tbody>";

        while ($row = $dataResult->fetch_assoc()) {
            $id = $row['id'];
            echo "<tr>";
            echo "<td>" . htmlspecialchars($id) . "</td>";
            echo "<td>" . htmlspecialchars($row['name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['date']) . "</td>";
            echo "<td>" . htmlspecialchars($row['level']) . "</td>";
            echo "<td>
                <button class='view-btn' onclick='viewDentalRecord($id)'>View</button>
                <button class='delete-btn' onclick='deleteDentalRecord($id)'>Delete</button>
            </td>";
            echo "</tr>";
        }

        echo "</tbody></table></div>";

        // Pagination buttons
        echo "<div style='text-align: center; margin-top: 20px;'>";
        if ($page > 1) {
            echo "<a href='?page=" . ($page - 1) . "&search=" . urlencode($search) . "' class='crud-btn pagination-btn' style='padding: 10px 20px;'>Previous</a>";
        }
        if ($page < $totalPages) {
            echo "<a href='?page=" . ($page + 1) . "&search=" . urlencode($search) . "' class='crud-btn pagination-btn' style='padding: 10px 20px;'>Next</a>";
        }
        echo "</div>";
    } else {
        echo "<p>No dental records found.</p>";
    }
    ?>




<script>

function viewDentalRecord(id) {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "fetch_dental_record.php?id=" + id, true);
    xhr.onload = function () {
        if (xhr.status !== 200) {
            console.error("Failed to fetch record:", xhr.status);
            return;
        }

        const data = JSON.parse(xhr.responseText);
        if (data.error) {
            alert(data.error);
            return;
        }

        // ——— Populate text inputs & selects ———
        document.querySelector('input[name="name"]').value             = data.name            || '';
        document.querySelector('input[name="age"]').value              = data.age             || '';
        document.querySelector('select[name="sex"]').value             = data.sex             || '';
        document.querySelector('input[name="dob"]').value              = data.dob             || '';
        document.querySelector('input[name="contact"]').value          = data.contact         || '';
        document.querySelector('input[name="emergency_person"]').value = data.emergency_person|| '';
        document.querySelector('input[name="relationship"]').value     = data.relationship    || '';
        document.querySelector('input[name="emergency_contact"]').value= data.emergency_contact|| '';
        document.querySelector('input[name="date"]').value             = data.date            || '';
        document.querySelector('input[name="level"]').value            = data.level           || '';
        document.querySelector('input[name="last_visit"]').value       = data.last_visit      || '';
        document.querySelector('input[name="procedures"]').value       = data.procedures      || '';
        document.querySelector('textarea[name="remarks"]').value       = data.remarks         || '';
        document.querySelector('input[name="student_dentist"]').value  = data.student_dentist || '';

        // ——— Checkboxes ———
        document.querySelector('input[name="restorations"]').checked = (data.restorations == 1);
        document.querySelector('input[name="extractions"]').checked  = (data.extractions  == 1);

        // ——— Radio groups ———
        ['hygiene','ortho','prophy'].forEach(group => {
            const val = data[group];
            document.getElementsByName(group).forEach(radio => {
                if (radio.value === val) radio.checked = true;
            });
        });

        // ——— Hidden record ID for your Update call ———
        document.getElementById('record_id').value = data.id || '';

        // ——— Tooth chart: safe parsing ———
        let toothData = {};
        if (data.tooth_chart) {
            if (typeof data.tooth_chart === 'string') {
                try {
                    toothData = JSON.parse(data.tooth_chart);
                } catch (e) {
                    console.error("Error parsing tooth_chart JSON", e);
                }
            } else if (typeof data.tooth_chart === 'object') {
                toothData = data.tooth_chart;
            }
        }

        // ——— Populate each tooth’s <select> ———
        Object.entries(toothData).forEach(([toothId, status]) => {
            const select = document.querySelector(`select[name="tooth_${toothId}"]`);
            if (select) {
                select.value = status;
            } else {
                console.warn(`No select found for tooth_${toothId}`);
            }
        });
    };
    xhr.send();
}


function deleteDentalRecord(id) {
    if (confirm("Are you sure you want to delete this record?")) {
        window.location.href = "delete_dental_record.php?id=" + id;
    }
}

function updateRecord() {
  const recordId = document.getElementById('record_id').value;
  if (!recordId) {
    alert('Please click View on a record before trying to update.');
    return;
  }

  // Make sure we submit to the unified processor
  const form = document.querySelector('form');
  form.action = 'process_dental_records.php';
  form.method = 'POST';

  // Now submit with record_id already populated
  form.submit();
}


</script>


</body>
</html>

