document.addEventListener("DOMContentLoaded", function () {
  var countdownElem = document.getElementById("countdown");
  if (!countdownElem) return;

  var remaining = parseInt(countdownElem.textContent, 10);
  if (isNaN(remaining) || remaining <= 0) return;

  var wrapper = document.getElementById("countdown-wrapper");
  var container = document.getElementById("resend-container");

  var timer = setInterval(function () {
    remaining--;

    if (remaining > 0) {
      countdownElem.textContent = remaining;
    } else {
      clearInterval(timer);

      if (wrapper) wrapper.remove();

      var btn = document.createElement("button");
      btn.type = "submit";
      btn.name = "action";
      btn.value = "resend_email";
      btn.setAttribute("formnovalidate", "");
      btn.className =
        "font-medium text-gray-400 hover:underline bg-transparent border-none p-0 cursor-pointer";
      btn.textContent = "Resend the email";

      if (container) {
        container.appendChild(btn);
      }
    }
  }, 1000);
});

document.addEventListener("keydown", function (event) {
  if (event.key === "Enter") {
    event.preventDefault();
    var nextBtn = document.getElementById("nextBtn");
    if (nextBtn) nextBtn.click();
  }
});