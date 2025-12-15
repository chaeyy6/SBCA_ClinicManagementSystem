<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("DELETE FROM vaccinations WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: vaccinations.php");
    exit();
} else {
    echo "Invalid request.";
}
?>
