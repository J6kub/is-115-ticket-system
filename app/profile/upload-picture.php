<?php
require_once "../includes/classes/user.php";
session_start();

if (!isset($_SESSION["user"])) {
    header("Location: ../login-page/index.php");
    exit();
}

function showImageError($message) {
    $_SESSION["profile_error"] = $message;
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: index.php");
    exit();
}

$token = "";
if (isset($_POST["token"]) && is_string($_POST["token"])) {
    $token = $_POST["token"];
}
if (!isset($_SESSION["profile_token"]) || !hash_equals($_SESSION["profile_token"], $token)) {
    showImageError("Reload your profile page and try again.");
}

if (!isset($_FILES["profile_image"]) || is_array($_FILES["profile_image"]["error"])) {
    showImageError("Choose an image first.");
}

$file = $_FILES["profile_image"];
if ($file["error"] != UPLOAD_ERR_OK) {
    showImageError("Could not upload the image. The maximum size is 2 MB.");
}

if ($file["size"] > 2 * 1024 * 1024) {
    showImageError("The image is too large. The maximum size is 2 MB.");
}

$imageInfo = @getimagesize($file["tmp_name"]);
if (!$imageInfo) {
    showImageError("The file is not a valid image.");
}

$fileType = $imageInfo["mime"];
if ($fileType != "image/jpeg" && $fileType != "image/png" && $fileType != "image/webp") {
    showImageError("Choose a valid JPG, PNG or WebP image.");
}

require_once "../includes/dbconn.php";
mysqli_report(MYSQLI_REPORT_OFF);

$imageData = file_get_contents($file["tmp_name"]);
if ($imageData === false) {
    showImageError("Could not read the image. Try again.");
}

$userId = $_SESSION["user"]->id;
$sql = "UPDATE user SET profile_image_data = ?, profile_image_type = ? WHERE ID = ?";
$statement = mysqli_prepare($conn, $sql);
if (!$statement) {
    showImageError("Could not update your profile picture. Try again.");
}

mysqli_stmt_bind_param($statement, "ssi", $imageData, $fileType, $userId);
if (!mysqli_stmt_execute($statement)) {
    showImageError("Could not update your profile picture. Try again.");
}
mysqli_stmt_close($statement);

$_SESSION["user"]->profile_image = true;
$_SESSION["profile_message"] = "Your profile picture has been updated.";
header("Location: index.php");
exit();
