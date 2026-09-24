<html>
    <head>
        <meta charset='utf-8'>
        <link rel="stylesheet" href="../general-style.css">
        <link rel="stylesheet" href="index.css">
    </head>
    <?php require "../includes/header.php"; ?>
    <body>
        <?php require "../includes/nav.php"; ?>
        <main>
            <section><h2>Register new user</h2>
                <p>For simplicity, Admin user can be just registered through here!</p>
            </section><br>
            <section>
                <h2>A tactical registration form</h2>
                <form action="register.php" method="post">
                    <input required name="firstname" type="text" placeholder="First name"></input>
                    <input required name="lastname" type="text" placeholder="Last Name"></input>
                    <input required name="email" type="text" placeholder="Email"></input>
                    <input required name="password" type="password" placeholder="Password"></input>
                    <select required name="role">
                        <option value="" disabled selected>-- Select role --</option>
                        <option value="1">User</option>
                        <option value="3">Employee</option>
                        <option value="2">Admin</option>
                    </select>
                    <input type="submit"></input>
                </form>
            </section>    

        </main>
        <?php require "../includes/footer.php"; ?>
    </body>


</html>