<html>
    <head>
        <meta charset='utf-8'>
        <link rel="stylesheet" href="../general-style.css">
        <link rel="stylesheet" href="index.css">
    </head>
    <header><title>Admin Dash</title><h1>Ticketto System</h1></header>
    <body>
        <?php require "../includes/nav.php"; ?>
        <?php require "../includes/loginLock.php"; ?>
        <?php LoginLock("admin"); ?>
        
        <main>
            <section><h2>First section</h2></section>
            <section>
                <h2>A tactical form</h2>
                <form>
                    <input type="text" placeholder="Rawr"></input>
                    <input type="password" placeholder="Passowrd"></input>
                    <input type="submit"></input>
                </form>
            </section>    
            <section><button>Clicky button</button></section>
            <aside>
                <span>Aside content 1</span><br>
                <span>Aside content 2</span><br>
                <button>Clicky button</button>
            </aside>
        </main>
        
    </body>
        <?php require "../includes/footer.php"; ?>


</html>