// Log issue date changes for debugging
document.getElementById("issue-date").addEventListener("change", function () {
    console.log("Selected date:", this.value); // Debugging - shows in console
});

// Handle file input changes for certificate image preview
document.getElementById("certificate-image").addEventListener("change", function (event) {
    const fileInput = event.target;
    const file = fileInput.files[0];
    const preview = document.getElementById("image-preview");
    const allowedTypes = ["image/jpeg", "image/png", "image/gif"];

    if (file) {
        if (!allowedTypes.includes(file.type)) {
            alert("Invalid file type! Please upload an image file (JPG, PNG, or GIF).");
            fileInput.value = "";
            if (preview) {
                preview.style.display = "none";
                preview.removeAttribute("src");
                preview.setAttribute("hidden", true);
            }
            return;
        }

        // Show preview only if element exists (optional feature)
        if (preview) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = "block";
                preview.removeAttribute("hidden");
            };
            reader.readAsDataURL(file);
        }
    } else if (preview) {
        preview.style.display = "none";
        preview.removeAttribute("src");
        preview.setAttribute("hidden", true);
    }
});

// Basic form validation before submission
document.getElementById("admin-upload-form").addEventListener("submit", function (event) {
    const certificateInput = document.getElementById("certificate-image");
    const alumniPhotoInput = document.getElementById("alumni-photo");

    if (!certificateInput.files.length || !alumniPhotoInput.files.length) {
        alert("Please upload both the certificate and alumni photo before submitting.");
        event.preventDefault();
        return;
    }
});

// Handle form submission and database upload
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("admin-upload-form");
    const messageContainer = document.createElement("div");
    messageContainer.classList.add("message-container");
    form.parentNode.appendChild(messageContainer);

    form.addEventListener("submit", function (event) {
        event.preventDefault();

        const formData = new FormData(form);

        fetch("upload_certificate.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            messageContainer.textContent = data.message;
            messageContainer.classList.remove("error", "success");

            if (data.status === "success") {
                messageContainer.classList.add("success");
                form.reset(); // Clear form on success
                
                // Clear file preview if it exists (optional feature)
                const preview = document.getElementById("image-preview");
                if (preview) {
                    preview.style.display = "none";
                    preview.removeAttribute("src");
                    preview.setAttribute("hidden", true);
                }
            } else {
                messageContainer.classList.add("error");
            }

            messageContainer.classList.add("show");
            setTimeout(() => {
                messageContainer.classList.remove("show");
            }, 3000);
        })
        .catch(error => {
            console.error("Error:", error);
            messageContainer.textContent = "An unexpected error occurred.";
            messageContainer.classList.add("error", "show");
            setTimeout(() => {
                messageContainer.classList.remove("show");
            }, 3000);
        });
    });
});