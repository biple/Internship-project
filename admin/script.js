document.getElementById("issue-date").addEventListener("change", function () {
    let date = new Date(this.value);
    if (!isNaN(date)) {
        let formattedDate = 
            ("0" + (date.getMonth() + 1)).slice(-2) + "/" + 
            ("0" + date.getDate()).slice(-2) + "/" + 
            date.getFullYear();
        this.value = formattedDate;
    }
});


document.getElementById("certificate-image").addEventListener("change", function(event) {
    const fileInput = event.target;
    const file = fileInput.files[0];
    const preview = document.getElementById("image-preview");
    const allowedTypes = ["image/jpeg", "image/png", "image/gif"];

    if (file) {
        if (!allowedTypes.includes(file.type)) {
            alert("Invalid file type! Please upload an image file (JPG, PNG, or GIF).");
            fileInput.value = "";
            preview.style.display = "none";
            preview.removeAttribute("src"); // Remove src completely
            preview.setAttribute("hidden", true); // Hide it properly
            return;
        }

        // Show preview only after a valid file is selected
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = "block";
            preview.removeAttribute("hidden"); // Reveal it when an image is uploaded
        };
        reader.readAsDataURL(file);
    } else {
        preview.style.display = "none";
        preview.removeAttribute("src");
        preview.setAttribute("hidden", true); // Hide it properly if file is removed
    }
});

document.getElementById("admin-upload-form").addEventListener("submit", function (event) {
    const fileInput = document.getElementById("certificate-image");
    if (!fileInput.files.length) {
        alert("Please upload an image file before submitting.");
        event.preventDefault();
    }
});

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
            messageContainer.classList.remove("error", "success"); // Reset classes

            if (data.status === "success") {
                messageContainer.classList.add("success");
                form.reset(); // Clear form on success
            } else {
                messageContainer.classList.add("error");
            }

            messageContainer.classList.add("show"); // Show animation

            // Hide after 3 seconds
            setTimeout(() => {
                messageContainer.classList.remove("show");
            }, 3000);
        })
        .catch(error => {
            console.error("Error:", error);
        });
    });
});
