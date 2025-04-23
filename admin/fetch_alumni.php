<?php
header('Content-Type: application/json');

// Database connection
$host = 'localhost';
$dbname = 'globalwings_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]);
    exit;
}

// Get search parameters from the request
$symbol_no = isset($_GET['symbol_no']) ? trim($_GET['symbol_no']) : '';
$name = isset($_GET['name']) ? trim($_GET['name']) : '';
$training_start_date = isset($_GET['training_start_date']) ? trim($_GET['training_start_date']) : '';
$training_end_date = isset($_GET['training_end_date']) ? trim($_GET['training_end_date']) : '';
$issue_date = isset($_GET['issue_date']) ? trim($_GET['issue_date']) : '';

// Build the SQL query dynamically
$query = "SELECT * FROM alumni WHERE 1=1";
$params = [];

if ($symbol_no !== '') {
    $query .= " AND symbol_no = :symbol_no";
    $params[':symbol_no'] = $symbol_no;
}

if ($name !== '') {
    $query .= " AND name LIKE :name";
    $params[':name'] = "%$name%";
}

if ($training_start_date !== '') {
    $query .= " AND training_start_date = :training_start_date";
    $params[':training_start_date'] = $training_start_date;
}

if ($training_end_date !== '') {
    $query .= " AND training_end_date = :training_end_date";
    $params[':training_end_date'] = $training_end_date;
}

if ($issue_date !== '') {
    $query .= " AND issue_date = :issue_date";
    $params[':issue_date'] = $issue_date;
}

try {
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return the results as JSON
    echo json_encode($results);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Query failed: ' . $e->getMessage()]);
}
?>