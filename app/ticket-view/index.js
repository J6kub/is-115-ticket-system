function htmlizeMsgs(msgs, meows_attach, caseinfo) {
    let html = "";
    
    msgs.forEach(msg => {
        let attachments;
        if (meows_attach[msg.id] != undefined) {
            attachments = meows_attach[msg.id]
        }
        console.log(attachments);
        if (caseinfo["user_id"] == msg["user_id"])
            html += drawMessage(msg, side="left",attachments=attachments);
        else {
            html += drawMessage(msg,side="right", attachments=attachments);
        }
    });
    return html;

}
function drawAttachment(attach) {
    return `<div class="attachment-card">
        <div class="attachment-icon">
            📎
        </div>

        <div class="attachment-details">
            <div class="attachment-name">
                ${attach["filename"]}
            </div>

            <div class="attachment-meta">
                FILE_TYPE · ${Number(attach["file_size"])/1000 } kb
            </div>
        </div>

        <a href="./Download.php?element=${attach["hash_id"]}" class="attachment-download" title="Download">
            ↓
        </a>
    </div>`
}

function drawMessage(msg,side="left", attachments = null) {
    attachmentsHTML = "";
    if (attachments != null) {
        attachments.forEach((attach) => {attachmentsHTML += drawAttachment(attach)})
    }

    return `<div class="message message-${side}">
        <div class="message-header">
            <span class="message-sender">${msg["FullName"]}</span>
            <span class="message-date">${msg["created_at"]}}</span>
        </div>

        <div class="message-body">
            ${msg["message"]}
        </div>
        <div id="meow_${msg["id"]}">
            ${attachmentsHTML}
        </div>

    </div>`
}

async function sendMsg(msg, case_id) {
    const response = await fetch("SendMsg.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            msg: msg,
            case_id: case_id
        })
    });

    return await response.json();
}