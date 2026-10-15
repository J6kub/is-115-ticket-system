<?php
session_start();

require "../includes/dbconn.php";
require "../includes/classes/user.php";

$loginSuccess = false;
$displayName = "";
$errorMessage = "We couldn't find an account with those login details.";

$email = $_POST["email"] ?? "";
$password = $_POST["password"] ?? "";

if ($email !== "" && $password !== "") {

    $pwdHash = hash("sha256", $password);

    $stmt = mysqli_prepare(
        $conn,
        "SELECT * FROM user
         WHERE email = ?
         AND password_hash = ?
         LIMIT 1"
    );

    mysqli_stmt_bind_param($stmt, "ss", $email, $pwdHash);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if ($result && $result->num_rows > 0) {

        $row = $result->fetch_assoc();

        $user = new User($row);
        $_SESSION["user"] = $user;

        $loginSuccess = true;

        // Use a username/name when available, otherwise fall back to email.
        $displayName =
            $row["username"]
            ?? $row["name"]
            ?? $row["full_name"]
            ?? $row["email"];

    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        <?= $loginSuccess ? "Welcome back!" : "Login failed" ?>
    </title>

    <link rel="stylesheet" href="../general-style.css">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;

            display: flex;
            justify-content: center;
            align-items: center;

            font-family: Arial, sans-serif;

            background:
                radial-gradient(circle at top left, #ffe4f2, transparent 35%),
                radial-gradient(circle at bottom right, #e8ddff, transparent 35%),
                #fff7fc;

            color: #4b3b47;
        }

        .login-card {
            width: min(520px, 90%);
            padding: 45px 40px;

            text-align: center;

            background: rgba(255, 255, 255, 0.92);
            border: 3px solid #ffd1e6;
            border-radius: 30px;

            box-shadow:
                0 20px 50px rgba(151, 91, 127, 0.15),
                0 5px 15px rgba(151, 91, 127, 0.08);

            animation: cardIn 0.6s ease;
        }

        .icon {
            width: 90px;
            height: 90px;

            margin: 0 auto 25px;

            display: flex;
            justify-content: center;
            align-items: center;

            border-radius: 50%;

            font-size: 48px;

            animation: pop 0.7s ease;
        }

        .success-icon {
            background: #ffe0ef;
            box-shadow: 0 8px 25px rgba(255, 130, 185, 0.25);
        }

        .error-icon {
            background: #ffe3e3;
            box-shadow: 0 8px 25px rgba(255, 100, 100, 0.18);
        }

        h1 {
            margin: 0 0 12px;

            font-size: 36px;
            font-weight: 800;

            color: #d75c98;
        }

        .error-title {
            color: #d85f5f;
        }

        .username {
            color: #a94378;
            font-weight: 800;
        }

        .message {
            margin: 0 auto 25px;

            max-width: 400px;

            font-size: 17px;
            line-height: 1.6;

            color: #766575;
        }

        .user-pill {
            display: inline-block;

            margin: 8px 0 22px;
            padding: 10px 18px;

            border-radius: 999px;

            background: #fff0f7;
            border: 2px solid #ffd2e7;

            color: #a94378;
            font-size: 14px;
            font-weight: 700;
        }

        .redirect-box {
            margin-top: 25px;
            padding: 15px;

            border-radius: 18px;

            background: #fff8fc;
            border: 2px dashed #f4bfd8;

            font-size: 14px;
            color: #927888;
        }

        #countdown {
            display: inline-block;

            min-width: 25px;

            color: #d75c98;
            font-weight: 800;
        }

        .home-button {
            display: inline-block;

            margin-top: 5px;
            padding: 12px 24px;

            border-radius: 999px;

            text-decoration: none;

            background: #e86ba8;
            color: white;

            font-weight: 700;

            box-shadow: 0 6px 15px rgba(232, 107, 168, 0.25);

            transition:
                transform 0.15s ease,
                box-shadow 0.15s ease;
        }

        .home-button:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 9px 20px rgba(232, 107, 168, 0.35);
        }

        .sparkles {
            position: fixed;

            top: 20px;
            left: 0;
            width: 100%;

            pointer-events: none;

            font-size: 22px;
            letter-spacing: 25px;

            opacity: 0.5;

            animation: floaty 4s ease-in-out infinite;
        }

        @keyframes cardIn {
            from {
                opacity: 0;
                transform: translateY(25px) scale(0.96);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes pop {
            0% {
                transform: scale(0);
            }

            70% {
                transform: scale(1.12);
            }

            100% {
                transform: scale(1);
            }
        }

        @keyframes floaty {
            0%, 100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(8px);
            }
        }
    </style>
</head>

<body>

    <div class="sparkles">
        ✦　♡　✧　♡　✦　♡　✧
    </div>

    <main class="login-card">

        <?php if ($loginSuccess): ?>

            <div class="icon success-icon">
                🪿
            </div>

            <h1>
                Welcome back,
                <span class="username">
                    <?= htmlspecialchars($displayName) ?>
                </span>!
            </h1>

            <p class="message">
                You're all logged in and ready to go.  
                The goose has approved your entrance. 💕
            </p>

            <div class="user-pill">
                ✉ <?= htmlspecialchars($email) ?>
            </div>

            <div class="redirect-box">
                Taking you to the main page in
                <span id="countdown">4</span>
                seconds... ✨
            </div>

        <?php else: ?>

            <div class="icon error-icon">
                🥺
            </div>

            <h1 class="error-title">
                Oh no!
            </h1>

            <p class="message">
                <?= htmlspecialchars($errorMessage) ?>
                <br>
                Please check your email and password and try again.
            </p>

            <a class="home-button" href="../login-page">
                💗 Try again
            </a>

        <?php endif; ?>

    </main>

    <?php if ($loginSuccess): ?>

        <script src="../reusables/redirect.js"></script>

        <script>
            const countdown = document.getElementById("countdown");

            let seconds = 4;

            const timer = setInterval(() => {
                seconds--;

                if (countdown) {
                    countdown.textContent = seconds;
                }

                if (seconds <= 0) {
                    clearInterval(timer);
                }
            }, 1000);

            ToMainTimeout(4, countdown);
        </script>

    <?php endif; ?>

</body>
</html>
