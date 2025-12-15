<?php
// db_connect.php
include('db_connect.php'); // Ensure you have the database connection

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the full record based on ID using PDO
    $stmt = $conn->prepare("SELECT * FROM student_health_records WHERE id = :id");
    
    // Bind the parameter using PDO
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
    // Execute the statement
    $stmt->execute();
    
    // Fetch the result
    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($row); // Return the data in JSON format
    } else {
        echo json_encode(["error" => "Record not found"]);
    }
} else {
    echo json_encode(["error" => "No ID provided"]);
}
?>
