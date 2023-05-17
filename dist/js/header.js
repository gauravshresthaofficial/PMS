function updateTime() {
    var currentTime = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: true }).toLowerCase();
    document.getElementById("current-time").textContent = currentTime;
}

setInterval(updateTime, 15000);

