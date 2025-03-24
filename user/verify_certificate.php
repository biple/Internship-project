<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$database = "globalwings"; // Update with your actual database name

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['symbol_no']) && !empty($_POST['issuedate']) && !empty($_POST['year'])) {
        $symbol_no = $conn->real_escape_string($_POST['symbol_no']);
        $issuedate = $conn->real_escape_string($_POST['issuedate']);
        $year = $conn->real_escape_string($_POST['year']); // Matches 'training_period'

        $sql = "SELECT graduated_student, image_path FROM certificates WHERE symbol_no = '$symbol_no' AND issue_date = '$issuedate' AND training_period = '$year'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $graduated_student = $row['graduated_student'];
            $certificate_url = $row['image_path'];

            echo "<!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Certificate Verified</title>
                <style>
                    body {
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        height: 100vh;
                        text-align: center;
                        font-family: Arial, sans-serif;
                        background-color: #f4f4f4;
                    }
                    .container {
                        background: white;
                        padding: 30px;
                        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
                        border-radius: 10px;
                    }
                    h2 {
                        color: #b71c1c;
                    }
                    p {
                        font-size: 18px;
                        margin-top: 10px;
                    }
                    .download-btn {
                        display: inline-block;
                        margin-top: 20px;
                        padding: 10px 20px;
                        background: #b71c1c;
                        color: white;
                        text-decoration: none;
                        border-radius: 5px;
                        font-size: 16px;
                    }
                    .download-btn:hover {
                        background: #e40707;
                    }
                </style>
            </head>
            <body>
                <div class='container'>
                    <h2>Certificate Verified Successfully</h2>
                    <p>Dear <strong>$graduated_student</strong>, would you like to view and download your certification now?</p>
                    <a href='$certificate_url' class='download-btn' download>Click Here to Download</a>
                </div>
            </body>
            </html>";
        } else {
            echo "<!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Verification Failed</title>
                <style>
                    body {
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        height: 100vh;
                        text-align: center;
                        font-family: Arial, sans-serif;
                        background-color: #f4f4f4;
                    }
                    .container {
                        background: white;
                        padding: 30px;
                        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
                        border-radius: 10px;
                    }
                    h2 {
                        color: #D9534F; /* Red for error */
                    }
                    p {
                        font-size: 18px;
                        margin-top: 10px;
                        color: #D9534F;
                    }
                    .retry-btn {
                        display: inline-block;
                        margin-top: 20px;
                        padding: 10px 20px;
                        background: #D9534F;
                        color: white;
                        text-decoration: none;
                        border-radius: 5px;
                        font-size: 16px;
                    }
                    .retry-btn:hover {
                        background: #B52B27;
                    }
                </style>
            </head>
            <body>
                <div class='container'>
                    <h2>Verification Failed</h2>
                    <p>No matching record found. Please check your details and try again.</p>
                    <a href='index.html' class='retry-btn'>Try Again</a>
                </div>
            </body>
            </html>";
        }
    } else {
        echo "<h2>Error</h2>";
        echo "<p>All fields are required. Please fill out the form correctly.</p>";
    }
}

$conn->close();
?>
