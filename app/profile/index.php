<?php   
include "../includes/classes/user.php";
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: ../login-page/index.php");
    exit();
}

$user = $_SESSION["user"];
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
                    <p><?php echo $user->first_name; ?></p>
                </div>

                <div class="info-field">
                    <label>Etternavn</label>
                    <p><?php echo $user->last_name; ?></p>
                </div>

                <div class="info-field">
                    <label>E-postadresse</label>
                    <p><?php echo $user->email; ?></p>
                </div>

                <div class="info-field">
                    <label>Brukerrolle</label>
                    <p><?php echo $user->role; ?></p>
                </div>
            </div>

            <div class="profile-actions">
                <button type="button">Rediger profil</button>
            </div>

        </section>
    </main>

</body>
</html>
