<?php
header('Content-Type: application/json');

// Database connection
$host = 'localhost';
$dbname = 'airhostess_training';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]);
    exit;
}

// Get form data
$symbol_no = $_POST['symbol_no'] ?? '';
$name = $_POST['name'] ?? '';
$alumni_email = $_POST['alumni_email'] ?? '';
$alumni_contact = $_POST['alumni_contact'] ?? '';
$training_start_date = $_POST['training_start_date'] ?? '';
$training_end_date = $_POST['training_end_date'] ?? '';
$issue_date = $_POST['issue_date'] ?? '';

if (!$symbol_no) {
    echo json_encode(['error' => 'Symbol number is required']);
    exit;
}

// Handle file upload if a new photo is provided
$image_path = null;
if (isset($_FILES['image_path']) && $_FILES['image_path']['error'] === UPLOAD_ERR_OK) {
    $upload_dir = 'uploads/';
    $file_name = time() . '_' . basename($_FILES['image_path']['name']);
    $target_path = $upload_dir . $file_name;

    if (move_uploaded_file($_FILES['image_path']['tmp_name'], $target_path)) {
        $image_path = $target_path;
    } else {
        echo json_encode(['error' => 'Failed to upload photo']);
        exit;
    }
}

// Build the update query
$query = "UPDATE certificates SET 
    graduated_student = :name, 
    alumni_email = :alumni_email, 
    alumni_contact = :alumni_contact, 
    training_start = :training_start_date, 
    training_end = :training_end_date, 
    issue_date = :issue_date";
$params = [
    ':name' => $name,
    ':alumni_email' => $alumni_email,
    ':alumni_contact' => $alumni_contact,
    ':training_start_date' => $training_start_date,
    ':training_end_date' => $training_end_date,
    ':issue_date' => $issue_date
];

// Add image_path to the query if a new photo was uploaded
if ($image_path) {
    $query .= ", alumni_photo_path = :image_path";
    $params[':image_path'] = $image_path;
}

$query .= " WHERE symbol_no = :symbol_no";
$params[':symbol_no'] = $symbol_no;

try {
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    echo json_encode(['success' => true, 'image_path' => $image_path]);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Query failed: ' . $e->getMessage()]);
}
?>