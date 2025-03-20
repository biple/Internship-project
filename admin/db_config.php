<?php
$host = "localhost"; // Change this if needed
$user = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$dbname = "globalwings"; // Your database name

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
