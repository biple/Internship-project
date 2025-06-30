# Internship Project: GlobalWings Alumni Management System

[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](LICENSE)

A web‑based alumni management system designed and implemented for **GlobalWings**, built with HTML, CSS, PHP and JavaScript. This project streamlines certificate issuance, verification, and alumni record‑keeping.

---

## Table of Contents

- [Demo](#demo)  
- [Features](#features)  
- [Directory Structure](#directory-structure)  
- [Getting Started](#getting-started)  
  - [Prerequisites](#prerequisites)  
  - [Installation](#installation)  
- [Usage](#usage)  
- [Technology Stack](#technology-stack)  
- [Contributing](#contributing)  
- [License](#license)  
- [Contact](#contact)  

---

## Features

- **Admin Dashboard**  
  - Upload and manage alumni records.  
  - Generate and store certificates as PDFs.  
- **User Portal**  
  - Alumni can verify and download their certificates online.  
- **Assets Management**  
  - Central store for images, logos, and other static files.  

---

## Directory Structure

```plaintext
Internship-project/
├── admin/                  
│   ├── index.html          # Admin login/dashboard
│   ├── styles.css          # Admin styling
│   ├── script.js           # Admin JavaScript logic
│   ├── upload.php          # CSV/Certificate upload script
│   └── verify.php          # Certificate verification logic
│
├── user/                   
│   ├── index.html          # Verification form page
│   └── styles.css          # User-facing styles
│
├── assets/                 
│   └── images/
│       └── globalwings.png # Logo used in frontend
│
├── .gitattributes          # Git attribute settings
├── README.md               # Project overview (this file)

