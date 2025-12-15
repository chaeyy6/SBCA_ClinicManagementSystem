<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    // Database credentials for Hostinger
    $conn = new mysqli("localhost", "u659680966_2022300091", "Sonchaeyoung6", "u659680966_SBCA_CMS");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Securely get the ID
    $id = $conn->real_escape_string($_POST['id']);

    // Use prepared statements to protect against SQL injection
    $sql = "DELETE FROM student_health_records WHERE id = ?";
    
    if ($stmt = $conn->prepare($sql)) {
        // Bind the ID parameter to the prepared statement
        $stmt->bind_param("i", $id);  // 'i' indicates the ID is an integer
        
        // Execute the query
        if ($stmt->execute()) {
            echo "Record deleted successfully.";
        } else {
            echo "Error deleting record: " . $stmt->error;
        }
        
        // Close the statement
        $stmt->close();
    } else {
        echo "Error preparing the SQL statement: " . $conn->error;
    }

    // Close the connection
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
