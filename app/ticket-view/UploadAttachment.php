<?php

session_start();
header('Content-Type: application/json');

require "../includes/dbconn.php";

$message_id = $_POST["message_id"] ?? null;

if (!$message_id) {
    http_response_code(400);

    echo json_encode([
        "success" => false,
        "message" => "Missing message ID"
    ]);

    exit;
}

if (!isset($_FILES["attachment"])) {
    http_response_code(400);

    echo json_encode([
        "success" => false,
        "message" => "No attachment uploaded"
    ]);

    exit;
}

$file = $_FILES["attachment"];

// Check upload error
if ($file["error"] !== UPLOAD_ERR_OK) {
    http_response_code(400);

    echo json_encode([
        "success" => false,
        "message" => "File upload failed"
    ]);

    exit;
}


// 16 MB limit
$maxSize = 16 * 1024 * 1024;

if ($file["size"] > $maxSize) {
    http_response_code(400);

    echo json_encode([
        "success" => false,
        "message" => "File is too large. Maximum size is 16 MB."
    ]);

    exit;
}


// Make sure the message actually exists
$stmt = $conn->prepare("
    SELECT id
    FROM case_message_overview
    WHERE id = ?
    LIMIT 1
");

$stmt->bind_param("i", $message_id);
$stmt->execute();

$result = $stmt->get_result();

if (!$result->fetch_assoc()) {
    http_response_code(404);

    echo json_encode([
        "success" => false,
        "message" => "Message not found"
    ]);

    exit;
}


// Get file information
$filename = $file["name"];
$fileSize = $file["size"];

$finfo = new finfo(FILEINFO_MIME_TYPE);
$mimeType = $finfo->file($file["tmp_name"]);

$fileData = file_get_contents($file["tmp_name"]);


// Insert attachment
$stmt = $conn->prepare("
    INSERT INTO message_attachments
        (message_id, filename, mime_type, file_size, file_data)
    VALUES
        (?, ?, ?, ?, ?)
");

$stmt->bind_param(
    "issib",
    $message_id,
    $filename,
    $mimeType,
    $fileSize,
    $null
);

$stmt->send_long_data(4, $fileData);

if (!$stmt->execute()) {
    http_response_code(500);

    echo json_encode([
        "success" => false,
        "message" => "Could not save attachment"
    ]);

    exit;
}
$atchId = $conn->insert_id;

$hash_id = hash("sha256", $atchId . "_" . $filename);

$stmt = $conn->prepare("
    UPDATE message_attachments
    SET hash_id = ?
    WHERE id = ?
");

$stmt->bind_param("si", $hash_id, $atchId);
$stmt->execute();

echo json_encode([
    "success" => true,
    "message" => "Attachment uploaded",
    "attachment_id" => $conn->insert_id
]);

?>