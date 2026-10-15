function ToMainTimeout(seconds = 5, viewElement = null) {
    let Intervallo;
    let timer = seconds;
    if (viewElement != null) {
        Intervallo = setInterval(() => {viewElement.innerHTML = `Redirecting in: ${timer}`; timer--},1000)
    }
    setTimeout(() => {
        location.href = "../main-page"    
    }, (seconds*1000) + 300);
    
}