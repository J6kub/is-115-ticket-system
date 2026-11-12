
<?php

session_start();
header('Content-Type: application/json');

require "../includes/dbconn.php";

// Helper for JSON responses
function respond($code, $success, $message, $data = null) {
    http_response_code($code);

    echo json_encode([
        "success" => $success,
        "message" => $message,
        "data" => $data
    ]);

    exit;
}

// Check authentication
if (!isset($_SESSION["user"])) {
    respond(401, false, "Not authenticated");
}

$user = get_object_vars($_SESSION["user"]);

$data = json_decode(file_get_contents("php://input"), true);

if (!is_array($data)) {
    respond(400, false, "Invalid JSON");
}

$msg = trim($data["msg"] ?? "");
$case_id = $data["case_id"] ?? null;
$status = $data["status"] ?? null;

// Validate input
if ($msg === "" || !filter_var($case_id, FILTER_VALIDATE_INT)) {
    respond(400, false, "Missing or invalid parameters");
}

if (!filter_var($status, FILTER_VALIDATE_INT)) {
    respond(400, false, "Invalid status");
}

// Check case access
if ($user["role"] == 1) {

    $stmt = $conn->prepare("
        SELECT id
        FROM cases
        WHERE id = ? AND user_id = ?
        LIMIT 1
    ");

    $stmt->bind_param("ii", $case_id, $user["id"]);
    $stmt->execute();

    if (!$stmt->get_result()->fetch_assoc()) {
        respond(404, false, "Not found");
    }

    $stmt->close();
}

// Insert message
$stmt = $conn->prepare("
    INSERT INTO case_messages (case_id, user_id, message, status_id)
    VALUES (?, ?, ?, ?)
");

$stmt->bind_param("iisi", $case_id, $user["id"], $msg, $status);

if (!$stmt->execute()) {
    respond(500, false, "Failed to send message");
}

$message_id = $conn->insert_id;

respond(200, true, "Message sent", [
    "message_id" => $message_id
]);

?>
