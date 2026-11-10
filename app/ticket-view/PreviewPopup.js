
// Global popup registry
window.popups = window.popups || [];
const popups = window.popups;

class PreviewPopup {
    constructor(element, data) {
        this.element = element;
        this.data = data;
        this.object = null;
        this.dragging = false;
        this.dragOffsetX = 0;
        this.dragOffsetY = 0;
        this.imgsrc = `Preview.php?element=${encodeURIComponent(this.element)}`;
        this.spawn();
        
    }

    spawn() {
       
        document.body.insertAdjacentHTML("beforeend", `
            <div class="ppu-container">
                <div class="ppu-header">
                    <span class="ppu-filename"></span>
                    <button class="ppu-killer">×</button>
                </div>
                <div class="ppu-content">
                    <img src=${this.imgsrc} class="ppu-image" alt="File preview">
                </div>
            </div>
        `);

        const popup = document.body.lastElementChild;
        const img = popup.querySelector(".ppu-image");

        setTimeout(async () => {img.src = this.imgsrc},30)
        

        popup.querySelector(".ppu-filename").textContent = this.data.filename;

        // Each instance owns its own element
        this.object = document.body.lastElementChild;

        // Set filename safely
        const filename = this.data?.filename
            || this.element?.textContent?.trim()
            || "File preview";

        this.object.querySelector(".ppu-filename").textContent = filename;

        // Set image source
        const image = this.object.querySelector(".ppu-image");
        image.src = typeof this.data === "string"
            ? this.data
            : this.data.url;

        // Close only this popup
        const killer = this.object.querySelector(".ppu-killer");

        killer.addEventListener("click", () => this.kill());

        killer.addEventListener("keydown", (event) => {
            if (event.key === "Enter" || event.key === " ") {
                event.preventDefault();
                this.kill();
            }
        });
        // Drag support
        const header = this.object.querySelector(".ppu-header");

        header.addEventListener("pointerdown", (event) => {
            // Don't start dragging when clicking the close button
            if (event.target.closest("button")) return;
            if (event.button !== 0) return;

            const rect = this.object.getBoundingClientRect();

            // Convert centered positioning to absolute viewport coordinates
            this.object.style.left = `${rect.left}px`;
            this.object.style.top = `${rect.top}px`;
            this.object.style.transform = "none";

            this.dragging = true;
            this.dragOffsetX = event.clientX - rect.left;
            this.dragOffsetY = event.clientY - rect.top;

            header.setPointerCapture(event.pointerId);
            header.style.cursor = "grabbing";
        });

        header.addEventListener("pointermove", (event) => {
            if (!this.dragging) return;

            const width = this.object.offsetWidth;
            const height = this.object.offsetHeight;

            // Keep at least part of the window on screen
            const x = event.clientX - this.dragOffsetX;
            const y = event.clientY - this.dragOffsetY;

            this.object.style.left = `${Math.max(
                40 - width,
                Math.min(x, window.innerWidth - 40)
            )}px`;

            this.object.style.top = `${Math.max(
                0,
                Math.min(y, window.innerHeight - 40)
            )}px`;
        });

        const stopDragging = () => {
            this.dragging = false;
            header.style.cursor = "grab";
        };

        header.addEventListener("pointerup", stopDragging);
        header.addEventListener("pointercancel", stopDragging);
        header.addEventListener("lostpointercapture", stopDragging);

        // Register this instance globally
        popups.push(this);
    }

    kill() {
        console.log("killing");
        if (!this.object) return;

        this.object.remove();

        // Remove only this instance from the global registry
        const index = popups.indexOf(this);
        if (index !== -1) {
            popups.splice(index, 1);
        }

        this.object = null;
    }
}
