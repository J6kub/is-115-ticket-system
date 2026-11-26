
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
unset($_SESSION["user"]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logged Out ♡</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #fff4f6;
            font-family: 'Segoe UI', sans-serif;
            color: #59434b;
        }

        .container {
            background: white;
            padding: 50px 40px;
            border-radius: 25px;
            text-align: center;
            width: 90%;
            max-width: 420px;
            box-shadow: 0 10px 40px rgba(190, 120, 140, 0.12);
        }

        .emoji {
            font-size: 65px;
            margin-bottom: 20px;
            animation: wave 2s infinite ease-in-out;
            display: inline-block;
        }

        @keyframes wave {
            0%, 100% { transform: rotate(0deg); }
            25% { transform: rotate(15deg); }
            75% { transform: rotate(-10deg); }
        }

        h1 {
            font-size: 28px;
            margin-bottom: 12px;
            color: #d47b96;
        }

        p {
            font-size: 15px;
            line-height: 1.7;
            color: #88757c;
            margin-bottom: 25px;
        }

        .button {
            display: inline-block;
            background: #e99bb1;
            color: white;
            text-decoration: none;
            padding: 13px 30px;
            border-radius: 30px;
            font-weight: 600;
            transition: 0.2s;
        }

        .button:hover {
            background: #d47b96;
            transform: translateY(-2px);
        }

        .redirect {
            margin-top: 20px;
            font-size: 12px;
            color: #b5a3aa;
        }
        .banner {
            width: calc(100% + 80px);
            height: auto;
            max-height: 180px;
            object-fit: contain;
            display: block;
            margin: 0 -40px 25px -40px;
            border-radius: 15px;
        }
    </style>
    
</head>
<body>

    <div class="container">
        <div class="emoji">👋</div>
        <img src="../images/supportgoose2.png" alt="SupportGoose banner" class="banner">
        <h1>See you later!</h1>

        <p>
            You've been successfully logged out.<br>
            Thank you for stopping by!<br>
            We hope to see you again soon ♡
        </p>

        <a href="../main-page/" class="button">
            Back to home
        </a>

        <div class="redirect">
            Redirecting you in <span id="countdown">3</span> seconds...
        </div>
    </div>

    <script>
        let seconds = 3;

        const countdown = setInterval(() => {
            seconds--;
            document.getElementById("countdown").textContent = seconds;

            if (seconds <= 0) {
                clearInterval(countdown);
                window.location.href = "../main-page/";
            }
        }, 1000);
    </script>

</body>
</html>
