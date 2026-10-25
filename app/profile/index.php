<?php   
include "../includes/classes/user.php";
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: ../login-page/index.php");
    exit();
}

$user = $_SESSION["user"];
$roles = [
    1 => "Bruker",
    2 => "Administrator",
    3 => "Ansatt"
];

$roleName = $roles[$user->role] ?? "Ukjent rolle";
?>
<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Min profil</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>

    <main>
        <section class="profile-container">

            <h1>Min profil</h1>

            <div class="profile-picture">
                <img src="../images/default-profile.png" alt="Profilbilde">
                <button type="button">Endre profilbilde</button>
            </div>

            <div class="profile-info">
                <h2>Personlig informasjon</h2>

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

                <div class="info-field">
                    <label>Brukerrolle</label>
                    <p><?= htmlspecialchars($roleName, ENT_QUOTES, "UTF-8") ?></p>
                </div>
            </div>

            <div class="profile-actions">
                <button type="button">Rediger profil</button>
            </div>

        </section>
    </main>

</body>
</html>
