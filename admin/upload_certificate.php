<?php
// Database configuration
$host = 'localhost';
$dbname = 'airhostess_training';
$username = 'root'; // Replace with your MySQL username
$password = '';     // Replace with your MySQL password

// Response array
$response = ['status' => '', 'message' => ''];

try {
    // Create database connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Validate required fields
        $required_fields = [
            'symbol_no', 'graduated_student', 'training_start', 
            'training_end', 'issue_date', 'alumni_email', 'alumni_contact'
        ];
        
        foreach ($required_fields as $field) {
            if (empty($_POST[$field])) {
                throw new Exception("All fields are required.");
            }
        }

        // Validate file uploads
        if (!isset($_FILES['alumni_photo']) || !isset($_FILES['certificate_image'])) {
            throw new Exception("Both photo and certificate image are required.");
        }

        // File upload handling
        $upload_dir = 'uploads/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Process alumni photo
        $alumni_photo = $_FILES['alumni_photo'];
        $alumni_photo_name = uniqid() . '_' . basename($alumni_photo['name']);
        $alumni_photo_path = $upload_dir . $alumni_photo_name;
        
        if ($alumni_photo['error'] !== UPLOAD_ERR_OK || 
            !move_uploaded_file($alumni_photo['tmp_name'], $alumni_photo_path)) {
            throw new Exception("Failed to upload alumni photo.");
        }

        // Process certificate image
        $certificate_image = $_FILES['certificate_image'];
        $certificate_image_name = uniqid() . '_' . basename($certificate_image['name']);
        $certificate_image_path = $upload_dir . $certificate_image_name;
        
        if ($certificate_image['error'] !== UPLOAD_ERR_OK || 
            !move_uploaded_file($certificate_image['tmp_name'], $certificate_image_path)) {
            throw new Exception("Failed to upload certificate image.");
        }

        // Prepare and execute SQL statement
        $stmt = $pdo->prepare("
            INSERT INTO certificates (
                symbol_no, graduated_student, training_start, training_end,
                issue_date, alumni_email, alumni_contact, alumni_photo_path,
                certificate_image_path
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $_POST['symbol_no'],
            $_POST['graduated_student'],
            $_POST['training_start'],
            $_POST['training_end'],
            $_POST['issue_date'],
            $_POST['alumni_email'],
            $_POST['alumni_contact'],
            $alumni_photo_path,
            $certificate_image_path
        ]);

        $response['status'] = 'success';
        $response['message'] = 'Certificate data uploaded successfully!';
    }
} catch (Exception $e) {
    $response['status'] = 'error';
    $response['message'] = 'Error: ' . $e->getMessage();
    
    // Clean up uploaded files if insertion fails
    if (isset($alumni_photo_path) && file_exists($alumni_photo_path)) {
        unlink($alumni_photo_path);
    }
    if (isset($certificate_image_path) && file_exists($certificate_image_path)) {
        unlink($certificate_image_path);
    }
}

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
exit;
?>