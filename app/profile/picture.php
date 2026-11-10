<?php
require_once "../includes/classes/user.php";
session_start();
function passDefaultImg() {
    $fn = "../images/user.png";
    $fp = fopen($fn, "rb");
    header("Content-Type: image/png");
    header("Content-Length: " . filesize($fn));

    // dump the picture and stop the script
    fpassthru($fp);
    exit;
}
if (!isset($_SESSION["user"])) {
    passDefaultImg();

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
    passDefaultImg();
}

header("Content-Type: " . $bilde["profile_image_type"]);
header("Cache-Control: private, no-store");
header("X-Content-Type-Options: nosniff");
echo $bilde["profile_image_data"];
