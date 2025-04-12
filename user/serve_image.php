<?php
session_start();

if (isset($_SESSION['certificate']['certificate_image_path'])) {
    $image_path = $_SESSION['certificate']['certificate_image_path'];
    if (file_exists($image_path)) {
        $mime = mime_content_type($image_path);
        header("Content-Type: $mime");
        readfile($image_path);
        exit;
    } else {
        header("HTTP/1.0 404 Not Found");
        echo "Image not found.";
        exit;
    }
} else {
    header("HTTP/1.0 403 Forbidden");
    echo "Access denied.";
    exit;
}
?>