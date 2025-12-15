<?php
// Include database connection
include('db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['id'])) {
        // Create new record (when id is not provided)
        $student_name = $_POST['student_name'];
        $vaccine_name = $_POST['vaccine_name'];
        $date1 = $_POST['date1'];
        $date2 = $_POST['date2'];
        $date3 = $_POST['date3'];
        $date4 = $_POST['date4'];
        $findings = $_POST['findings'];
        $treatment = $_POST['treatment'];

        // Prepare the insert query
        $query = "INSERT INTO vaccinations (student_name, vaccine_name, date1, date2, date3, date4, findings, treatment) 
                  VALUES (:student_name, :vaccine_name, :date1, :date2, :date3, :date4, :findings, :treatment)";
        
        $stmt = $conn->prepare($query);
        
        // Bind parameters for the insert query
        $stmt->bindParam(':student_name', $student_name);
        $stmt->bindParam(':vaccine_name', $vaccine_name);
        $stmt->bindParam(':date1', $date1);
        $stmt->bindParam(':date2', $date2);
        $stmt->bindParam(':date3', $date3);
        $stmt->bindParam(':date4', $date4);
        $stmt->bindParam(':findings', $findings);
        $stmt->bindParam(':treatment', $treatment);
        
        // Execute the insert query
        if ($stmt->execute()) {
            // Redirect or display success message
            header("Location: vaccinations.php?status=success");
            exit();
        } else {
            echo "Error inserting record.";
        }
    } else {
        // Update existing record (when id is present)
        $id = $_POST['id'];
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
        
        // Bind parameters for the update query
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
            // Redirect or display success message
            header("Location: vaccinations.php?status=success");
            exit();
        } else {
            echo "Error updating record.";
        }
    }
}
?>
