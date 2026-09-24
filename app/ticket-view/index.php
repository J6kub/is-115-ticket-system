<!DOCTYPE html>
<html lang="no">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../general-style.css">
    <link rel="stylesheet" href="index.css">
    <title>Ticket View</title>
</head>

    <?php require "../includes/header.php"; ?>
<body>

    <?php require "../includes/nav.php"; ?>
    <?php require "../includes/loginLock.php"; ?>
    <?php LoginLock("user"); ?>

    <main class="ticket-view">

        <div class="ticket-left">

            <section class="ticket-section ticket-information">

                <h2>Ticket Information</h2>

                <div class="ticket-info">

                    <div class="info-item">
                        <span>Ticket ID</span>
                        <p>#1001</p>
                    </div>

                    <div class="info-item">
                        <span>Created</span>
                        <p>2026-09-17 18:42</p>
                    </div>

                    <div class="info-item">
                        <span>Header</span>
                        <p>Something is broken</p>
                    </div>

                    <div class="info-item">
                        <span>Last update</span>
                        <p>2026-09-17 20:31</p>
                    </div>

                </div>

                <div class="ticket-description">
                    <span>Description</span>

                    <p>
                        Something is broken and I can't figure out what is causing the problem.
                        It stopped working earlier today.
                    </p>
                </div>

            </section>

            <section class="ticket-section messages-section">

                <h2>Activity</h2>

                <div class="messages">

                    <div class="message message-left">

                        <div class="message-header">
                            <span class="message-sender">Martin Martini Martinsen</span>
                            <span class="message-date">2026-09-17 18:42</span>
                        </div>

                        <div class="message-body">
                            Something is broken and I can't figure out what is causing the problem.
                            It stopped working earlier today.
                        </div>

                    </div>

                    <div class="message message-right">

                        <div class="message-header">
                            <span class="message-sender">Admin</span>
                            <span class="message-date">2026-09-17 19:15</span>
                        </div>

                        <div class="message-body">
                            Thanks for reporting this. I'll take a look at the issue and get back to you.
                        </div>

                    </div>

                    <div class="message message-left">

                        <div class="message-header">
                            <span class="message-sender">Martin Martini Martinsen</span>
                            <span class="message-date">2026-09-17 20:31</span>
                        </div>

                        <div class="message-body">
                            Sounds good, thanks!
                        </div>

                    </div>

                </div>

                <form class="comment-form">

                    <textarea
                        name="comment"
                        placeholder="Write a comment..."
                    ></textarea>

                    <button type="submit">Send comment</button>

                </form>

            </section>

        </div>

        <aside class="ticket-sidebar">

            <div class="sidebar-item">

                <span class="sidebar-label">Status</span>

                <span class="status open">
                    Open
                </span>

            </div>

            <div class="sidebar-item">

                <span class="sidebar-label">Requested by</span>

                <p>Martin Martini Martinsen</p>

            </div>

            <div class="sidebar-item">

                <span class="sidebar-label">Shared with</span>

                <p>Customer Support</p>

            </div>

        </aside>

    </main>

    <?php require "../includes/footer.php"; ?>

</body>

</html>