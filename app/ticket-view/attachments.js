const attachmentInput = document.getElementById("attachmentInput");
const attachmentList = document.getElementById("attachmentList");

let selectedAttachments = [];


attachmentInput.addEventListener("change", () => {

    for (const file of attachmentInput.files) {

        // Don't add the exact same file twice
        const alreadyExists = selectedAttachments.some(
            existing =>
                existing.name === file.name &&
                existing.size === file.size &&
                existing.lastModified === file.lastModified
        );

        if (!alreadyExists) {
            selectedAttachments.push(file);
        }
    }

    renderAttachments();

    // Reset input so selecting the same file again
    // triggers the change event
    attachmentInput.value = "";
});


function renderAttachments() {

    attachmentList.innerHTML = "";

    selectedAttachments.forEach((file, index) => {

        const attachment = document.createElement("div");
        attachment.className = "attachment-item";

        attachment.innerHTML = `
            <span class="attachment-name">
                ${escapeHtml(file.name)}
            </span>

            <span class="attachment-size">
                ${formatFileSize(file.size)}
            </span>

            <button
                type="button"
                class="attachment-remove"
                data-index="${index}"
            >
                ×
            </button>
        `;

        attachmentList.appendChild(attachment);
    });
}


attachmentList.addEventListener("click", (event) => {

    if (!event.target.classList.contains("attachment-remove")) {
        return;
    }

    const index = Number(event.target.dataset.index);

    selectedAttachments.splice(index, 1);

    renderAttachments();
});


function formatFileSize(bytes) {

    if (bytes < 1024) {
        return `${bytes} B`;
    }

    if (bytes < 1024 * 1024) {
        return `${(bytes / 1024).toFixed(1)} KB`;
    }

    return `${(bytes / (1024 * 1024)).toFixed(1)} MB`;
}


function escapeHtml(text) {

    const div = document.createElement("div");
    div.textContent = text;

    return div.innerHTML;
}