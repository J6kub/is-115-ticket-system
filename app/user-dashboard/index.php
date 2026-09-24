<!DOCTYPE html>
<html lang="no">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../general-style.css">
    <link rel="stylesheet" href="index.css?v=<?= time() ?>">
    <title>Tickets</title>
</head>
<?php require "../includes/header.php"; ?>
<body>

    <?php require "../includes/nav.php"; ?>
    <?php require "../includes/loginLock.php"; ?>
    <?php LoginLock("user"); ?>

    <main class="ticket-page">

        <h1>Tickets</h1>
<section class="new-tickets">
    <h2>Nye tickets</h2>

    <a class="ticket-link" href="../ticket-view/index.php?id=101">
        <div class="ticket">
            <strong>#101</strong>
            <p>Problem med innlogging</p>
            <span class="status status-open">Åpen</span>
        </div>
    </a>

    <a class="ticket-link" href="../ticket-view/index.php?id=102">
        <div class="ticket">
            <strong>#102</strong>
            <p>Får ikke lastet opp fil</p>
            <span class="status status-progress">In progress</span>
        </div>
    </a>
</section>

<section class="old-tickets">
    <h2>Tidligere tickets</h2>

    <a class="ticket-link" href="../ticket-view/index.php?id=98">
        <div class="ticket">
            <strong>#98</strong>
            <p>Glemt passord</p>
            <span class="status status-closed">Lukket</span>
        </div>
    </a>
</section>

        <aside class="new-ticket">
            <h2>Lag ny case</h2>

            <form action="" method="post">

                <input
                    type="text"
                    name="title"
                    placeholder="Tittel"
                    required
                >

                <select name="category" required>
                    <option value="">Velg kategori</option>
                    <option value="technical">Teknisk problem</option>
                    <option value="account">Brukerkonto</option>
                    <option value="other">Annet</option>
                </select>

                <textarea
                    name="description"
                    placeholder="Beskriv problemet"
                    required
                ></textarea>

                <input
                    type="submit"
                    value="Opprett case"
                >

            </form>
        </aside>

    </main>

    <footer>
       <?php require "../includes/footer.php"; ?>
    </footer>

</body>

</html>