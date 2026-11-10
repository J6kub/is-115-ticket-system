<?php

require "../includes/dbconn.php";

$hash_id = $_GET["element"] ?? null;

if (!$hash_id) {
    http_response_code(400);
    exit("Missing hash ID");
}

$stmt = $conn->prepare("
    SELECT mime_type, file_data
    FROM case_message_overview_attachments
    WHERE hash_id = ?
    LIMIT 1
");

$stmt->bind_param("s", $hash_id);
$stmt->execute();

$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    http_response_code(404);
    exit("Attachment not found");
}

$allowedTypes = [
    "image/jpeg",
    "image/png",
    "image/gif",
    "image/webp"
];

$mime = strtolower(trim($data["mime_type"]));

if (!in_array($mime, $allowedTypes, true)) {
    http_response_code(415);
    exit("Preview not supported for this file type");
}

header("Content-Type: " . $mime);
header("Content-Length: " . strlen($data["file_data"]));
header("Content-Disposition: inline");
header("X-Content-Type-Options: nosniff");
header("Cache-Control: private, no-store");

echo $data["file_data"];
exit;
?>
