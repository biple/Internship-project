<?php
header('Content-Type: application/json');

$response = array('success' => false, 'error' => '');

try {
    // Database connection (adjust credentials as needed)
    $conn = new mysqli('localhost', 'username', 'password', 'database_name');
    if ($conn->connect_error) {
        throw new Exception('Database connection failed: ' . $conn->connect_error);
    }

    // Get the symbol_no from the request
    $data = json_decode(file_get_contents('php://input'), true);
    $symbol_no = isset($data['symbol_no']) ? $data['symbol_no'] : '';

    if (empty($symbol_no)) {
        throw new Exception('Symbol number is required.');
    }

    // Prepare and execute the DELETE query
    $stmt = $conn->prepare("DELETE FROM certificate WHERE symbol_no = ?");
    $stmt->bind_param("s", $symbol_no);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $response['success'] = true;
    } else {
        $response['error'] = 'No certificate found with the given symbol number.';
    }

    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    $response['error'] = $e->getMessage();
}

echo json_encode($response);
?>