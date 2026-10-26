<?php
require_once "../includes/classes/user.php";
session_start();

if (!isset($_SESSION["user"])) {
    header("Location: ../login-page/index.php");
    exit();
}

function visBildefeil($melding) {
    $_SESSION["profile_error"] = $melding;
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
    visBildefeil("Last profilsiden på nytt og prøv igjen.");
}

if (!isset($_FILES["profile_image"]) || is_array($_FILES["profile_image"]["error"])) {
    visBildefeil("Velg et bilde først.");
}

$fil = $_FILES["profile_image"];
if ($fil["error"] != UPLOAD_ERR_OK) {
    visBildefeil("Bildet kunne ikke lastes opp. Maks størrelse er 2 MB.");
}

if ($fil["size"] > 2 * 1024 * 1024) {
    visBildefeil("Bildet er for stort. Maks størrelse er 2 MB.");
}

$bildeinfo = @getimagesize($fil["tmp_name"]);
if (!$bildeinfo) {
    visBildefeil("Filen er ikke et gyldig bilde.");
}

$filtype = $bildeinfo["mime"];
if ($filtype != "image/jpeg" && $filtype != "image/png" && $filtype != "image/webp") {
    visBildefeil("Velg et gyldig JPG-, PNG- eller WebP-bilde.");
}

require_once "../includes/dbconn.php";
mysqli_report(MYSQLI_REPORT_OFF);

$bildedata = file_get_contents($fil["tmp_name"]);
if ($bildedata === false) {
    visBildefeil("Kunne ikke lese bildet. Prøv igjen.");
}

$bruker_id = $_SESSION["user"]->id;
$sql = "UPDATE user SET profile_image_data = ?, profile_image_type = ? WHERE ID = ?";
$sporring = mysqli_prepare($conn, $sql);
if (!$sporring) {
    visBildefeil("Kunne ikke oppdatere profilbildet. Prøv igjen.");
}

mysqli_stmt_bind_param($sporring, "ssi", $bildedata, $filtype, $bruker_id);
if (!mysqli_stmt_execute($sporring)) {
    visBildefeil("Kunne ikke oppdatere profilbildet. Prøv igjen.");
}
mysqli_stmt_close($sporring);

$_SESSION["user"]->profile_image = true;
$_SESSION["profile_message"] = "Profilbildet er oppdatert.";
header("Location: index.php");
exit();
