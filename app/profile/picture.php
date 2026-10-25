<?php
require_once "../includes/classes/user.php";
session_start();

if (!isset($_SESSION["user"])) {
    http_response_code(401);
    exit();
}

$bruker_id = $_SESSION["user"]->id;
require_once "../includes/dbconn.php";

$sql = "SELECT profile_image_data, profile_image_type FROM user WHERE ID = ?";
$sporring = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($sporring, "i", $bruker_id);
mysqli_stmt_execute($sporring);
$resultat = mysqli_stmt_get_result($sporring);
$bilde = mysqli_fetch_assoc($resultat);
mysqli_stmt_close($sporring);

if (empty($bilde["profile_image_data"])) {
    http_response_code(404);
    exit();
}

header("Content-Type: " . $bilde["profile_image_type"]);
header("Cache-Control: private, no-store");
header("X-Content-Type-Options: nosniff");
echo $bilde["profile_image_data"];
