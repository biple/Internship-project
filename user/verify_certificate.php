<?php
session_start(); // Start session to pass data to the result page

// Database configuration
$host = 'localhost';
$dbname = 'airhostess_training';
$username = 'root'; // Replace with your MySQL username
$password = '';     // Replace with your MySQL password

try {
    // Create database connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Validate required fields
        $required_fields = ['symbol_no', 'issuedate', 'training_start', 'training_end'];
        foreach ($required_fields as $field) {
            if (empty($_POST[$field])) {
                throw new Exception("All fields are required.");
            }
        }

        // Get form data
        $symbol_no = $_POST['symbol_no'];
        $issue_date = $_POST['issuedate'];
        $training_start = $_POST['training_start'];
        $training_end = $_POST['training_end'];

        // Query to check if certificate exists
        $stmt = $pdo->prepare("
            SELECT graduated_student, certificate_image_path 
            FROM certificates 
            WHERE symbol_no = ? 
            AND issue_date = ? 
            AND training_start = ? 
            AND training_end = ?
        ");
        $stmt->execute([$symbol_no, $issue_date, $training_start, $training_end]);
        $certificate = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($certificate) {
            // Adjust the certificate image path to be relative to the user/ directory
            $adjusted_image_path = '../admin/' . $certificate['certificate_image_path'];
            // Certificate found, store data in session and redirect to success page
            $_SESSION['certificate'] = [
                'graduated_student' => $certificate['graduated_student'],
                'certificate_image_path' => $adjusted_image_path
            ];
            // Debug: Output session data
            echo "<pre>Session Data Set: ";
            print_r($_SESSION['certificate']);
            echo "</pre>";
            header("Location: certificate_found.php");
            exit;
        } else {
            // Certificate not found, redirect to failure page
            header("Location: certificate_not_found.php");
            exit;
        }
    }
} catch (Exception $e) {
    // On error, redirect to failure page with error message
    $_SESSION['error_message'] = "Error: " . $e->getMessage();
    header("Location: certificate_not_found.php");
    exit;
}
?>