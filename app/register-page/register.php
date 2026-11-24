
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Registration complete!</title>

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

        .register-card {
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

            background: #ffe0ef;
            box-shadow: 0 8px 25px rgba(255, 130, 185, 0.25);

            animation: pop 0.7s ease;
        }

        h1 {
            margin: 0 0 12px;

            font-size: 36px;
            font-weight: 800;

            color: #d75c98;
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

        .redirect-box {
            margin-top: 25px;
            padding: 15px;

            border-radius: 18px;

            background: #fff8fc;
            border: 2px dashed #f4bfd8;

            font-size: 14px;
            color: #927888;
        }

        #h1 {
            display: inline-block;
            min-width: 25px;

            color: #d75c98;
            font-weight: 800;
        }

        .sparkles {
            position: fixed;

            top: 20px;
            left: 0;
            width: 100%;

            text-align: center;
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
            0% { transform: scale(0); }
            70% { transform: scale(1.12); }
            100% { transform: scale(1); }
        }

        @keyframes floaty {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(8px); }
        }
    </style>
</head>

<body>

    <div class="sparkles">
        ✦　♡　✧　♡　✦　♡　✧
    </div>

    <main class="register-card">

        <div class="icon">
            🪿
        </div>

        <h1>
            You're in! 💕
        </h1>

        <p class="message">
            Your account has been created successfully!
            <br><br>
            Welcome aboard! The goose is happy to have you here. ✨
        </p>

        <div class="redirect-box">
            Redirecting you in
            <span id="h1">4</span>
            seconds... 💗
        </div>

    </main>

    <script src="../reusables/redirect.js"></script>

    <script>
        let h1 = document.getElementById("h1");
        ToMainTimeout(4, h1);
    </script>

</body>
</html>
