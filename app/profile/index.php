<?php   
require_once "../includes/classes/user.php";
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: ../login-page/index.php");
    exit();
}

require_once "../includes/dbconn.php";
mysqli_report(MYSQLI_REPORT_OFF);

function getFormField($field) {
    if (isset($_POST[$field]) && is_string($_POST[$field])) {
        return trim($_POST[$field]);
    }
    return "";
}

$userId = $_SESSION["user"]->id;
$sql = "SELECT ID, First_name, Last_name, user_type_id, email, (profile_image_data IS NOT NULL) AS has_profile_image FROM user WHERE ID = ?";
$query = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($query, "i", $userId);
mysqli_stmt_execute($query);
$result = mysqli_stmt_get_result($query);
$userData = mysqli_fetch_assoc($result);
mysqli_stmt_close($query);

if (!$userData) {
    unset($_SESSION["user"]);
    header("Location: ../login-page/index.php");
    exit();
}

$user = new User($userData);
$_SESSION["user"] = $user;

$editing = isset($_GET["edit"]);
$error = "";
$message = "";

if (isset($_SESSION["profile_error"])) {
    $error = $_SESSION["profile_error"];
    unset($_SESSION["profile_error"]);
}

if (isset($_SESSION["profile_message"])) {
    $message = $_SESSION["profile_message"];
    unset($_SESSION["profile_message"]);
}

if (!isset($_SESSION["profile_token"])) {
    $_SESSION["profile_token"] = bin2hex(random_bytes(32));
}

$firstName = $user->first_name;
$lastName = $user->last_name;
$email = $user->email;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $editing = true;
    $firstName = getFormField("first_name");
    $lastName = getFormField("last_name");
    $email = getFormField("email");
    $token = getFormField("token");

    if (!hash_equals($_SESSION["profile_token"], $token)) {
        $error = "Invalid form. Reload the page and try again.";
    } elseif ($firstName == "" || $lastName == "" || $email == "") {
        $error = "Fill in all fields.";
    } elseif (strlen($firstName) > 255 || strlen($lastName) > 255 || strlen($email) > 255) {
        $error = "Fields cannot be longer than 255 characters.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Enter a valid email address.";
    } else {
        $sql = "UPDATE user SET First_name = ?, Last_name = ?, email = ? WHERE ID = ?";
        $query = mysqli_prepare($conn, $sql);
        $saved = false;
        if ($query) {
            mysqli_stmt_bind_param($query, "sssi", $firstName, $lastName, $email, $userId);
            $saved = mysqli_stmt_execute($query);
            if (mysqli_stmt_errno($query) == 1062) {
                $error = "This email address is already in use.";
            }
            mysqli_stmt_close($query);
        }

        if (!$saved && $error == "") {
            $error = "Could not save your profile. Try again.";
        }

        if ($saved) {
            $user->first_name = $firstName;
            $user->last_name = $lastName;
            $user->email = $email;
            $_SESSION["user"] = $user;
            $_SESSION["profile_message"] = "Profile updated.";
            header("Location: index.php");
            exit();
        }
    }
}

$roleName = "Unknown role";
if ($user->role == 1) {
    $roleName = "User";
} elseif ($user->role == 2) {
    $roleName = "Administrator";
} elseif ($user->role == 3) {
    $roleName = "Employee";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My profile</title>
    <link rel="stylesheet" href="../general-style.css">
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <?php include "../includes/header.php"; ?>
    <?php include "../includes/nav.php"; ?>

    <main>
        <section class="profile-container">

            <h1>My profile</h1>

            <?php if ($message != ""): ?>
                <p class="profile-message" role="status"><?= htmlspecialchars($message, ENT_QUOTES, "UTF-8") ?></p>
            <?php endif; ?>

            <?php if ($error != ""): ?>
                <p class="profile-error" role="alert"><?= htmlspecialchars($error, ENT_QUOTES, "UTF-8") ?></p>
            <?php endif; ?>

            <div class="profile-picture">
                <?php if ($user->profile_image): ?>
                    <img src="picture.php" alt="Your profile picture">
                <?php else: ?>
                    <div class="profile-placeholder" role="img" aria-label="Default profile picture">👤</div>
                <?php endif; ?>
                <?php if ($editing): ?>
                <form action="upload-picture.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="token" value="<?= htmlspecialchars($_SESSION["profile_token"], ENT_QUOTES, "UTF-8") ?>">
                    <label for="profile_image">Choose a new profile picture</label>
                    <input type="file" id="profile_image" name="profile_image" accept="image/jpeg,image/png,image/webp" required>
                    <small>JPG, PNG or WebP. Max 2 MB.</small>
                    <button type="submit">Save profile picture</button>
                </form>
                <?php endif; ?>
            </div>

            <div class="profile-info">
                <h2>Personal information</h2>

                <?php if ($editing): ?>
                    <form action="index.php" method="post">
                        <input type="hidden" name="token" value="<?= htmlspecialchars($_SESSION["profile_token"], ENT_QUOTES, "UTF-8") ?>">

                        <label for="first_name">First name</label>
                        <input type="text" id="first_name" name="first_name" value="<?= htmlspecialchars($firstName, ENT_QUOTES, "UTF-8") ?>" maxlength="255" autocomplete="given-name" required>

                        <label for="last_name">Last name</label>
                        <input type="text" id="last_name" name="last_name" value="<?= htmlspecialchars($lastName, ENT_QUOTES, "UTF-8") ?>" maxlength="255" autocomplete="family-name" required>

                        <label for="email">Email address</label>
                        <input type="email" id="email" name="email" value="<?= htmlspecialchars($email, ENT_QUOTES, "UTF-8") ?>" maxlength="255" autocomplete="email" required>

                        <div class="profile-actions">
                            <a href="index.php">Cancel</a>
                            <button type="submit">Save changes</button>
                        </div>
                    </form>
                <?php else: ?>
                <div class="info-field">
                    <label>First name</label>
                    <p><?= htmlspecialchars($user->first_name, ENT_QUOTES, "UTF-8") ?></p>
                </div>

                <div class="info-field">
                    <label>Last name</label>
                    <p><?= htmlspecialchars($user->last_name, ENT_QUOTES, "UTF-8") ?></p>
                </div>

                <div class="info-field">
                    <label>Email address</label>
                    <p><?= htmlspecialchars($user->email, ENT_QUOTES, "UTF-8") ?></p>
                </div>
                <?php endif; ?>

                <div class="info-field">
                    <label>User role</label>
                    <p><?= htmlspecialchars($roleName, ENT_QUOTES, "UTF-8") ?></p>
                </div>
            </div>

            <?php if (!$editing): ?>
                <form action="index.php" method="get" class="profile-actions">
                    <button type="submit" name="edit" value="1">Edit profile</button>
                </form>
            <?php endif; ?>

        </section>
    </main>

    <?php include "../includes/footer.php"; ?>
</body>
</html>
