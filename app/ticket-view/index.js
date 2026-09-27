function htmlizeMsgs(msgs, caseinfo) {
    let html = "";
    msgs.forEach(msg => {
        if (caseinfo["user_id"] == msg["user_id"])
            html += drawMessage(msg);
        else {
            html += drawMessage(msg,"right");
        }
    });
    return html;

}
function drawMessage(msg,side="left") {
    return `<div class="message message-${side}">
        <div class="message-header">
            <span class="message-sender">${msg["FullName"]}</span>
            <span class="message-date">${msg["created_at"]}}</span>
        </div>

        <div class="message-body">
            ${msg["message"]}
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