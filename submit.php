<?php
header('Content-Type: application/json');
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get raw POST data (JSON)
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    if (!$data) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
        exit;
    }

    // Sanitize and validate
    $first_name = filter_var($data['firstName'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $last_name  = filter_var($data['lastName'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $department = filter_var($data['department'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $gender     = filter_var($data['gender'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $hobbies    = isset($data['hobbies']) ? implode(', ', $data['hobbies']) : '';
    $others     = filter_var($data['others'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);

    if (empty($first_name) || empty($last_name)) {
        echo json_encode(['status' => 'error', 'message' => 'Missing required fields']);
        exit;
    }

    try {
        $sql = "INSERT INTO registrations (first_name, last_name, department, gender, hobbies, others) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$first_name, $last_name, $department, $gender, $hobbies, $others]);

        echo json_encode(['status' => 'success', 'message' => 'Registration saved successfully!']);
    } catch (\PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Only POST requests allowed']);
}
?>
