<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: clinic_login.php");
    exit();
}

$name = $_SESSION['full_name'] ?? 'Staff';

// Database connection
$conn = new mysqli("localhost", "u659680966_2022300091", "Sonchaeyoung6", "u659680966_SBCA_CMS");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fields = [
        'name', 'age', 'sex', 'address', 'tel', 'date', 'grade', 'exam_age', 'weight', 'height', 'bp',
        'mental_status', 'skin', 'headhair', 'vision_left', 'vision_right', 'ears', 'nose', 'throat',
        'teeth', 'oral_hygiene', 'neck', 'thyroids', 'chestlungs', 'heart', 'abdomen',
        'allergies', 'lmp_female',
        'measles', 'mumps', 'diptheria', 'whooping_cough', 'smallpox', 'chickenpox', 'typhoid', 'blood_type',
        'remarks', 'examiner'
    ];

    $data = [];
    foreach ($fields as $field) {
        $data[$field] = isset($_POST[$field]) ? $conn->real_escape_string($_POST[$field]) : '';
    }

    $columns = implode(", ", array_keys($data));
    $values = "'" . implode("', '", array_values($data)) . "'";
    $sql = "INSERT INTO student_health_records ($columns) VALUES ($values)";

    if ($conn->query($sql) === TRUE) {
        // Redirect with success message in URL to prevent form resubmission
        header("Location: health_records.php?success=1");
        exit();
    } else {
        header("Location: health_records.php?error=" . urlencode($conn->error));
        exit();
    }
    
}


?>




<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Health Records</title>
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


