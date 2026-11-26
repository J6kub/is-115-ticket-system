<?php 
require "../includes/loginLock.php";
LoginLock();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My profile</title>
    <link rel="stylesheet" href="../general-style.css">
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="pwd.css">
</head>
<body>
    <?php include "../includes/header.php"; ?>
    <?php include "../includes/nav.php"; ?>

<?php
    // Boksen under input som viser brukeren hva har skjedd, suksess feil osv
    $WHATTOSAYBACKTOUSER = "";
    require "../includes/dbconn.php";
    function validatePassword($password) {
        return (
            strlen($password) >= 8 &&
            preg_match('/[A-Z]/', $password) &&
            preg_match('/[!@#$%^&*()_\-+=\[\]{};:,.?\/\\|]/', $password)
        );
    }

    function return_box($content, $color = "#842029") {
        return '<div class="return-box" style="background-color:' . $color . '">' . $content . '</div>';
    }
    // sql for update pwd
    function updatePwd($user_id, $old_pwd_hash, $new_pwd_hash, $conn) {

        $sql = "UPDATE user SET password_hash = ? WHERE password_hash = ? AND ID = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $new_pwd_hash, $old_pwd_hash, $user_id);

        if ($stmt->execute()) {
            return True;
        } else {
            return False;
        }
    }
    // input grabber
    $oldPwd = $_POST["oldPwd"] ?? null;
    $newPwd = $_POST["newPwd"] ?? null;
    $newPwdConf = $_POST["newPwdConf"] ?? null;
    $user_info = get_object_vars($_SESSION["user"]);
    if (!isset($oldPwd) && !isset($newPwd) && !isset($newPwdConf)) {
        $WHATTOSAYBACKTOUSER = "";
    } else if (!isset($oldPwd) || !isset($newPwd) || !isset($newPwdConf)) {
        $WHATTOSAYBACKTOUSER = return_box("<strong>Error: </strong> Missing input");
    } else {
        // Sjekk om bruker faktisk finnes og har skrevet riktig passord
        require "../includes/dbconn.php";
        $oldPwdHash = hash("sha256",$oldPwd);
        $newPwdHash = hash("sha256",$newPwd);
        $newPwdConfHash = hash("sha256",$newPwdConf);
        $sql = "Select * from user WHERE password_hash = '" . $oldPwdHash . "' AND ID = '" . $user_info["id"] . "'";

        $res = $conn->query($sql);
        if ($res && $res->fetch_assoc()) { // Old Password is right !! Go to checks
            if ($newPwdHash == $oldPwdHash) { // Same password error, no Update!!! Throw fail
                $WHATTOSAYBACKTOUSER = return_box("<strong>Error! </strong> Your new password can't be the same as the old one! ","red");
            } else if (validatePassword($newPwd) === FALSE) {
                $WHATTOSAYBACKTOUSER = return_box("<strong>Password requirements:</strong> At least 8 characters, at least one uppercase letter, and at least one special character (&%/*). ");
            } else if (($newPwdConfHash === $newPwdHash) && ($newPwdConf === $newPwd)) { // Everything good, update password
            if (updatePwd(
                    $user_info["id"], 
                    $oldPwdHash,
                    $newPwdHash, $conn
                )) {
                //$bruh = "<br>newPwd: " . $newPwdHash . "<br>new pwd conf: " . $newPwdConfHash;
                $WHATTOSAYBACKTOUSER = return_box("<strong>Success! </strong> Password changed", "green");
            } else {
                $WHATTOSAYBACKTOUSER = return_box("<strong>Error: </strong> This was never meant to happen, sorry UwU"); 
            }
                
                
            } else {
                $WHATTOSAYBACKTOUSER = return_box("<strong>Error: </strong> new passwords dont match");
            }
            
        } else { // Old password is Wrong
            $WHATTOSAYBACKTOUSER = return_box("<strong>Error: </strong> You may have gracefully misspelled your password","red");
        }
    }
    //echo "<h1>UserId: " . $user_info["id"] . "</h1>"
?>


    <main>
        <section class="profile-container">
    <h2 style="text-align:center"> Change password</h2>
    <a href="."><button style='position:relative;top:-2.5em;'>Back</button></a>
<form method="POST">
    <p>Old password:</p>
    <div class="password-wrapper">
        <input type="password" class='unhidable' name="oldPwd" required>
        <span class="toggle-password" onclick="">👁</span>
    </div>

    <p>New password:</p>
    <div class="password-wrapper">
        <input type="password" class='unhidable' name="newPwd" required>
        <span class="toggle-password" onclick="">👁</span>
    </div>

    <p>Confirm new password:</p>
    <div class="password-wrapper">
        <input type="password" class='unhidable' name="newPwdConf" required>
        <span class="toggle-password" onclick="">👁</span>
    </div>

    <input type="submit" value="Change Password">
</form>
    <?php 
    
    echo $WHATTOSAYBACKTOUSER; 
    ?>

</section>

</main>

<?php include "../includes/footer.php"; ?>
</body>

<script src="pwd.js"></script>
