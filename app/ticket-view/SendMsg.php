<?php

session_start();
header('Content-Type: application/json');

require "../includes/dbconn.php";

$data = json_decode(file_get_contents("php://input"), true);

$msg = $data["msg"] ?? null;
$case_id = $data["case_id"] ?? null;

$user = get_object_vars($_SESSION["user"]);

// Check input
if (!$msg || !$case_id) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => "Missing parameters"
    ]);
    exit;
}

// Check that user has access to the case
$stmt = $conn->prepare("
    SELECT id
    FROM cases
    WHERE id = ? AND user_id = ?
    LIMIT 1
");

$stmt->bind_param("ii", $case_id, $user["id"]);
$stmt->execute();

$result = $stmt->get_result();

if (!$result->fetch_assoc()) {
    if ($user["role"] == 1) {
        http_response_code(404);
        echo json_encode([
            "success" => false,
            "message" => "Not found"
        ]);
        exit;
    }
}

// Insert message
$stmt = $conn->prepare("
    INSERT INTO case_messages (case_id, user_id, message)
    VALUES (?, ?, ?)
");

$stmt->bind_param("iis", $case_id, $user["id"], $msg);
$stmt->execute();

$message_id = $conn->insert_id;

echo json_encode([
    "success" => true,
    "message" => "Message sent",
    "data" => [
        "message_id" => $message_id
    ]
]);
?>