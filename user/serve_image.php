<?php
session_start();

// Debug: Log session data
error_log("Session Data in serve_image.php: " . print_r($_SESSION['certificate'], true));

if (isset($_SESSION['certificate']['certificate_image_path'])) {
    $relative_path = $_SESSION['certificate']['certificate_image_path'];
    // Convert relative path to absolute path
    $image_path = realpath(__DIR__ . '/' . $relative_path);
    // Debug: Log the image path
    error_log("Relative Path: " . $relative_path);
    error_log("Absolute Path: " . $image_path);
    
    if ($image_path !== false && file_exists($image_path)) {
        // Debug: Log file exists
        error_log("File exists: " . $image_path);
        $mime = mime_content_type($image_path);
        header("Content-Type: $mime");
        readfile($image_path);
        exit;
    } else {
        // Debug: Log file not found
        error_log("File does not exist: " . $image_path);
        header("HTTP/1.0 404 Not Found");
        echo "Image not found at: " . htmlspecialchars($relative_path);
        exit;
    }
} else {
    // Debug: Log session data missing
    error_log("Session data missing in serve_image.php");
    header("HTTP/1.0 403 Forbidden");
    echo "Access denied.";
    exit;
}
?>