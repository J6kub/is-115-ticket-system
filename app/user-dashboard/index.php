<?php
require_once "../includes/classes/user.php";

require_once "../includes/dbconn.php";

$user_id = $_SESSION["user"]->id;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $case_name = $_POST["title"];
    $case_desc = $_POST["description"];

    $sql = "INSERT INTO cases (user_id, priority_id, case_desc, case_name, status_id)
            VALUES ('$user_id', 1, '$case_desc', '$case_name', 1)";

    mysqli_query($conn, $sql);
}
?>
<!DOCTYPE html>
<html lang="no">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../general-style.css">
    <link rel="stylesheet" href="index.css?v=<?= time() ?>">
    <title>Tickets</title>
</head>

<body>

<?php require "../includes/header.php"; ?>
<?php require "../includes/nav.php"; ?>

<main class="ticket-page">

    <h1>Tickets</h1>

    <section class="new-tickets">
        <h2>Nye tickets</h2>

        <?php
        $sql = "SELECT * FROM cases
                WHERE user_id = '$user_id'
                AND status_id != 3
                ORDER BY created_at DESC";

        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <a class="ticket-link" href="../ticket-view/index.php?id=<?= $row["id"] ?>">
                <div class="ticket">
                    <strong>#<?= $row["id"] ?></strong>
                    <p><?= $row["case_name"] ?></p>
                    <span class="status status-open">Åpen</span>
                </div>
            </a>
        <?php
        }
        ?>
    </section>

    <section class="old-tickets">
        <h2>Tidligere tickets</h2>

        <?php
        $sql = "SELECT * FROM cases
                WHERE user_id = '$user_id'
                AND status_id = 3
                ORDER BY created_at DESC";

        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <a class="ticket-link" href="../ticket-view/index.php?id=<?= $row["id"] ?>">
                <div class="ticket">
                    <strong>#<?= $row["id"] ?></strong>
                    <p><?= $row["case_name"] ?></p>
                    <span class="status status-closed">Lukket</span>
                </div>
            </a>
        <?php
        }
        ?>
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