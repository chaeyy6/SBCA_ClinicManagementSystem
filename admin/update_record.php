<?php
// Database connection credentials for Hostinger
$host = "localhost";
$user = "u659680966_2022300091"; // Your Hostinger DB username
$pass = "Sonchaeyoung6";         // Your Hostinger DB password
$db = "u659680966_SBCA_CMS";     // Your Hostinger DB name

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';

    if (!$id) {
        echo "No record ID provided.";
        exit;
    }

    $fields = [
        'name', 'age', 'sex', 'address', 'tel', 'date', 'grade', 'exam_age', 'weight', 'height', 'bp',
        'mental_status', 'skin', 'headhair', 'vision_left', 'vision_right', 'ears', 'nose', 'throat',
        'teeth', 'oral_hygiene', 'neck', 'thyroids', 'chestlungs', 'heart', 'abdomen',
        'allergies', 'lmp_female', 'measles', 'mumps', 'diptheria', 'whooping_cough', 'smallpox',
        'chickenpox', 'typhoid', 'blood_type', 'remarks', 'examiner'
    ];

    $updates = [];
    foreach ($fields as $field) {
        $value = isset($_POST[$field]) ? $conn->real_escape_string($_POST[$field]) : '';
        $updates[] = "$field = '$value'";
    }

    $updateStr = implode(", ", $updates);
    $sql = "UPDATE student_health_records SET $updateStr WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully.";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>
