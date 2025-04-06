<?php
include 'db_config.php';

header('Content-Type: application/json'); // Ensure JSON response
ob_clean(); // Clears any accidental output

$response = ["status" => "error", "message" => "Something went wrong!"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $symbol_no = $conn->real_escape_string($_POST['symbol_no']);
    $graduated_student = $conn->real_escape_string($_POST['graduated_student']);
    $training_period = $conn->real_escape_string($_POST['training_period']);
    $issue_date = $conn->real_escape_string($_POST['issue_date']);
    $alumni_email = $conn->real_escape_string($_POST['alumni_email']);
    $alumni_contact = $conn->real_escape_string($_POST['alumni_contact']);

    // Ensure files are uploaded properly
    if (!isset($_FILES['alumni_photo']) || $_FILES['alumni_photo']['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(["status" => "error", "message" => "No valid alumni photo uploaded."]);
        exit;
    }

    if (!isset($_FILES['certificate_image']) || $_FILES['certificate_image']['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(["status" => "error", "message" => "No valid certificate image uploaded."]);
        exit;
    }

    // Check if upload directories are writable
    if (!is_writable("uploads/") || !is_writable("uploads/")) {
        echo json_encode(["status" => "error", "message" => "Upload directories are not writable."]);
        exit;
    }

    // Handle alumni photo upload
    $alumni_photo = $_FILES['alumni_photo']['name'];
    $alumni_photo_tmp = $_FILES['alumni_photo']['tmp_name'];
    $alumni_photo_target = "uploads/" . basename($alumni_photo);

    // Handle certificate image upload
    $certificate_image = $_FILES['certificate_image']['name'];
    $certificate_image_tmp = $_FILES['certificate_image']['tmp_name'];
    $certificate_image_target = "uploads/" . basename($certificate_image);

    // Ensure both images are uploaded successfully
    if (!move_uploaded_file($alumni_photo_tmp, $alumni_photo_target)) {
        echo json_encode(["status" => "error", "message" => "Failed to upload alumni photo."]);
        exit;
    }

    if (!move_uploaded_file($certificate_image_tmp, $certificate_image_target)) {
        echo json_encode(["status" => "error", "message" => "Failed to upload certificate image."]);
        exit;
    }

    // Insert into database
    $sql = "INSERT INTO certificates (symbol_no, graduated_student, training_period, issue_date, alumni_email, alumni_contact, alumni_photo, certificate_image) 
            VALUES ('$symbol_no', '$graduated_student', '$training_period', '$issue_date', '$alumni_email', '$alumni_contact', '$alumni_photo_target', '$certificate_image_target')";

    if (mysqli_query($conn, $sql)) {
        $response = ["status" => "success", "message" => "Data uploaded successfully!"];
    } else {
        $response = ["status" => "error", "message" => "Database error: " . mysqli_error($conn)];
    }

    echo json_encode($response);
    mysqli_close($conn);
}
