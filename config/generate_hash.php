<?php
// Hash the password
$hashed_password = password_hash('Marc123!', PASSWORD_DEFAULT);

// Output the hashed password to use for the database insert
echo $hashed_password;
?>
