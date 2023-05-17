function updateTime() {
    var currentTime = new Date();
    var hours = currentTime.getHours();
    var minutes = currentTime.getMinutes();
    var seconds = currentTime.getSeconds();
    var amPM = hours >= 12 ? "PM" : "AM";
  
    // Convert 24-hour format to 12-hour format
    hours = hours % 12 || 12;
  
    // Format the time with leading zeros if needed
    var formattedTime = leadingZero(hours) + ":" + leadingZero(minutes);
    var formattedSeconds = leadingZero(seconds);
  
    document.getElementById("time").textContent = formattedTime;
    document.getElementById("seconds").textContent = formattedSeconds;
    document.getElementById("am-pm").textContent = amPM;
  }
  
  function leadingZero(number) {
    return number < 10 ? "0" + number : number;
  }
  
  // Update the time every second
  setInterval(updateTime, 1000);
  