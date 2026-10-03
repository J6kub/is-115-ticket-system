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

    <?php 
        require "../includes/dbconn.php";


        $result = $conn->query("SELECT * FROM case_overview where id=" . $_GET["id"]);

        $case = $result->fetch_assoc();
        //print_r($case);
        $caseMessages = array();
        $result = $conn->query("SELECT * FROM case_message_overview where case_id=" . $_GET["id"]);
        while ($casemsg = $result->fetch_assoc()) {
            //echo "<br>";
            //print_r($casemsg);
            array_push($caseMessages,$casemsg);
        }
        $caseMsgAttachments = array();
        
        $result = $conn->query("SELECT message_id,hash_id,filename,file_size FROM case_message_overview_attachments where case_id=" . $_GET["id"]);
        while ($casemsg = $result->fetch_assoc()) {
            //echo "<br>";
            //print_r($casemsg);
            array_push($caseMsgAttachments,$casemsg);
        }
        
    ?>

    <main class="ticket-view">

        <div class="ticket-left">

            <section class="ticket-section ticket-information">

                <h2>Ticket Information</h2>

                <div class="ticket-info">
                    <?php
                    echo '
                    <div class="info-item">
                        <span>Ticket ID</span>
                        <p>' . $case["id"] .'</p>
                    </div>

                    <div class="info-item">
                        <span>Created</span>
                        <p>' . $case["created_at"] .'</p>
                    </div>

                    <div class="info-item">
                        <span>Header</span>
                        <p>' . $case["case_name"] .'</p>
                    </div>

                    <div class="info-item">
                        <span>Last update</span>
                        <p>' . $case["updated_at"] .'</p>
                    </div>
                
                </div>

                <div class="ticket-description">
                    <span>Description</span>

                    <p>
                        ' . $case["case_desc"] .'
                    </p>
                </div>'
                ?>
            </section>

            <section class="ticket-section messages-section">

                <h2>Activity</h2>

                <div class="messages" id='msgs'>

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

                <form action=none class="comment-form">

                    <textarea
                        id="sendMsgTxt"
                        name="comment"
                        placeholder="Write a comment..."
                    ></textarea>
                    <div class="attachment-section">

                        <label for="attachmentInput" class="attachment-button">
                            📎 Add attachments
                        </label>

                        <input
                            type="file"
                            id="attachmentInput"
                            multiple
                            hidden
                        >

                    <div id="attachmentList" class="attachment-list"></div>
                    </div>
                    <button type='button' id="sendButton">Send comment</button>

                </form>

            </section>

        </div>

        <aside class="ticket-sidebar">

            <div class="sidebar-item">

                <span class="sidebar-label">Status</span>

                <span class="status open">
                    <?php echo $case["Status"] ?>
                </span>

            </div>

            <div class="sidebar-item">

                <span class="sidebar-label">Requested by</span>

                <p><?php echo $case["FullName"] ?></p>

            </div>

            <div class="sidebar-item">

                <span class="sidebar-label">Shared with</span>

                <p>Customer Support</p>

            </div>

        </aside>

    </main>

    <?php require "../includes/footer.php"; ?>

</body>
<script src="./index.js"></script>
<script src="./attachments.js"></script>
<script>
    let msgElement = document.getElementById("msgs");
    const meows = <?php echo json_encode($caseMessages); ?>;
    const case_info = <?php echo json_encode($case); ?>;
    const meows_attach = <?php echo json_encode($caseMsgAttachments); ?>;
    let meows_grouped = {};
    meows_attach.forEach((el) => {
        if (meows_grouped[el.message_id] == undefined) {
            meows_grouped[el.message_id] = [el]
        } else {
            meows_grouped[el.message_id].push(el);
        }
    })

    msgElement.innerHTML = htmlizeMsgs(meows,meows_grouped, case_info);


    const txtArea = document.getElementById("sendMsgTxt")
    const sendButton = document.getElementById("sendButton")

    sendButton.addEventListener("click", async () => {

        const res = await sendMsg(
            txtArea.value,
            Number(case_info["id"])
        );

        if (res.success !== true) {
            alert("Problem sending message");
            return;
        }

        const messageId = res.data.message_id;

        for (const file of selectedAttachments) {

            const formData = new FormData();

            formData.append("message_id", messageId);
            formData.append("attachment", file);

            const uploadRes = await fetch("UploadAttachment.php", {
                method: "POST",
                body: formData
            });

            const uploadResult = await uploadRes.json();

            if (!uploadResult.success) {
                console.error(
                    "Failed to upload:",
                    file.name
                );
            }
        }
        setTimeout(() => {
            location.href = location.href;
        }, 200);
        
    });
</script>

</html>