<?php
include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $symbol_no = $conn->real_escape_string($_POST['symbol_no']);
    $graduated_student = $conn->real_escape_string($_POST['graduated_student']);
    $training_period = $conn->real_escape_string($_POST['training_period']);
    $issue_date = date("Y-m-d", strtotime($_POST['issue_date'])); // Convert to MySQL format

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
        die("Invalid file type! Only JPG, PNG, and GIF allowed.");
    }

    if (move_uploaded_file($_FILES["certificate_image"]["tmp_name"], $image_path)) {
        // Insert into Database
        $sql = "INSERT INTO certificates (symbol_no, trainee_name, training_period, issue_date, image_path) 
                VALUES ('$symbol_no', '$trainee_name', '$training_period', '$issue_date', '$image_path')";

        if ($conn->query($sql) === TRUE) {
            echo "Certificate uploaded successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Error uploading the image.";
    }

    $conn->close();
}
?>
