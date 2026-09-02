<!DOCTYPE html>
<html lang="en">
<head>
    <head>
        <meta charset='utf-8'>
        <link rel="stylesheet" href="../general-style.css">
        
    </head>
    <header><title>Admin Dash</title><h1>Ticketto System</h1></header>
    <body>
    <?php require "../includes/nav.php"; ?>
    <main>

    <section>
        <h1>Logg inn</h1>
        <form method="POST" action="login.php">
            <input required name="email" type="text" placeholder="Email"></input>
            <input required name="password" type="password" placeholder="Password"></input>
            <button type="submit">GO!</button>
        </form>
    </section>
</main>

</body>
<?php require "../includes/footer.php"; ?>

</html>