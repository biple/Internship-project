<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate Not Found</title>
    <link rel="stylesheet" href="../assets/css/user_styles.css">
</head>
<body>
    <div class="container">
        <img src="../assets/images/globalwings.png" alt="Global Wings Logo" class="logo">
        <h2>Certificate Verification Failed</h2>
        <?php
        session_start();
        if (isset($_SESSION['error_message'])) {
            echo "<p>" . htmlspecialchars($_SESSION['error_message']) . "</p>";
            unset($_SESSION['error_message']);
        } else {
            echo "<p>No matching records found. Please check the details and try again.</p>";
        }
        ?>
        <a href="index.html"><button class="btn">Try Again</button></a>
    </div>
</body>
</html>