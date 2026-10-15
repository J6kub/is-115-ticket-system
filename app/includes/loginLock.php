<?php
$LoginLockActive = true;
function LoginLock($userType = "none") {
    
    switch (strtolower($userType)) {
        case "user":
            $userType = 1;
        case "admin":
            $userType = 2;
        case "employee":
            $userType = 3;
        
    }

    global $LoginLockActive;
    if (!$LoginLockActive) {
        return;
    }

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION["user"])) {
        header("Location: ./login-page");
        exit;
    }

    if ($userType !== "none" && strtolower(get_object_vars($_SESSION["user"])["role"]) !== strtolower($userType)) {
        
        header("Location: ../login-page");
        exit;
    }
}

?>