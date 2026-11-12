<?php
require_once "../includes/classes/user.php";

require_once "../includes/dbconn.php";
session_start();
// Get the logged-in user ID.
$user_id = $_SESSION["user"]->id;


?>
<!DOCTYPE html>
<html lang="en">

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
        <h2>New tickets</h2>

        <?php
        // Get open and in-progress tickets for this user, newest first.
        $sql = "SELECT * FROM cases
                WHERE user_id = '$user_id'
                AND status_id != 3
                ORDER BY created_at DESC";

        $result = mysqli_query($conn, $sql);

        // Show the user's tickets.
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <a class="ticket-link" href="../ticket-view/index.php?id=<?= $row["id"] ?>">
                <div class="ticket">
                    <strong>#<?= $row["id"] ?></strong>
                    <p><?= $row["case_name"] ?></p>
                    <span class="status status-open">Open</span>
                </div>
            </a>
        <?php
        }
        ?>
    </section>

    <section class="old-tickets">
        <h2>Past tickets</h2>

        <?php
        // Get closed tickets for this user (status ID 3).
        $sql = "SELECT * FROM cases
                WHERE user_id = '$user_id'
                AND status_id = 3
                ORDER BY created_at DESC";

        $result = mysqli_query($conn, $sql);

            // Show the user's closed tickets.
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <a class="ticket-link" href="../ticket-view/index.php?id=<?= $row["id"] ?>">
                <div class="ticket">
                    <strong>#<?= $row["id"] ?></strong>
                    <p><?= $row["case_name"] ?></p>
                    <span class="status status-closed">Closed</span>
                </div>
            </a>
        <?php
        }
        ?>
    </section>
    
    <aside class="new-ticket">
        <h2>Create a ticket</h2>

        <form action="" method="post">

            <input
                type="text"
                name="title"
                placeholder="Title"
                required
            >

            <select name="category" required>
                <option value="">Choose a category</option>
                <option value="technical">Technical problem</option>
                <option value="account">User account</option>
                <option value="other">Other</option>
            </select>

            <textarea
                name="description"
                placeholder="Describe the problem"
                required
            ></textarea>

            <input
                type="submit"
                value="Create ticket"
            >

        </form>
    </aside>

</main>

<footer>
    <?php require "../includes/footer.php"; ?>
</footer>

</body>

</html>