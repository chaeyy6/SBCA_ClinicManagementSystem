<?php
// Include database connection
include('db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $id = $_POST['id'];  // Get the ID of the record to update
    $student_name = $_POST['student_name'];
    $vaccine_name = $_POST['vaccine_name'];
    $date1 = $_POST['date1'];
    $date2 = $_POST['date2'];
    $date3 = $_POST['date3'];
    $date4 = $_POST['date4'];
    $findings = $_POST['findings'];
    $treatment = $_POST['treatment'];

    // Prepare the update query
    $query = "UPDATE vaccinations SET 
              student_name = :student_name,
              vaccine_name = :vaccine_name,
              date1 = :date1,
              date2 = :date2,
              date3 = :date3,
              date4 = :date4,
              findings = :findings,
              treatment = :treatment
              WHERE id = :id";

    $stmt = $conn->prepare($query);
    
    // Bind the parameters
    $stmt->bindParam(':student_name', $student_name);
    $stmt->bindParam(':vaccine_name', $vaccine_name);
    $stmt->bindParam(':date1', $date1);
    $stmt->bindParam(':date2', $date2);
    $stmt->bindParam(':date3', $date3);
    $stmt->bindParam(':date4', $date4);
    $stmt->bindParam(':findings', $findings);
    $stmt->bindParam(':treatment', $treatment);
    $stmt->bindParam(':id', $id);

    // Execute the update query
    if ($stmt->execute()) {
        // Redirect to the vaccinations page or display a success message
        header("Location: vaccinations.php?status=success");
        exit();
    } else {
        echo "Error updating record.";
    }
}
?>
