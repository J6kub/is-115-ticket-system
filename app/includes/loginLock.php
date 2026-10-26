<?php
require_once __DIR__ . "/classes/user.php";
$LoginLockActive = true;
function LoginLock($userType = "none") {
    
    switch (strtolower($userType)) {
        case "user":
            $userType = 1;
            break;
        case "admin":
            $userType = 2;
            break;
        case "employee":
            $userType = 3;
            break;
        
    }

    global $LoginLockActive;
    if (!$LoginLockActive) {
        return;
    }

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION["user"])) {
        header("Location: ../login-page/index.php");
        exit;
    }

    if ($userType !== "none" && $_SESSION["user"]->role != $userType) {
        
        header("Location: ../login-page");
        exit;
    }
}

?>
