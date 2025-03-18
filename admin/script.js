document.getElementById("certificate-image").addEventListener("change", function (event) {
    const fileInput = event.target;
    const file = fileInput.files[0];
    const preview = document.getElementById("image-preview");
    const allowedTypes = ["image/jpeg", "image/png", "image/gif"];

    if (file) {
        if (!allowedTypes.includes(file.type)) {
            alert("Invalid file type! Please upload an image file (JPG, PNG, or GIF).");
            fileInput.value = "";
            preview.style.display = "none";
            return;
        }

        // Show image preview
        const reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.style.display = "block";
        };
        reader.readAsDataURL(file);
    }
});

document.getElementById("admin-upload-form").addEventListener("submit", function (event) {
    const fileInput = document.getElementById("certificate-image");
    if (!fileInput.files.length) {
        alert("Please upload an image file before submitting.");
        event.preventDefault();
    }
});