/* Remove border specifically for the immunizations grid */
.immunizations-section .dropdown-grid {
    border: none;
    margin-top: 0px;
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

a {
    text-decoration: none;
    margin: 0 5px;
    color: #000;
}

a:hover {
    background-color: #f44336;
    color: white;
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

<h1>Student Health Records</h1>

<form action="health_records.php" method="POST">
<input type="hidden" name="record_id" id="record_id">
    <fieldset>
        <legend>A. Student Information</legend>
        <div class="form-grid">
            <div class="form-item">
                <label for="name">Name:</label>
                <input type="text" name="name" required>
            </div>
            <div class="form-item">
                <label for="age">Age:</label>
                <input type="text" name="age" required>
            </div>
            <div class="form-item">
                <label for="sex">Sex:</label>
                <select name="sex" required>
                    <option value="">Select</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>
            <div class="form-item">
                <label for="address">Address:</label>
                <input type="text" name="address">
            </div>
            <div class="form-item">
                <label for="tel">Tel No.:</label>
                <input type="text" name="tel">
            </div>
        </div>
    </fieldset>

    <fieldset>
        <legend>B. Health Details / Medical Examination</legend>
        <div class="form-grid">
            <div class="form-item">
                <label for="date">Date:</label>
                <input type="datetime-local" name="date" required>
            </div>
            <div class="form-item">
                <label for="grade">Grade/Level:</label>
                <input type="text" name="grade">
            </div>
            <div class="form-item">
                <label for="exam_age">Age:</label>
                <input type="text" name="exam_age">
            </div>
            <div class="form-item">
                <label for="weight">Weight (KG):</label>
                <input type="text" name="weight">
            </div>
            <div class="form-item">
                <label for="height">Height (CM):</label>
                <input type="text" name="height">
            </div>
            <div class="form-item">
                <label for="bp">Blood Pressure:</label>
                <input type="text" name="bp">
            </div>
        </div>

        <div class="dropdown-grid">
            <?php
            $fields = [
                'Mental Status', 'Skin', 'Head/Hair', 'Vision Left', 'Vision Right',
                'Ears', 'Nose', 'Throat', 'Teeth', 'Oral Hygiene',
                'Neck', 'Thyroids', 'Chest/Lungs', 'Heart', 'Abdomen',
                'Allergies', 'LMP (female)'
            ];
            foreach ($fields as $field) {
                $id = strtolower(str_replace([' ', '/', '(', ')'], ['_', '', '', ''], $field));
                echo "<div class='dropdown-item'>
                        <label for='$id'>$field:</label>
                        <select name='$id'>
                            <option value=''>Select</option>
                            <option value='O'>O (Normal)</option>
                            <option value='X'>X (Abnormal)</option>
                        </select>
                    </div>";
            }
            ?>
        </div>
    </fieldset>
        <fieldset class="immunizations-section">
            <legend>C. Immunizations</legend>
            <div class="dropdown-grid">
                <?php
                $immunizations = [
                    'Measles', 'Mumps', 'Diptheria', 'Whooping Cough', 'Smallpox',
                    'Chickenpox', 'Typhoid', 'Blood Type'
                ];
                foreach ($immunizations as $immunization) {
                    $id = strtolower(str_replace(' ', '_', $immunization));
                    $options = $immunization == 'Blood Type' ? 
                        "<option value=''>Select</option><option value='A+'>A+</option><option value='A-'>A-</option><option value='B+'>B+</option><option value='B-'>B-</option><option value='O+'>O+</option><option value='O-'>O-</option><option value='AB+'>AB+</option><option value='AB-'>AB-</option>" :
                        "<option value=''>Select</option><option value='Yes'>Yes</option><option value='No'>No</option>";
                    echo "<div class='dropdown-item'>
                            <label for='$id'>$immunization:</label>
                            <select name='$id'>
                                $options
                            </select>
                        </div>";
                }
                ?>
            </div>
        </fieldset>


        <!-- Comments Section -->
        <fieldset class="remarks-fieldset">
            <legend>D. Comments / Remarks</legend>
            <div class="form-grid">
                <div class="form-item">
                    <textarea name="remarks" placeholder="Enter remarks or comments here..."></textarea>
                </div>
            </div>
        </fieldset>

    

    <div class="form-grid" style="margin-top: 20px;">
            <div class="form-item">
                <label for="examiner">Examiner:</label>
                <input type="text" name="examiner" required>
            </div>
        </div>
        

    <!-- CRUD Buttons Section -->
    <div class="crud-buttons">
        <button type="submit" class="crud-btn">Create</button>
        <button type="button" class="crud-btn" onclick="updateRecord()">Update</button>
        <button type="button" class="crud-btn" onclick="clearForm()">Clear</button>
    </div>


</form>

<?php
// Database connection assumed as $conn

$recordsPerPage = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max($page, 1);
$offset = ($page - 1) * $recordsPerPage;

$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

$whereClause = "";
if (!empty($search)) {
    $whereClause = "WHERE name LIKE '%$search%' OR grade LIKE '%$search%'";
}

// Count total records for pagination
$totalQuery = "SELECT COUNT(*) AS total FROM student_health_records $whereClause";
$totalResult = $conn->query($totalQuery);
$totalRow = $totalResult->fetch_assoc();
$totalRecords = $totalRow['total'];
$totalPages = ceil($totalRecords / $recordsPerPage);

// Fetch data with LIMIT and OFFSET
$query = "SELECT id, name, date, grade, exam_age FROM student_health_records $whereClause ORDER BY id DESC LIMIT $recordsPerPage OFFSET $offset";
$result = $conn->query($query);
?>

<!-- Search Form -->
<form method="GET" style="margin-bottom: 20px; text-align: center;">
    <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>"
           placeholder="Search by name or grade..."
           style="padding: 10px; font-size: 16px; width: 300px; border-radius: 5px; border: none;">
    <button type="submit" class="crud-btn">Search</button>
</form>

<?php
if ($result && $result->num_rows > 0) {
    echo "<h2>Existing Student Health Records</h2>";
    echo "<div class='table-container'>";
    echo "<table class='records-table'>";
    echo "<thead><tr>";

    $headers = ['ID', 'Name', 'Date', 'Grade', 'Actions'];
    foreach ($headers as $header) {
        echo "<th>" . htmlspecialchars($header) . "</th>";
    }

    echo "</tr></thead><tbody>";

    while ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        echo "<tr>";
        echo "<td>" . htmlspecialchars($id) . "</td>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['date']) . "</td>";
        echo "<td>" . htmlspecialchars($row['grade']) . "</td>";
        echo "<td>
            <button class='view-btn' onclick='viewRecord($id)'>View</button>
            <button class='delete-btn' onclick='deleteRecord($id)'>Delete</button>
        </td>";
        echo "</tr>";
    }

    echo "</tbody></table></div>";

    // Pagination buttons
    echo "<div style='text-align: center; margin-top: 20px;'>";
    if ($page > 1) {
        echo "<a href='?page=" . ($page - 1) . "&search=" . urlencode($search) . "' class='crud-btn pagination-btn' style='padding: 10px 20px; background-color:rgb(243, 75, 33);'>Previous</a>";
    }
    if ($page < $totalPages) {
        echo "<a href='?page=" . ($page + 1) . "&search=" . urlencode($search) . "' class='crud-btn pagination-btn' style='padding: 10px 20px; background-color:rgb(245, 38, 38);'>Next</a>";
    }
    echo "</div>";
} else {
    echo "<p>No student health records found.</p>";
}
?>



<script>
// Function to handle the "View Full Details" button
function viewRecord(id) {
    // Make an AJAX request to fetch the full record by ID
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "fetch_record.php?id=" + id, true);
    xhr.onload = function() {
        if (xhr.status == 200) {
            // Parse the response JSON
            var data = JSON.parse(xhr.responseText);
            console.log(data); // Debug log

            // Populate the form fields with the fetched data
            document.querySelector('input[name="name"]').value = data.name;
            document.querySelector('input[name="age"]').value = data.age;
            document.querySelector('select[name="sex"]').value = data.sex;
            document.querySelector('input[name="address"]').value = data.address;
            document.querySelector('input[name="tel"]').value = data.tel;
            document.querySelector('input[name="date"]').value = data.date;
            document.querySelector('input[name="grade"]').value = data.grade;
            document.querySelector('input[name="exam_age"]').value = data.exam_age;
            document.querySelector('input[name="weight"]').value = data.weight;
            document.querySelector('input[name="height"]').value = data.height;
            document.querySelector('input[name="bp"]').value = data.bp;

            // Populate health-related fields
            document.querySelector('select[name="mental_status"]').value = data.mental_status;
            document.querySelector('select[name="skin"]').value = data.skin;
            document.querySelector('select[name="headhair"]').value = data.headhair;
            document.querySelector('select[name="vision_left"]').value = data.vision_left;
            document.querySelector('select[name="vision_right"]').value = data.vision_right;
            document.querySelector('select[name="ears"]').value = data.ears;
            document.querySelector('select[name="nose"]').value = data.nose;
            document.querySelector('select[name="throat"]').value = data.throat;
            document.querySelector('select[name="teeth"]').value = data.teeth;
            document.querySelector('select[name="oral_hygiene"]').value = data.oral_hygiene;
            document.querySelector('select[name="neck"]').value = data.neck;
            document.querySelector('select[name="thyroids"]').value = data.thyroids;
            document.querySelector('select[name="chestlungs"]').value = data.chestlungs;
            document.querySelector('select[name="heart"]').value = data.heart;
            document.querySelector('select[name="abdomen"]').value = data.abdomen;
            document.querySelector('select[name="allergies"]').value = data.allergies;
            document.querySelector('select[name="lmp_female"]').value = data.lmp_female;

            // Populate immunizations
            document.querySelector('select[name="measles"]').value = data.measles;
            document.querySelector('select[name="mumps"]').value = data.mumps;
            document.querySelector('select[name="diptheria"]').value = data.diptheria;
            document.querySelector('select[name="whooping_cough"]').value = data.whooping_cough;
            document.querySelector('select[name="smallpox"]').value = data.smallpox;
            document.querySelector('select[name="chickenpox"]').value = data.chickenpox;
            document.querySelector('select[name="typhoid"]').value = data.typhoid;
            document.querySelector('select[name="blood_type"]').value = data.blood_type;

            // Populate remarks and examiner
            document.querySelector('textarea[name="remarks"]').value = data.remarks;
            document.querySelector('input[name="examiner"]').value = data.examiner;
            document.getElementById('record_id').value = data.id;

        }
    };
    xhr.send();
}

function deleteRecord(id) {
    if (confirm("Are you sure you want to delete this record?")) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "delete_record.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onload = function () {
            if (xhr.status == 200) {
                alert(xhr.responseText);
                location.reload(); // Reload page to reflect changes
            } else {
                alert("Error deleting record.");
            }
        };
        xhr.send("id=" + id);
    }
}


function updateRecord() {
    const recordId = document.getElementById('record_id').value;
    if (!recordId) {
        alert("Please view a record before updating.");
        return;
    }

    // Gather all form data
    const form = document.querySelector('form');
    const formData = new FormData(form);
    formData.append("id", recordId); // add record ID explicitly

    // Send AJAX request to update_record.php
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "update_record.php", true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            alert(xhr.responseText);
            location.reload(); // reload to reflect updated data
        } else {
            alert("Failed to update record.");
        }
    };
    xhr.send(formData);
}

function clearForm() {
    const form = document.querySelector('form');
    form.reset(); // Reset all fields (standard inputs)

    // Manually clear fields not reset by .reset()
    document.getElementById('record_id').value = '';
}

</script>







</body>
</html>
