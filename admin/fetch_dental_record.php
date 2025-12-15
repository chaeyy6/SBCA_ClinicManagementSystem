<?php
// fetch_dental_record.php
header('Content-Type: application/json');

// Database connection credentials for Hostinger
$host = "localhost";
$user = "u659680966_2022300091"; // Your Hostinger DB username
$pass = "Sonchaeyoung6";         // Your Hostinger DB password
$db = "u659680966_SBCA_CMS";     // Your Hostinger DB name

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

if (!isset($_GET['id'])) {
    echo json_encode(['error' => 'No ID provided']);
    exit;
}

$id = intval($_GET['id']); // Ensure the ID is an integer

$sql = "SELECT * FROM dental_records WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();

    // Optional: decode tooth_chart if it's stored as JSON in DB
    if (!empty($row['tooth_chart']) && is_string($row['tooth_chart'])) {
        $row['tooth_chart'] = $row['tooth_chart']; // raw JSON string
    }

    echo json_encode($row);
} else {
    echo json_encode(['error' => 'Record not found']);
}

$stmt->close();
$conn->close();
?>
