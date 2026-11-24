
<?php
require "../includes/loginLock.php";
LoginLock(["admin","employee"]);
?>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="../general-style.css">
        <link rel="stylesheet" href="index.css">
        <title>Admin Dash</title>
    </head>

    <?php require "../includes/header.php"; ?>
    <?php 
    // last ticket section
    $lastTicketSection = "";
    if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    $uid = $_SESSION["user"]->id;
        
    if (isset($_COOKIE["lastTicket-" . $uid])) {
        // grab case
        require "../includes/dbconn.php";
        $result = $conn->query("SELECT * FROM case_overview where id=" . $_COOKIE["lastTicket-" . $uid]);

        $case = $result->fetch_assoc();

        $lastTicketSection = '<section class="dashboard-section">
                <h2>Go to your last case:</h2>
                <table class="ticket-table">
                <tr style="background-color:#f3f3f3">
                    
                    <td>Ticket id</td>
                    <td>Ticket Header</td>
                    <td>Created By</td>
                    <td>Last Update</td>
                    <td>Status</td>
                </tr>
                <tr onclick="location.href=`../ticket-view/index.php?id=' . $_COOKIE["lastTicket-" . $uid] . '`";>
                    <td>' . $case["id"] . '</td>
                    <td>' . $case["case_name"] . '</td>
                    <td>' . $case["FullName"] . '</td>
                    <td>' . $case["updated_at"] . '</td>
                    <td>' . $case["Status"] . '</td>
                </tr>
                </table>
            </section>';
    }
    ?>
    <body>
        <?php require "../includes/nav.php"; ?>

        <main>

            <!-- Section 1 -->
            <section class="dashboard-section">
                <h2>Admin dashboard</h2>
                <p>Welcome back, Joe Momorini </p>
                <p>There are <strong>55</strong> tickets waiting for your response</p>
            </section>
            <?php echo $lastTicketSection; ?>
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
                <h2>Just an section for later</h2>
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
