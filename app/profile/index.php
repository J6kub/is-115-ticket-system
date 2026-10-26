<?php   
require_once "../includes/classes/user.php";
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: ../login-page/index.php");
    exit();
}

require_once "../includes/dbconn.php";
mysqli_report(MYSQLI_REPORT_OFF);

function hentSkjemafelt($feltnavn) {
    if (isset($_POST[$feltnavn]) && is_string($_POST[$feltnavn])) {
        return trim($_POST[$feltnavn]);
    }
    return "";
}

$bruker_id = $_SESSION["user"]->id;
$sql = "SELECT ID, First_name, Last_name, user_type_id, email, (profile_image_data IS NOT NULL) AS has_profile_image FROM user WHERE ID = ?";
$sporring = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($sporring, "i", $bruker_id);
mysqli_stmt_execute($sporring);
$resultat = mysqli_stmt_get_result($sporring);
$brukerdata = mysqli_fetch_assoc($resultat);
mysqli_stmt_close($sporring);

if (!$brukerdata) {
    unset($_SESSION["user"]);
    header("Location: ../login-page/index.php");
    exit();
}

$user = new User($brukerdata);
$_SESSION["user"] = $user;

$rediger = isset($_GET["edit"]);
$feil = "";
$melding = "";
if (isset($_SESSION["profile_error"])) {
    $feil = $_SESSION["profile_error"];
    unset($_SESSION["profile_error"]);
}
if (isset($_SESSION["profile_message"])) {
    $melding = $_SESSION["profile_message"];
    unset($_SESSION["profile_message"]);
}

if (!isset($_SESSION["profile_token"])) {
    $_SESSION["profile_token"] = bin2hex(random_bytes(32));
}

$fornavn = $user->first_name;
$etternavn = $user->last_name;
$email = $user->email;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rediger = true;
    $fornavn = hentSkjemafelt("first_name");
    $etternavn = hentSkjemafelt("last_name");
    $email = hentSkjemafelt("email");
    $token = hentSkjemafelt("token");

    if (!hash_equals($_SESSION["profile_token"], $token)) {
        $feil = "Skjemaet er ugyldig. Last siden på nytt og prøv igjen.";
    } elseif ($fornavn == "" || $etternavn == "" || $email == "") {
        $feil = "Fyll ut alle feltene.";
    } elseif (strlen($fornavn) > 255 || strlen($etternavn) > 255 || strlen($email) > 255) {
        $feil = "Feltene kan ikke være lengre enn 255 tegn.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $feil = "Skriv inn en gyldig e-postadresse.";
    } else {
        $sql = "UPDATE user SET First_name = ?, Last_name = ?, email = ? WHERE ID = ?";
        $sporring = mysqli_prepare($conn, $sql);
        $lagret = false;
        if ($sporring) {
            mysqli_stmt_bind_param($sporring, "sssi", $fornavn, $etternavn, $email, $bruker_id);
            $lagret = mysqli_stmt_execute($sporring);
            if (mysqli_stmt_errno($sporring) == 1062) {
                $feil = "E-postadressen er allerede i bruk.";
            }
            mysqli_stmt_close($sporring);
        }

        if (!$lagret && $feil == "") {
            $feil = "Kunne ikke lagre profilen. Prøv igjen.";
        }

        if ($lagret) {
            $user->first_name = $fornavn;
            $user->last_name = $etternavn;
            $user->email = $email;
            $_SESSION["user"] = $user;
            $_SESSION["profile_message"] = "Profilen er oppdatert.";
            header("Location: index.php");
            exit();
        }
    }
}

$rollenavn = "Ukjent rolle";
if ($user->role == 1) {
    $rollenavn = "Bruker";
} elseif ($user->role == 2) {
    $rollenavn = "Administrator";
} elseif ($user->role == 3) {
    $rollenavn = "Ansatt";
}
?>
<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Min profil</title>
    <link rel="stylesheet" href="../general-style.css">
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <?php include "../includes/header.php"; ?>
    <?php include "../includes/nav.php"; ?>

    <main>
        <section class="profile-container">

            <h1>Min profil</h1>

            <?php if ($melding != ""): ?>
                <p class="profile-message" role="status"><?= htmlspecialchars($melding, ENT_QUOTES, "UTF-8") ?></p>
            <?php endif; ?>

            <?php if ($feil != ""): ?>
                <p class="profile-error" role="alert"><?= htmlspecialchars($feil, ENT_QUOTES, "UTF-8") ?></p>
            <?php endif; ?>

            <div class="profile-picture">
                <?php if ($user->profile_image): ?>
                    <img src="picture.php" alt="Profilbildet ditt">
                <?php else: ?>
                    <div class="profile-placeholder" role="img" aria-label="Standard profilbilde">👤</div>
                <?php endif; ?>
                <?php if ($rediger): ?>
                <form action="upload-picture.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="token" value="<?= htmlspecialchars($_SESSION["profile_token"], ENT_QUOTES, "UTF-8") ?>">
                    <label for="profile_image">Velg nytt profilbilde</label>
                    <input type="file" id="profile_image" name="profile_image" accept="image/jpeg,image/png,image/webp" required>
                    <small>JPG, PNG eller WebP. Maks 2 MB.</small>
                    <button type="submit">Lagre profilbilde</button>
                </form>
                <?php endif; ?>
            </div>

            <div class="profile-info">
                <h2>Personlig informasjon</h2>

                <?php if ($rediger): ?>
                    <form action="index.php" method="post">
                        <input type="hidden" name="token" value="<?= htmlspecialchars($_SESSION["profile_token"], ENT_QUOTES, "UTF-8") ?>">

                        <label for="first_name">Fornavn</label>
                        <input type="text" id="first_name" name="first_name" value="<?= htmlspecialchars($fornavn, ENT_QUOTES, "UTF-8") ?>" maxlength="255" autocomplete="given-name" required>

                        <label for="last_name">Etternavn</label>
                        <input type="text" id="last_name" name="last_name" value="<?= htmlspecialchars($etternavn, ENT_QUOTES, "UTF-8") ?>" maxlength="255" autocomplete="family-name" required>

                        <label for="email">E-postadresse</label>
                        <input type="email" id="email" name="email" value="<?= htmlspecialchars($email, ENT_QUOTES, "UTF-8") ?>" maxlength="255" autocomplete="email" required>

                        <div class="profile-actions">
                            <a href="index.php">Avbryt</a>
                            <button type="submit">Lagre endringer</button>
                        </div>
                    </form>
                <?php else: ?>
                <div class="info-field">
                    <label>Fornavn</label>
                    <p><?= htmlspecialchars($user->first_name, ENT_QUOTES, "UTF-8") ?></p>
                </div>

                <div class="info-field">
                    <label>Etternavn</label>
                    <p><?= htmlspecialchars($user->last_name, ENT_QUOTES, "UTF-8") ?></p>
                </div>

                <div class="info-field">
                    <label>E-postadresse</label>
                    <p><?= htmlspecialchars($user->email, ENT_QUOTES, "UTF-8") ?></p>
                </div>
                <?php endif; ?>

                <div class="info-field">
                    <label>Brukerrolle</label>
                    <p><?= htmlspecialchars($rollenavn, ENT_QUOTES, "UTF-8") ?></p>
                </div>
            </div>

            <?php if (!$rediger): ?>
                <form action="index.php" method="get" class="profile-actions">
                    <button type="submit" name="edit" value="1">Rediger profil</button>
                </form>
            <?php endif; ?>

        </section>
    </main>

    <?php include "../includes/footer.php"; ?>
</body>
</html>
