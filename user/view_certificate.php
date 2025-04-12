<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Certificate</title>
    <link rel="stylesheet" href="styles.css">
    <!-- Include jsPDF library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
</head>
<body>
    <div class="container">
        <img src="../assets/images/globalwings.png" alt="Global Wings Logo" class="logo">
        <?php
        session_start();
        // Debug: Output session data
        echo "<pre>Session Data Available: ";
        print_r($_SESSION['certificate']);
        echo "</pre>";
        if (isset($_SESSION['certificate'])) {
            $certificate = $_SESSION['certificate'];
            // Display the certificate image from the database path
            echo '<div id="certificate-container" style="margin-top: 20px;">';
            echo '<img id="certificate-image" src="' . htmlspecialchars($certificate['certificate_image_path']) . '" style="max-width: 100%; border: 1px solid #ccc; border-radius: 5px;">';
            // Download as PDF button
            echo '<button class="btn" id="download-pdf" style="margin-top: 10px;">Download as PDF</button>';
            echo '</div>';
        } else {
            echo "<p>Error: Certificate data not found. Please try again.</p>";
            echo '<a href="index.html"><button class="btn">Try Again</button></a>';
        }
        ?>
    </div>

    <script>
        // Download certificate as PDF when "Download as PDF" is clicked
        document.getElementById('download-pdf').addEventListener('click', function() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            // Get the certificate image
            const img = document.getElementById('certificate-image');
            const imgWidth = img.naturalWidth;
            const imgHeight = img.naturalHeight;

            // Calculate dimensions to fit within PDF (A4 size: 210mm x 297mm)
            const pdfWidth = 210; // A4 width in mm
            const pdfHeight = 297; // A4 height in mm
            let width = imgWidth;
            let height = imgHeight;

            // Scale image to fit within A4 dimensions
            const aspectRatio = imgWidth / imgHeight;
            if (width > pdfWidth || height > pdfHeight) {
                if (aspectRatio > 1) {
                    width = pdfWidth - 20; // Leave some margin
                    height = width / aspectRatio;
                } else {
                    height = pdfHeight - 20; // Leave some margin
                    width = height * aspectRatio;
                }
            }

            // Center the image on the PDF
            const x = (pdfWidth - width) / 2;
            const y = (pdfHeight - height) / 2;

            // Add image to PDF
            doc.addImage(img, 'JPEG', x, y, width, height);

            // Download the PDF
            doc.save('certificate.pdf');
        });
    </script>
</body>
</html>