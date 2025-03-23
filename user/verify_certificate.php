<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$database = "globalwings"; // Update with your actual database name

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are present
    if (!empty($_POST['symbol_no']) && !empty($_POST['issuedate']) && !empty($_POST['year'])) {
        $symbol_no = $conn->real_escape_string($_POST['symbol_no']);
        $issuedate = $conn->real_escape_string($_POST['issuedate']);
        $year = $conn->real_escape_string($_POST['year']); // Matches 'training_period'

        // Query to check certificate existence
        $sql = "SELECT * FROM certificates WHERE symbol_no = '$symbol_no' AND issue_date = '$issuedate' AND training_period = '$year'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<h2>Certificate Verified</h2>";
            echo "<p>Your details match our records.</p>";
        } else {
            echo "<h2>Verification Failed</h2>";
            echo "<p>No matching record found. Please check your details and try again.</p>";
        }
    } else {
        echo "<h2>Error</h2>";
        echo "<p>All fields are required. Please fill out the form correctly.</p>";
    }
}

$conn->close();
?>
