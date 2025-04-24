<?php
header('Content-Type: application/json');

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

        // Validate file types and sizes
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $max_size = 5 * 1024 * 1024; // 5MB

        // Process alumni photo
        $alumni_photo = $_FILES['alumni_photo'];
        if ($alumni_photo['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("Failed to upload alumni photo.");
        }
        if (!in_array($alumni_photo['type'], $allowed_types)) {
            throw new Exception("Alumni photo must be an image (JPEG, PNG, or GIF).");
        }
        if ($alumni_photo['size'] > $max_size) {
            throw new Exception("Alumni photo size must be less than 5MB.");
        }

        $alumni_photo_name = uniqid() . '_' . basename($alumni_photo['name']);
        $alumni_photo_path = $upload_dir . $alumni_photo_name;
        if (!move_uploaded_file($alumni_photo['tmp_name'], $alumni_photo_path)) {
            throw new Exception("Failed to move alumni photo.");
        }

        // Process certificate image
        $certificate_image = $_FILES['certificate_image'];
        if ($certificate_image['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("Failed to upload certificate image.");
        }
        if (!in_array($certificate_image['type'], $allowed_types)) {
            throw new Exception("Certificate image must be an image (JPEG, PNG, or GIF).");
        }
        if ($certificate_image['size'] > $max_size) {
            throw new Exception("Certificate image size must be less than 5MB.");
        }

        $certificate_image_name = uniqid() . '_' . basename($certificate_image['name']);
        $certificate_image_path = $upload_dir . $certificate_image_name;
        if (!move_uploaded_file($certificate_image['tmp_name'], $certificate_image_path)) {
            throw new Exception("Failed to move certificate image.");
        }

        // Insert into certificates table
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
echo json_encode($response);
exit;
?>