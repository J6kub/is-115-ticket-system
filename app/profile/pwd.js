function setupUnhidables() {
    const unhidables = Array.from(document.getElementsByClassName("unhidable"));

    unhidables.forEach(el => {
        console.log(el);
        const butty = el.nextElementSibling;
        butty.addEventListener("mousedown", ()=>{el.type="text"})
        butty.addEventListener("mouseup", ()=>{el.type="password"})
    });
}

window.onload = () => {
    setupUnhidables();
}