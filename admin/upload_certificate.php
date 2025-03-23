<?php
include 'db_config.php';

header('Content-Type: application/json'); // Ensure JSON response

$response = ["status" => "error", "message" => "Something went wrong!"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $symbol_no = $conn->real_escape_string($_POST['symbol_no']);
    $graduated_student = $conn->real_escape_string($_POST['graduated_student']);
    $training_period = $conn->real_escape_string($_POST['training_period']);
    $issue_date = $_POST['issue_date']; // Use the direct date value from input


    // Handle Image Upload
    $upload_dir = "uploads/";
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $image_name = basename($_FILES["certificate_image"]["name"]);
    $image_path = $upload_dir . uniqid() . "_" . $image_name;
    $image_type = strtolower(pathinfo($image_path, PATHINFO_EXTENSION));

    // Allowed file types
    $allowed_types = ["jpg", "jpeg", "png", "gif"];
    if (!in_array($image_type, $allowed_types)) {
        $response["message"] = "Invalid file type! Only JPG, PNG, and GIF allowed.";
        echo json_encode($response);
        exit;
    }

    if (move_uploaded_file($_FILES["certificate_image"]["tmp_name"], $image_path)) {
        // Insert into Database
        $sql = "INSERT INTO certificates (symbol_no, graduated_student, training_period, issue_date, image_path) 
                VALUES ('$symbol_no', '$graduated_student', '$training_period', '$issue_date', '$image_path')";

        if ($conn->query($sql) === TRUE) {
            $response["status"] = "success";
            $response["message"] = "Certificate uploaded successfully!";
        } else {
            $response["message"] = "Database error: " . $conn->error;
        }
    } else {
        $response["message"] = "Error uploading the image.";
    }
}

$conn->close();
echo json_encode($response);
