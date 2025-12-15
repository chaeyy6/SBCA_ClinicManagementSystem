<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: clinic_login.php");
    exit();
}

$name = $_SESSION['full_name'] ?? 'Staff';

// Include database connection
include 'db_connect.php'; // Ensure this file contains the connection and assigns $conn
?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vaccinations</title>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Old+English+Text+MT&display=swap');

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

 /* Style for Back to Dashboard button */
 .back-to-dashboard-button {
    position: absolute;
    top: 20px;
    right: 220px; /* Adjusted to create space between Logout and Back to Dashboard buttons */
    background: linear-gradient(to right, #2196F3, #0D47A1); /* Blue gradient */
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

/* Hover effect for Back to Dashboard button */
.back-to-dashboard-button:hover {
    background: linear-gradient(to right, #0D47A1, #2196F3);
    opacity: 0.9;
    transform: scale(1.05);
    }

/* Focus effect for Back to Dashboard button */
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


h1 {
    font-size: 32px;
    margin-bottom: 10px;
}

form {
    background-color: rgba(0, 0, 0, 0.6);
    padding: 25px;
    border-radius: 10px;
    width: 95%;
    max-width: 1100px;
    margin-bottom: 30px;
}

/* Style for the new immunizations section */
fieldset {
    border: 1px solid #fff;
    margin-bottom: 20px;
    padding: 20px;
    border-radius: 8px;
}


/* Add some space between immunizations and remarks */
fieldset.remarks-fieldset {
    margin-top: 30px;
}



legend {
    font-weight: bold;
    font-size: 17px;
    padding: 0 10px;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 16px;
}

.form-item {
    display: flex;
    flex-direction: column;
}

.form-item label {
    margin-bottom: 4px;
    font-size: 15px;
}

.form-item input,
.form-item select {
    padding: 8px;
    border-radius: 5px;
    border: none;
    font-size: 15px;
}

.form-item textarea {
    padding: 8px;
    font-size: 15px;
    border-radius: 5px;
    border: none;
    width: 100%;
    min-height: 100px;
}


/* Style for the dropdown grid */
.dropdown-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 16px;
    margin-top: 30px;
    border: 2px solid #fff;
    padding: 16px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3); /* Subtle shadow for depth */
}



.dropdown-item {
    display: flex;
    flex-direction: column;
}

.dropdown-item label {
    margin-bottom: 4px;
    font-size: 15px;
}

.dropdown-item select {
    padding: 8px;
    font-size: 15px;
    border-radius: 5px;
    border: none;
}

.footer {
    position: absolute;
    bottom: 10px;
    text-align: center;
    font-size: 14px;
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


.top-gap {
    margin-top: 20px; /* Adjust as needed */
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

.pagination-btn {
    background-color: #B22222; /* Red background */
    color: white; /* White text */
    border-radius: 5px; /* Rounded corners */
    text-decoration: none; /* Remove underline */
    font-weight: bold;
    font-size: 16px; /* Adjust font size */
    margin: 0 10px; /* Add margin for spacing between buttons */
    transition: background-color 0.3s, transform 0.2s; /* Smooth transition */
}

/* Hover effect for pagination buttons */
.pagination-btn:hover {
    background-color: #8B0000; /* Darker red on hover */
    opacity: 0.9;
    transform: scale(1.05); /* Slightly enlarge the button */
}

/* Focus state */
.pagination-btn:focus {
    outline: none;
    border: 2px solid white; /* White border on focus */
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

<!-- Back to Dashboard Button -->
<button class="back-to-dashboard-button" onclick="window.location.href='clinic_dashboard.php'">Back to Dashboard</button>

<button class="logout-button" onclick="confirmLogout()">Logout</button>

<h1>Vaccinations</h1>

<!-- Vaccination Form -->
<form id="vaccination-form" action="vaccinations_process.php" method="POST">
    <!-- Hidden ID Field for Update -->
    <input type="hidden" id="record_id" name="id">

    <fieldset>
        <legend>Vaccination Record</legend>
        <div class="form-grid">
            <div class="form-item">
                <label for="student_name">Student Name:</label>
                <input type="text" id="student_name" name="student_name" required>
            </div>

            <div class="form-item">
                <label for="vaccine_name">Vaccine Name:</label>
                <input type="text" id="vaccine_name" name="vaccine_name" required>
            </div>

            <div class="form-item">
                <label for="date1">Date 1:</label>
                <input type="date" id="date1" name="date1">
            </div>

            <div class="form-item">
                <label for="date2">Date 2:</label>
                <input type="date" id="date2" name="date2">
            </div>

            <div class="form-item">
                <label for="date3">Date 3:</label>
                <input type="date" id="date3" name="date3">
            </div>

            <div class="form-item">
                <label for="date4">Date 4:</label>
                <input type="date" id="date4" name="date4">
            </div>
        </div>

        <div class="form-grid top-gap">
            <div class="form-item">
                <label for="findings">Findings:</label>
                <textarea id="findings" name="findings" placeholder="E.g. Reactions, effectiveness, notes..."></textarea>
            </div>

            <div class="form-item">
                <label for="treatment">Treatment:</label>
                <textarea id="treatment" name="treatment" placeholder="E.g. Antipyretics given, advice, etc."></textarea>
            </div>
        </div>
    </fieldset>

    <div class="crud-buttons">
        <!-- Clear record_id for creating a new record -->
        <button type="submit" class="crud-btn" name="create" id="create-btn" onclick="clearRecordId()">Create</button>

        <!-- Update Button with custom submit trigger -->
        <button type="button" class="crud-btn" id="update-btn" onclick="submitUpdateForm()">Update</button>

        <button type="reset" class="crud-btn" onclick="resetForm()">Clear</button>
    </div>
</form>


<?php
// Number of records per page
$recordsPerPage = 4;

// Get the current page, default is page 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $recordsPerPage;

// Check if a search term is provided via GET request
$search = isset($_GET['search']) ? $_GET['search'] : '';  // Use $_GET for the search term

// Base query for fetching vaccination records
$query = "SELECT * FROM vaccinations";

// Modify query to include a WHERE clause if the search term is provided
if (!empty($search)) {
    $query .= " WHERE student_name LIKE :search OR vaccine_name LIKE :search";
}

// Add ordering and limit with offset
$query .= " ORDER BY id DESC LIMIT :limit OFFSET :offset";

// Prepare the statement
$stmt = $conn->prepare($query);

// Bind parameters for search query and pagination
if (!empty($search)) {
    $searchTerm = "%" . $search . "%";
    $stmt->bindParam(':search', $searchTerm, PDO::PARAM_STR);  // Bind search term
}
$stmt->bindParam(':limit', $recordsPerPage, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);

// Execute the statement
$stmt->execute();

// Fetch all results
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get total number of records (for pagination calculation)
$totalQuery = "SELECT COUNT(*) FROM vaccinations";
if (!empty($search)) {
    $totalQuery .= " WHERE student_name LIKE :search OR vaccine_name LIKE :search";
}
$totalStmt = $conn->prepare($totalQuery);
if (!empty($search)) {
    $totalStmt->bindParam(':search', $searchTerm, PDO::PARAM_STR);
}
$totalStmt->execute();
$totalRecords = $totalStmt->fetchColumn();
$totalPages = ceil($totalRecords / $recordsPerPage);
?>

<!-- Search Form with Styling -->
<form method="GET" style="margin-bottom: 20px; text-align: center;">
    <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" 
           placeholder="Search by name or vaccine..." 
           style="padding: 10px; font-size: 16px; width: 300px; border-radius: 5px; border: none;">
    <button type="submit" class="crud-btn">Search</button>
</form>

<?php
// Display the records if they exist
if ($result && count($result) > 0) {
    echo "<h2>Existing Vaccination Records</h2>";
    echo "<div class='table-container'>";
    echo "<table class='records-table'>";
    echo "<thead><tr>";

    // Table headers for a concise view
    $headers = ['Student Name', 'Vaccine Name', 'Date 1', 'Date 2', 'Date 3', 'Date 4', 'Findings', 'Treatment', 'Actions'];
    foreach ($headers as $header) {
        echo "<th>" . htmlspecialchars($header) . "</th>";
    }

    echo "</tr></thead><tbody>";

    // Table rows
    foreach ($result as $row) {
        $id = $row['id']; // Get the ID of the record for linking
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['student_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['vaccine_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['date1']) . "</td>";
        echo "<td>" . htmlspecialchars($row['date2']) . "</td>";
        echo "<td>" . htmlspecialchars($row['date3']) . "</td>";
        echo "<td>" . htmlspecialchars($row['date4']) . "</td>";
        echo "<td>" . htmlspecialchars($row['findings']) . "</td>";
        echo "<td>" . htmlspecialchars($row['treatment']) . "</td>";

        // Action buttons
        echo "<td>
            <button class='view-btn' onclick='viewRecord(" . htmlspecialchars(json_encode($row)) . ")'>View</button>
            <button class='delete-btn' onclick='deleteRecord($id)'>Delete</button>
        </td>";

        echo "</tr>";
    }

    echo "</tbody></table></div>";

    // Pagination controls
    echo "<div style='text-align: center; margin-top: 20px;'>";
    if ($page > 1) {
        echo "<a href='?page=" . ($page - 1) . "&search=" . htmlspecialchars($search) . "' class='crud-btn pagination-btn' style='padding: 10px 20px; background-color:rgb(243, 75, 33);'>Previous</a>";
    }
    if ($page < $totalPages) {
        echo "<a href='?page=" . ($page + 1) . "&search=" . htmlspecialchars($search) . "' class='crud-btn pagination-btn' style='padding: 10px 20px; background-color:rgb(245, 38, 38);'>Next</a>";
    }
    echo "</div>";
} else {
    echo "<p>No vaccination records found.</p>";
}

// Close the prepared statement
$stmt = null;
$totalStmt = null;
?>


<script>
// Clear the hidden record ID when creating a new record
function clearRecordId() {
    document.getElementById('record_id').value = "";  
}

// Reset the form to prepare for new record creation
function resetForm() {
    document.getElementById('record_id').value = "";  // Clear ID for new record creation
    document.getElementById('vaccination-form').action = "vaccinations_process.php";  // Set form action to create
}

// View a record and populate the form for creating a new record based on it
function viewRecord(record) {
    // Populate the form with the record's data
    document.getElementById('record_id').value = record.id;  // Set the record ID for update
    document.getElementById('student_name').value = record.student_name;
    document.getElementById('vaccine_name').value = record.vaccine_name;
    document.getElementById('date1').value = record.date1;
    document.getElementById('date2').value = record.date2;
    document.getElementById('date3').value = record.date3;
    document.getElementById('date4').value = record.date4;
    document.getElementById('findings').value = record.findings;
    document.getElementById('treatment').value = record.treatment;

    // Change the form action to "vaccinations_update.php" for update
    document.getElementById('vaccination-form').action = "vaccinations_update.php";  // Action for updating a record
}

// Handle the form submission for updating
function submitUpdateForm() {
    // Ensure the form action is set for update
    document.getElementById('vaccination-form').action = "vaccinations_update.php";
    
    // Submit the form
    document.getElementById('vaccination-form').submit();
}

function deleteRecord(id) {
    if (confirm("Are you sure you want to delete this record?")) {
        window.location.href = "delete_vaccine.php?id=" + id;
    }
}
</script>



</body>
</html>
