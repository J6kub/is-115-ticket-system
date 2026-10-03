<?php

require "../includes/dbconn.php";

$hash_id = $_GET["element"] ?? null;

if (!$hash_id) {
    http_response_code(400);
    exit("Missing hash ID");
}

$stmt = $conn->prepare("
    SELECT
        filename,
        mime_type,
        file_size,
        file_data
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

// Tell the browser what this file is
header("Content-Type: " . $data["mime_type"]);
header("Content-Length: " . $data["file_size"]);

// Force download
header(
    'Content-Disposition: attachment; filename="' .
    basename($data["filename"]) . '"'
);

// Send the actual BLOB
echo $data["file_data"];
exit;
?>