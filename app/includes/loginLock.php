
<?php
require_once __DIR__ . "/classes/user.php";

$LoginLockActive = true;

function UserTypeTransl8($userType) {
    switch (strtolower($userType)) {
        case "user":
            return 1;
        case "admin":
            return 2;
        case "employee":
            return 3;
        default:
            return $userType;
    }
}

function LoginLock($userType = "none") {
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

    // Normalize to array
    if (!is_array($userType)) {
        $userType = [$userType];
    }

    // Translate all allowed roles
    $allowedRoles = array_map('UserTypeTransl8', $userType);

    // "none" means any authenticated user
    if (in_array("none", $userType, true)) {
        return;
    }

    // Check if user's role is allowed
    if (!in_array($_SESSION["user"]->role, $allowedRoles)) {
        header("Location: ../login-page");
        exit;
    }
}
?>
