<?php
session_start();

if (isset($_SESSION['certificate']['certificate_image_path'])) {
    $relative_path = $_SESSION['certificate']['certificate_image_path'];
    // Convert relative path to absolute path
    $image_path = realpath(__DIR__ . '/' . $relative_path);
    
    if ($image_path !== false && file_exists($image_path)) {
        $mime = mime_content_type($image_path);
        header("Content-Type: $mime");
        readfile($image_path);
        exit;
    } else {
        header("HTTP/1.0 404 Not Found");
        echo "Image not found at: " . htmlspecialchars($relative_path);
        exit;
    }
} else {
    header("HTTP/1.0 403 Forbidden");
    echo "Access denied.";
    exit;
}
?>