<!DOCTYPE html>
<html lang="no">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="../general-style.css">
        <link rel="stylesheet" href="index.css"> <title>Mine tickets</title>
</head>

<body>
  <?php require "../includes/nav.php"; ?>
        <?php require "../includes/loginLock.php"; ?>
        <?php LoginLock("user"); ?>
    <main>

        <section>
            <h2>Mine tickets</h2>

            <p>
                <strong>#101</strong><br>
                Problem med innlogging<br>
                <span>Status: Åpen</span>
            </p>

            <p>
                <strong>#102</strong><br>
                Får ikke lastet opp fil<br>
                <span>Status: Under behandling</span>
            </p>
        </section>

        <section>
            <h2>Ferdige tickets</h2>

            <p>
                <strong>#98</strong><br>
                Glemt passord<br>
                <span>Status: Løst</span>
            </p>
        </section>

        <aside>
            <h2>Opprett ny ticket</h2>

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

                <input
                    type="text"
                    name="description"
                    placeholder="Beskriv problemet"
                    required
                >

                <input type="submit" value="Opprett ticket">

            </form>
        </aside>

    </main>

    <footer>
        Ticket System
    </footer>

</body>

</html>