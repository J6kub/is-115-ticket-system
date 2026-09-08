<?php
$LoginLockActive = false;
function LoginLock($userType = "none") {
    global $LoginLockActive;
    if (!$LoginLockActive) {
        return;
    }

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION["user"])) {
        header("Location: /app/login-page");
        exit;
    }

    if ($userType !== "none" && strtolower(get_object_vars($_SESSION["user"])["role"]) !== strtolower($userType)) {
        
        header("Location: /app/login-page");
        exit;
    }
}

?>