<?php
// Database connection settings
$host = 'localhost'; // or your server IP
$dbname = 'u659680966_SBCA_CMS'; // The database you created
$username = 'u659680966_2022300091'; // default username for XAMPP (you can change this)
$password = 'Sonchaeyoung6'; // default password for XAMPP (you can change this)

// Create a PDO (PHP Data Object) instance for database connection
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Optionally, echo a success message (for debugging purposes)
    // echo "Connected successfully"; 
} catch (PDOException $e) {
    // In case of an error, we catch and display the error message
    echo "Connection failed: " . $e->getMessage();
}
?>
