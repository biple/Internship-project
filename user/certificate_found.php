<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate Found</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <img src="../assets/images/globalwings.png" alt="Global Wings Logo" class="logo">
        <h2>Certificate Verification Successful</h2>
        <?php
        session_start();
        if (isset($_SESSION['certificate'])) {
            $certificate = $_SESSION['certificate'];
            echo "<p>Certificate Holder: <strong>" . htmlspecialchars($certificate['graduated_student']) . "</strong></p>";
            echo "<p>Would you like to view or download the certificate?</p>";
            echo '<a href="' . htmlspecialchars($certificate['certificate_image_path']) . '" target="_blank"><button class="btn">View Certificate</button></a>';
            echo '<a href="' . htmlspecialchars($certificate['certificate_image_path']) . '" download><button class="btn">Download Certificate</button></a>';
        } else {
            echo "<p>Error: Certificate data not found. Please try again.</p>";
            echo '<a href="index.html"><button class="btn">Try Again</button></a>';
        }
        ?>
    </div>
</body>
</html>