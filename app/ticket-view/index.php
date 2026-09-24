
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="../general-style.css">
        <link rel="stylesheet" href="index.css">
        <title>Ticket View</title>
    </head>

    <?php require "../includes/header.php"; ?>

    <body>
        <?php require "../includes/nav.php"; ?>
        <?php require "../includes/loginLock.php"; ?>
        <?php LoginLock("admin"); ?>

        <main>

            <!-- Section 1: Ticket information -->
            <section class="ticket-section">
                <h2>Ticket Information</h2>

                <div class="ticket-info">
                    <p><strong>Ticket ID:</strong> #1001</p>
                    <p><strong>Header:</strong> Something is broken</p>
                    <p><strong>Created by:</strong> Martin Martini Martinsen</p>
                    <p><strong>Created:</strong> 2026-09-17 18:42</p>
                    <p><strong>Last update:</strong> 2026-09-17 20:31</p>
                </div>
            </section>


            <!-- Section 2: Ticket status -->
            <section class="ticket-section">
                <h2>Status</h2>

                <div class="status-container">
                    <span class="status-label">Current status</span>

                    <span class="status open">
                        Open
                    </span>
                </div>
            </section>


            <!-- Section 3: Ticket messages -->
            <section class="ticket-section messages-section">
                <h2>Messages</h2>

                <div class="messages">

                    <!-- Message from user -->
                    <div class="message message-left">
                        <div class="message-header">
                            <span class="message-sender">Martin Martini Martinsen</span>
                            <span class="message-date">2026-09-17 18:42</span>
                        </div>

                        <div class="message-body">
                            Something is broken and I can't figure out what is
                            causing the problem. It stopped working earlier today.
                        </div>
                    </div>


                    <!-- Message from admin -->
                    <div class="message message-right">
                        <div class="message-header">
                            <span class="message-sender">Admin</span>
                            <span class="message-date">2026-09-17 19:15</span>
                        </div>

                        <div class="message-body">
                            Thanks for reporting this. I'll take a look at the
                            issue and get back to you.
                        </div>
                    </div>


                    <!-- Another user message -->
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
            </section>

        </main>

    </body>

    <?php require "../includes/footer.php"; ?>
</html>
