<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate Found</title>
    <link rel="stylesheet" href="styles.css">
    <!-- Include jsPDF library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
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
            // View Certificate button
            echo '<button class="btn" id="view-certificate">View Certificate</button>';
            // Hidden container for the certificate image
            echo '<div id="certificate-container" style="display: none; margin-top: 20px;">';
            echo '<img id="certificate-image" src="' . htmlspecialchars($certificate['certificate_image_path']) . '" style="max-width: 100%; border: 1px solid #ccc; border-radius: 5px;">';
            // Download as PDF button (visible only when image is shown)
            echo '<button class="btn" id="download-pdf" style="margin-top: 10px;">Download as PDF</button>';
            echo '</div>';
        } else {
            echo "<p>Error: Certificate data not found. Please try again.</p>";
            echo '<a href="index.html"><button class="btn">Try Again</button></a>';
        }
        ?>
    </div>

    <script>
        // Show certificate image when "View Certificate" is clicked
        document.getElementById('view-certificate').addEventListener('click', function() {
            const container = document.getElementById('certificate-container');
            container.style.display = 'block';
            this.style.display = 'none'; // Hide the "View Certificate" button after clicking
        });

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