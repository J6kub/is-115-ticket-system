
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="../general-style.css">
        <link rel="stylesheet" href="index.css">
        <title>Admin Dash</title>
    </head>

    <?php require "../includes/header.php"; ?>

    <body>
        <?php require "../includes/nav.php"; ?>
        <?php require "../includes/loginLock.php"; ?>
        <?php LoginLock("admin"); ?>

        <main>

            <!-- Section 1 -->
            <section class="dashboard-section">
                <h2>Admin dashboard</h2>
                <p>Welcome back, Joe Momorini </p>
                <p>There are <strong>55</strong> tickets waiting for your response</p>
            </section>

            <!-- Section 2 -->
            <section class="dashboard-section">
                <h2 id="ticketto-touretto">
                    <span>Tickets</span>

                    <div class="ticket-search">
                        <input type="text" id="searchy" onkeyup="MayTheSearchBarCallThis(this.value)" placeholder="Search tickets...">
                        <input value="null" id="searchy_filter" style="display:none">
                        <button type="button" onclick="setActiveFilter('case_name',this);" class="search-filter active">Case Name</button>
                        <button type="button" onclick="setActiveFilter('case_desc',this);" class="search-filter">Case Description</button>
                        <button type="button" onclick="setActiveFilter('FullName',this);" class="search-filter">Submitted by</button>
                    </div>
                </h2>

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

                    <tbody id='teeBodi'>
                        
                       
                        
                    </tbody>
                </table>
            </section>

            <!-- Section 3 -->
            <section class="dashboard-section">
                <h2>4s</h2>
                <p>Tekst bare litt lenger nede</p>
            </section>

        </main>

    </body>
    <script src="./index.js">
       
        </script>
        <script>
             window.onload = async () => {
            await MayTheSearchBarCallThis("");
        }
            </script>
    <?php require "../includes/footer.php"; ?>
</html>
