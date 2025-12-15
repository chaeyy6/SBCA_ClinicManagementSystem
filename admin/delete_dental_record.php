<?php
// delete_dental_record.php
require 'db_connect.php';  // your PDO connection in $conn

// Turn on exceptions
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (!isset($_GET['id'])) {
    // Nothing to delete
    header("Location: dental_records.php?msg=error_no_id");
    exit;
}

$id = intval($_GET['id']);

try {
    // Prepare + execute DELETE
    $stmt = $conn->prepare("DELETE FROM dental_records WHERE id = :id");
    $stmt->execute([':id' => $id]);

    // Redirect back with a “deleted” flag
    header("Location: dental_records.php?msg=deleted");
    exit;

} catch (PDOException $e) {
    // On error, you can redirect with an error code
    header("Location: dental_records.php?msg=error_delete");
    exit;
}
