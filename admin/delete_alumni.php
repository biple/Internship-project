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

// Get the symbol_no from the request
$input = json_decode(file_get_contents('php://input'), true);
$symbol_no = $input['symbol_no'] ?? '';

if (!$symbol_no) {
    echo json_encode(['error' => 'Symbol number is required']);
    exit;
}

// Delete the record
try {
    $query = "DELETE FROM certificates WHERE symbol_no = :symbol_no";
    $stmt = $pdo->prepare($query);
    $stmt->execute([':symbol_no' => $symbol_no]);
    
    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'No record found with the given symbol number']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Query failed: ' . $e->getMessage()]);
}
?>