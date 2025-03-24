# Global Wings Certificate Verification System

## Overview
The **Global Wings Certificate Verification System** is a web-based platform designed to allow students and institutions to verify the authenticity of AirHostess training certifications. This system enables users to validate a certificate by entering their **Symbol Number**, **Issue Date**, and **Training Period**. 

## Features
- **Admin Panel**: Upload certificate records, including student details and their pp sized photos.
- **User Verification**: Students can verify their certificates by entering the required details.
- **Database Integration**: Stores and retrieves certification data securely.
- **Image Upload & Storage**: The pp (passport sized) images are stored in the database.
- **Professional UI**: Simple, user-friendly interface with clear instructions.
- **Future Enhancements**: Planned certificate download functionality.

## Technologies Used
- **Frontend**: HTML, CSS, JavaScript
- **Backend**: PHP
- **Database**: MySQL

## Project Structure
```
GlobalWingsVerification/
│── admin/
│   ├── index.html          # Admin panel home page
│   ├── script.js           # Admin panel JavaScript
│   ├── styles.css          # Admin panel styles
│   ├── upload_certificate.php  # Handles certificate uploads
│   ├── db_config.php       # Database configuration file
│   ├── uploads/            # Directory for uploaded student images
│
│── user/
│   ├── index.html          # User verification page
│   ├── styles.css          # Styles for the user interface
│   ├── verify_certificate.php  # Handles user certificate verification
│
│── assets/
│   ├── images/
│       ├── globalwings.png  # Logo image
│
│── README.md               # Project documentation
│── database.sql            # Database schema for easy setup
```

## Installation & Setup
1. **Clone the Repository**
   ```sh
   git clone https://github.com/yourusername/GlobalWingsVerification.git
   cd GlobalWingsVerification
   ```
2. **Import Database**
3. Open [phpMyAdmin](http://localhost/phpmyadmin/).
4. Click **Import** and select `globalwings.sql`.
5. Click **Go** to import the database.

6. **Run the Application**
   - Place the project in your local server directory (`htdocs` for XAMPP, `www` for WAMP, etc.).
   - Start Apache and MySQL using XAMPP/WAMP.
   - Access the admin panel at `http://localhost/GlobalWingsVerification/admin/`.
   - Access the verification page at `http://localhost/GlobalWingsVerification/user/`.

## Future Plans
- Implement **certificate download** feature.
- Enhance security and data validation.
- Improve UI/UX for a better experience.
## License
This project is open-source and available under the [MIT License](LICENSE).

---
Developed with ❤️ by **Global Wings Development Team**
