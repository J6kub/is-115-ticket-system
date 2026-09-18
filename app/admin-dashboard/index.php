
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="../general-style.css">
        <link rel="stylesheet" href="index.css">
        <title>Admin Dash</title>
    </head>

    <header>
        <h1>Ticketto System</h1>
    </header>

    <body>
        <?php require "../includes/nav.php"; ?>
        <?php require "../includes/loginLock.php"; ?>
        <?php LoginLock("admin"); ?>

        <main>

            <!-- Section 1 -->
            <section class="dashboard-section">
                <h2>First section</h2>
                <p>Some bullshit admin dashboard content goes here.</p>
            </section>

            <!-- Section 2 -->
            <section class="dashboard-section">
                <h2>Tickets</h2>

                <table class="ticket-table">
                    <thead>
                        <tr>
                            <th>Ticket ID</th>
                            <th>Ticket Header</th>
                            <th>Created By</th>
                            <th>Last Update</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        
                        <tr onclick='location.href="../ticket-view"'>
                            <td>#1001</td>
                            <td>Example ticket</td>
                            <td>John Doe</td>
                            <td>2026-09-17 20:31</td>
                            <td><span class="status open">Open</span></td>
                        </tr>
                        </a>
                        
                        <tr onclick='location.href="../ticket-view"'>
                            <td>#1002</td>
                            <td>Something is broken</td>
                            <td>Martin Martini Martinsen</td>
                            <td>2026-09-17 19:12</td>
                            <td><span class="status pending">Pending</span></td>
                        </tr>
                        
                    </tbody>
                </table>
            </section>

            <!-- Section 3 -->
            <section class="dashboard-section">
                <h2>Third section</h2>
                <p>More bullshit goes here.</p>
            </section>

        </main>

    </body>

    <?php require "../includes/footer.php"; ?>
</html>
